<?php
/**
 * テーマの初期設定・診断画面
 *
 * このテーマは固定ページのスラッグでテンプレートを割り当てるため、
 * 必要なページが正しいスラッグで存在しないと 404 やレイアウト崩れになる。
 * その状態を一覧で確認し、不足分をまとめて作成できるようにする。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * ツールメニューに追加する。
 */
function naniwa_setup_menu() {
	add_management_page(
		'なにわ：初期設定',
		'なにわ：初期設定',
		'manage_options',
		'naniwa-setup',
		'naniwa_setup_page'
	);
}
add_action( 'admin_menu', 'naniwa_setup_menu' );

/**
 * 必要なページが揃っていないときに管理画面で知らせる。
 */
function naniwa_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'tools_page_naniwa-setup' === $screen->id ) {
		return;
	}

	$missing = 0;
	foreach ( naniwa_required_pages() as $slug => $title ) {
		if ( ! get_page_by_path( $slug ) ) {
			++$missing;
		}
	}
	if ( ! $missing ) {
		return;
	}
	?>
	<div class="notice notice-warning">
		<p>
			<strong>NANIWA EXPRESS テーマ：</strong>
			必要な固定ページが <strong><?php echo esc_html( $missing ); ?>件</strong> 不足しています。
			該当ページは 404 になったり、デザインが適用されません。
			<a href="<?php echo esc_url( admin_url( 'tools.php?page=naniwa-setup' ) ); ?>">初期設定を開く</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'naniwa_setup_notice' );

/**
 * 不足しているページをまとめて作成する。
 *
 * @return array{created:array<int, string>, skipped:int}
 */
function naniwa_setup_create_pages() {
	$created = array();
	$skipped = 0;

	foreach ( naniwa_required_pages() as $slug => $title ) {
		if ( get_page_by_path( $slug ) ) {
			++$skipped;
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_content' => '',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			$created[] = $slug;
		}
	}

	flush_rewrite_rules();

	return array(
		'created' => $created,
		'skipped' => $skipped,
	);
}

/**
 * 初期設定画面を出力する。
 */
