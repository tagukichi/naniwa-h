<?php
/**
 * Plugin Name: なにわ メディア取り込み
 * Description: 旧サイトからメディアファイルだけを HTTP 経由で取得する移行用ツール。DB（添付ファイルの登録情報）は取り込み済みで、実ファイルだけが無い状態を想定しています。移行が終わったらこのファイルを削除してください。
 * Version: 1.0.0
 * Author: なにわ引越センター
 *
 * 使い方:
 *   1. このファイルを wp-content/mu-plugins/ に置く（フォルダが無ければ作成）
 *   2. 管理画面「ツール → メディア取り込み」を開く
 *   3. 旧サイトのアップロードURLを入れて実行
 *
 * 既に存在するファイルはスキップするため、途中で止まっても
 * 何度でも安全に再実行できます。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

const NANIWA_MF_SLUG   = 'naniwa-media-fetch';
const NANIWA_MF_OPTION = 'naniwa_media_fetch_base';

/**
 * ツールメニューに追加する。
 */
function naniwa_mf_menu() {
	add_management_page(
		'メディア取り込み',
		'メディア取り込み',
		'manage_options',
		NANIWA_MF_SLUG,
		'naniwa_mf_page'
	);
}
add_action( 'admin_menu', 'naniwa_mf_menu' );

/**
 * 添付ファイルの総数を返す。
 *
 * @return int
 */
function naniwa_mf_total() {
	$counts = (array) wp_count_posts( 'attachment' );
	return array_sum( array_map( 'intval', $counts ) );
}

/**
 * 1件の添付ファイルについて、取得すべき相対パスの一覧を返す。
 *
 * オリジナル画像に加えて、登録済みのサムネイルサイズも対象にする。
 *
 * @param int $attachment_id 添付ファイルID.
 * @return array<int, string>
 */
function naniwa_mf_paths( $attachment_id ) {
	$file = get_post_meta( $attachment_id, '_wp_attached_file', true );
	if ( ! $file ) {
		return array();
	}

	$paths = array( $file );
	$meta  = wp_get_attachment_metadata( $attachment_id );

	if ( ! empty( $meta['sizes'] ) && is_array( $meta['sizes'] ) ) {
		$dir = ltrim( dirname( $file ), '.' );
		$dir = '' === $dir ? '' : trailingslashit( $dir );
		foreach ( $meta['sizes'] as $size ) {
			if ( ! empty( $size['file'] ) ) {
				$paths[] = $dir . $size['file'];
			}
		}
	}

	return array_unique( $paths );
}

/**
 * 1バッチ分を処理する。
 *
 * @param string $base   旧サイトの uploads ベースURL.
 * @param int    $offset 開始位置.
 * @param int    $limit  1回あたりの件数.
 * @return array{done:int, fetched:int, skipped:int, failed:array<int, string>}
 */
function naniwa_mf_run( $base, $offset, $limit ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';

	$ids = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'any',
			'posts_per_page' => $limit,
			'offset'         => $offset,
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);

	$upload  = wp_upload_dir();
	$basedir = untrailingslashit( $upload['basedir'] );
	$base    = untrailingslashit( $base );

	$fetched = 0;
	$skipped = 0;
	$failed  = array();

	foreach ( $ids as $id ) {
		foreach ( naniwa_mf_paths( $id ) as $path ) {
			$local = $basedir . '/' . $path;

			// 既にファイルがあるものは触らない（再実行しても安全）。
			if ( file_exists( $local ) && filesize( $local ) > 0 ) {
				++$skipped;
				continue;
			}

			$url = $base . '/' . str_replace( '%2F', '/', rawurlencode( $path ) );
			$tmp = download_url( $url, 60 );

			if ( is_wp_error( $tmp ) ) {
				$failed[] = $path . '（' . $tmp->get_error_message() . '）';
				continue;
			}

			wp_mkdir_p( dirname( $local ) );

			// rename はテンポラリと保存先が別パーティションだと失敗するため copy で退避する。
			if ( ! @rename( $tmp, $local ) ) {
				if ( ! @copy( $tmp, $local ) ) {
					$failed[] = $path . '（保存に失敗）';
				}
				@unlink( $tmp );
			}

			if ( file_exists( $local ) ) {
				@chmod( $local, 0644 );
				++$fetched;
			}
		}
	}

	return array(
		'done'    => count( $ids ),
		'fetched' => $fetched,
		'skipped' => $skipped,
		'failed'  => $failed,
	);
}

/**
 * 管理画面を出力する。
 */
function naniwa_mf_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '権限がありません。' );
	}

	$total  = naniwa_mf_total();
	$base   = get_option( NANIWA_MF_OPTION, '' );
	$limit  = 20;
	$offset = 0;
	$result = null;

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	$running = isset( $_GET['run'] );
	if ( $running ) {
		check_admin_referer( 'naniwa_mf_run' );

		$base   = isset( $_GET['base'] ) ? esc_url_raw( wp_unslash( $_GET['base'] ) ) : $base;
		$offset = isset( $_GET['offset'] ) ? max( 0, (int) $_GET['offset'] ) : 0;
		$limit  = isset( $_GET['limit'] ) ? max( 1, min( 200, (int) $_GET['limit'] ) ) : 20;

		if ( $base ) {
			update_option( NANIWA_MF_OPTION, $base );
			@set_time_limit( 0 );
			$result = naniwa_mf_run( $base, $offset, $limit );
		}
	}
	// phpcs:enable

	$next_url = '';
	if ( $result && $result['done'] >= $limit ) {
		$next_url = wp_nonce_url(
			add_query_arg(
				array(
					'page'   => NANIWA_MF_SLUG,
					'run'    => 1,
					'base'   => rawurlencode( $base ),
					'offset' => $offset + $limit,
					'limit'  => $limit,
				),
				admin_url( 'tools.php' )
			),
			'naniwa_mf_run'
		);
	}
	?>
	<div class="wrap">
		<h1>メディア取り込み</h1>
		<p>旧サイトからメディアファイルだけを HTTP 経由で取得します。<br>
			<strong>添付ファイルの登録情報（DB）が取り込み済みで、実ファイルだけが無い状態</strong>で使ってください。</p>

		<p>このサイトに登録されている添付ファイル：<strong><?php echo esc_html( number_format_i18n( $total ) ); ?></strong> 件</p>

		<?php if ( $result ) : ?>
			<div class="notice notice-info">
				<p>
					<?php
					printf(
						'%d 〜 %d 件目を処理しました　／　取得 %d　スキップ %d　失敗 %d',
						(int) $offset + 1,
						(int) $offset + (int) $result['done'],
						(int) $result['fetched'],
						(int) $result['skipped'],
						count( $result['failed'] )
					);
					?>
				</p>
			</div>

			<?php if ( $result['failed'] ) : ?>
				<div class="notice notice-warning">
					<p><strong>取得できなかったファイル</strong></p>
					<ul style="margin-left:1.5em;list-style:disc;">
						<?php foreach ( array_slice( $result['failed'], 0, 30 ) as $f ) : ?>
							<li><?php echo esc_html( $f ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( $next_url ) : ?>
				<p><strong>続きを処理しています。このページを閉じないでください…</strong></p>
				<p><a class="button" href="<?php echo esc_url( $next_url ); ?>">自動で進まない場合はこちら</a></p>
				<script>setTimeout(function () { location.href = <?php echo wp_json_encode( $next_url ); ?>; }, 800);</script>
			<?php else : ?>
				<div class="notice notice-success"><p><strong>すべての処理が完了しました。</strong></p></div>
				<p>このあと <code>設定 → パーマリンク</code> を開いて「変更を保存」し、必要に応じてサムネイルを再生成してください。</p>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! $next_url ) : ?>
			<hr>
			<form method="get" action="<?php echo esc_url( admin_url( 'tools.php' ) ); ?>">
				<input type="hidden" name="page" value="<?php echo esc_attr( NANIWA_MF_SLUG ); ?>">
				<input type="hidden" name="run" value="1">
				<?php wp_nonce_field( 'naniwa_mf_run', '_wpnonce', false ); ?>

				<table class="form-table">
					<tr>
						<th scope="row"><label for="naniwa-mf-base">旧サイトのアップロードURL</label></th>
						<td>
							<input type="url" id="naniwa-mf-base" name="base" class="regular-text code"
								value="<?php echo esc_attr( $base ); ?>"
								placeholder="https://example.com/wp-content/uploads" required style="width:32em;">
							<p class="description">
								末尾の <code>/</code> は不要です。<br>
								旧サイトの画像を1枚ブラウザで開いて、URLから <code>/2025/06/xxx.jpg</code> より前の部分をそのまま貼り付けてください。<br>
								WordPress をサブディレクトリに置いている場合は <code>https://example.com/wp/wp-content/uploads</code> のようになります。
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="naniwa-mf-limit">1回あたりの処理件数</label></th>
						<td>
							<input type="number" id="naniwa-mf-limit" name="limit" value="20" min="1" max="200" class="small-text">
							<p class="description">タイムアウトする場合は減らしてください（推奨 10〜30）。</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="naniwa-mf-offset">開始位置</label></th>
						<td>
							<input type="number" id="naniwa-mf-offset" name="offset" value="0" min="0" class="small-text">
							<p class="description">通常は 0 のままで構いません。途中から再開したいときだけ変更します。</p>
						</td>
					</tr>
				</table>

				<?php submit_button( '取り込みを開始する' ); ?>
			</form>

			<h2>補足</h2>
			<ul style="margin-left:1.5em;list-style:disc;">
				<li>既にファイルがあるものはスキップするので、<strong>何度実行しても安全</strong>です。</li>
				<li>途中でブラウザを閉じてしまっても、もう一度「開始」すれば残りだけ取得します。</li>
				<li>オリジナル画像に加えて、登録済みのサムネイルサイズも取得します。</li>
				<li>移行が終わったら <code>wp-content/mu-plugins/naniwa-media-fetch.php</code> を削除してください。</li>
			</ul>
		<?php endif; ?>
	</div>
	<?php
}