function naniwa_setup_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '権限がありません。' );
	}

	$result = null;

	if ( isset( $_POST['naniwa_setup_action'] ) ) {
		check_admin_referer( 'naniwa_setup' );
		$action = sanitize_key( wp_unslash( $_POST['naniwa_setup_action'] ) );

		if ( 'create' === $action ) {
			$result = array( 'type' => 'created' ) + naniwa_setup_create_pages();
		} elseif ( 'map' === $action ) {
			$map = array();
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
			$raw = isset( $_POST['naniwa_map'] ) ? (array) wp_unslash( $_POST['naniwa_map'] ) : array();
			foreach ( $raw as $key => $page_id ) {
				$page_id = (int) $page_id;
				if ( $page_id > 0 ) {
					$map[ sanitize_key( $key ) ] = $page_id;
				}
			}
			update_option( NANIWA_PAGE_MAP_OPTION, $map );
			flush_rewrite_rules();
			$result = array( 'type' => 'mapped' );
		} elseif ( 'probe' === $action ) {
			$result = array( 'type' => 'probe', 'rows' => naniwa_setup_probe() );
		} elseif ( 'flush' === $action ) {
			flush_rewrite_rules();
			$result = array( 'type' => 'flushed' );
		}
	}

	$required = naniwa_required_pages();
	$missing  = 0;
	?>
	<div class="wrap">
		<h1>なにわ：初期設定</h1>
		<p>このテーマは<strong>固定ページのスラッグ</strong>でデザインを割り当てます。<br>
			スラッグが一致していないと、そのページは 404 になるか、デザインが当たらない素の状態で表示されます。</p>

		<?php $naniwa_type = is_array( $result ) && isset( $result['type'] ) ? $result['type'] : ''; ?>
		<?php if ( 'created' === $naniwa_type ) : ?>
			<div class="notice notice-success">
				<p>
					<?php
					printf(
						'%d 件のページを作成しました（既存 %d 件はそのままです）。',
						count( $result['created'] ),
						(int) $result['skipped']
					);
					?>
				</p>
				<?php if ( $result['created'] ) : ?>
					<p>作成: <code><?php echo esc_html( implode( '</code>, <code>', $result['created'] ) ); ?></code></p>
				<?php endif; ?>
			</div>
		<?php elseif ( 'mapped' === $naniwa_type ) : ?>
			<div class="notice notice-success"><p>ページの割り当てを保存しました。</p></div>
		<?php elseif ( 'flushed' === $naniwa_type ) : ?>
			<div class="notice notice-success"><p>パーマリンクを再構築しました。</p></div>
		<?php endif; ?>

		<h2>必要な固定ページ</h2>
		<p class="description">スラッグが違っていても自動で対応するページを探します（例：<code>estimate-step1</code> → <code>step1</code>、<code>recruit</code> → <code>recruit2</code>）。<br>
			自動で見つからない場合や、意図と違うページが割り当たっている場合は、右の欄で手動で指定してください。</p>

		<?php
		$all_pages = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => array( 'publish', 'draft', 'private' ),
				'posts_per_page' => 300,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
		$map = (array) get_option( NANIWA_PAGE_MAP_OPTION, array() );
		?>

		<form method="post">
			<?php wp_nonce_field( 'naniwa_setup' ); ?>
			<input type="hidden" name="naniwa_setup_action" value="map">
			<table class="widefat striped">
				<thead>
					<tr>
						<th style="width:18%;">想定スラッグ</th>
						<th style="width:20%;">ページ名</th>
						<th style="width:14%;">状態</th>
						<th style="width:26%;">割り当てられているページ</th>
						<th>手動で指定</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $required as $slug => $title ) :
						$page_id = naniwa_page_id( $slug );
						if ( ! $page_id || 'publish' !== get_post_status( $page_id ) ) {
							++$missing;
						}
						?>
						<tr>
							<td><code><?php echo esc_html( $slug ); ?></code></td>
							<td><?php echo esc_html( $title ); ?></td>
							<?php
							$status  = $page_id ? get_post_status( $page_id ) : '';
							$is_live = ( 'publish' === $status );
							?>
							<td>
								<?php if ( ! $page_id ) : ?>
									<span style="color:#b32d2e;font-weight:600;">✗ ページなし</span>
								<?php elseif ( $is_live ) : ?>
									<span style="color:#146c43;font-weight:600;">✓ OK</span>
								<?php else : ?>
									<span style="color:#b32d2e;font-weight:600;">✗ 404</span><br>
									<span style="color:#b32d2e;font-size:11px;">
										<?php echo esc_html( 'draft' === $status ? '下書きのまま' : '状態: ' . $status ); ?>
									</span>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $page_id ) : ?>
									<?php echo esc_html( get_the_title( $page_id ) ); ?><br>
									<code><?php echo esc_html( str_replace( home_url(), '', get_permalink( $page_id ) ) ); ?></code><br>
									<?php
									// 親ページの下にあると URL が変わるため注意を出す。
									$parent = wp_get_post_parent_id( $page_id );
									if ( $parent ) :
										?>
										<span style="color:#8a6d00;font-size:11px;">
											親ページ「<?php echo esc_html( get_the_title( $parent ) ); ?>」の下にあります
										</span><br>
									<?php endif; ?>
									<a href="<?php echo esc_url( get_permalink( $page_id ) ); ?>" target="_blank">表示</a>　
									<a href="<?php echo esc_url( get_edit_post_link( $page_id ) ); ?>">編集</a>
								<?php else : ?>
									<span style="color:#b32d2e;">見つかりません</span>
								<?php endif; ?>
							</td>
							<td>
								<select name="naniwa_map[<?php echo esc_attr( $slug ); ?>]" style="max-width:100%;">
									<option value="0">（自動で判定）</option>
									<?php foreach ( $all_pages as $one ) : ?>
										<option value="<?php echo esc_attr( $one->ID ); ?>" <?php selected( isset( $map[ $slug ] ) ? (int) $map[ $slug ] : 0, $one->ID ); ?>>
											<?php echo esc_html( get_the_title( $one ) . '（' . urldecode( $one->post_name ) . '）' ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php submit_button( '割り当てを保存する', 'primary' ); ?>
		</form>

		<form method="post" style="margin:22px 0;">
			<?php wp_nonce_field( 'naniwa_setup' ); ?>
			<input type="hidden" name="naniwa_setup_action" value="create">
			<?php
			submit_button(
				$missing ? sprintf( '見つからない %d 件のページを新規作成する', $missing ) : 'ページはすべて揃っています',
				'primary',
				'submit',
				false,
				$missing ? array() : array( 'disabled' => 'disabled' )
			);
			?>
			<p class="description">既にあるページは変更しません。本文は空で作成され、デザインはテンプレート側から出力されます。<br>
				<strong>下書きのままのページは 404 になります。</strong>その場合は「編集」から公開してください。</p>
		</form>

		<?php if ( 'probe' === $naniwa_type ) : ?>
			<h2>URLの応答チェック結果</h2>
			<p class="description">サーバーが実際に返したステータスです。<code>200</code> 以外は原因の切り分けに使えます。</p>
			<table class="widefat striped" style="margin-bottom:24px;">
				<thead><tr><th style="width:18%;">想定スラッグ</th><th style="width:30%;">URL</th><th style="width:12%;">応答</th><th>判定</th></tr></thead>
				<tbody>
					<?php foreach ( $result['rows'] as $row ) : ?>
						<tr>
							<td><code><?php echo esc_html( $row['key'] ); ?></code></td>
							<td><code><?php echo esc_html( $row['path'] ); ?></code></td>
							<td>
								<strong style="color:<?php echo 200 === (int) $row['status'] ? '#146c43' : '#b32d2e'; ?>">
									<?php echo esc_html( $row['status'] ? $row['status'] : 'エラー' ); ?>
								</strong>
							</td>
							<td><?php echo esc_html( $row['note'] ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>

		<h2>その他</h2>
		<form method="post" style="margin-bottom:20px;">
			<?php wp_nonce_field( 'naniwa_setup' ); ?>
			<input type="hidden" name="naniwa_setup_action" value="probe">
			<?php submit_button( 'URLの応答を確認する', 'secondary', 'submit', false ); ?>
			<p class="description">ログインしていない状態と同じ条件で各ページにアクセスし、200 / 301 / 404 などのステータスを確認します。<br>
				リダイレクトプラグインやサーバー側の設定が原因かどうかを切り分けられます。</p>
		</form>
		<form method="post">
			<?php wp_nonce_field( 'naniwa_setup' ); ?>
			<input type="hidden" name="naniwa_setup_action" value="flush">
			<?php submit_button( 'パーマリンクを再構築する', 'secondary', 'submit', false ); ?>
			<p class="description">お客様の声（<code>/voice/</code>）やお知らせ（<code>/topics/</code>）が 404 になるときに実行してください。</p>
		</form>
	</div>
	<?php
}

/**
 * 各ページのURLに実際にアクセスして、応答ステータスを調べる。
 *
 * ログインしていない状態と同じ条件で見るため、Cookie は送らない。
 *
 * @return array<int, array{key:string, path:string, status:int, note:string}>
 */
function naniwa_setup_probe() {
	$rows = array();

	foreach ( naniwa_required_pages() as $key => $title ) {
		$page_id = naniwa_page_id( $key );
		if ( ! $page_id ) {
			continue;
		}

		$url      = get_permalink( $page_id );
		$response = wp_remote_get(
			$url,
			array(
				'timeout'     => 8,
				'redirection' => 0,
				'sslverify'   => false,
				'cookies'     => array(),
				'headers'     => array( 'Cache-Control' => 'no-cache' ),
			)
		);

		if ( is_wp_error( $response ) ) {
			$rows[] = array(
				'key'    => $key,
				'path'   => str_replace( home_url(), '', $url ),
				'status' => 0,
				'note'   => '接続できませんでした：' . $response->get_error_message(),
			);
			continue;
		}

		$status = (int) wp_remote_retrieve_response_code( $response );

		if ( 200 === $status ) {
			$note = '正常';
		} elseif ( in_array( $status, array( 301, 302, 307, 308 ), true ) ) {
			$note = 'リダイレクトされています → ' . wp_remote_retrieve_header( $response, 'location' );
		} elseif ( 404 === $status ) {
			$note = 'ページが見つかりません。リダイレクト系プラグインの設定を確認してください。';
		} elseif ( 410 === $status ) {
			$note = '「削除済み」として扱われています。リダイレクト設定を確認してください。';
		} elseif ( 403 === $status ) {
			$note = 'サーバー側で拒否されています（WAF・Basic認証など）。';
		} else {
			$note = '想定外の応答です。';
		}

		$rows[] = array(
			'key'    => $key,
			'path'   => str_replace( home_url(), '', $url ),
			'status' => $status,
			'note'   => $note,
		);
	}

	return $rows;
}

/**
 * テーマ有効化時にパーマリンクを再構築する。
 */
function naniwa_after_switch_theme() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'naniwa_after_switch_theme' );
