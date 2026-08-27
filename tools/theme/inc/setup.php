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
			$result = naniwa_setup_create_pages();
		} elseif ( 'flush' === $action ) {
			flush_rewrite_rules();
			$result = 'flushed';
		}
	}

	$required = naniwa_required_pages();
	$missing  = 0;
	?>
	<div class="wrap">
		<h1>なにわ：初期設定</h1>
		<p>このテーマは<strong>固定ページのスラッグ</strong>でデザインを割り当てます。<br>
			スラッグが一致していないと、そのページは 404 になるか、デザインが当たらない素の状態で表示されます。</p>

		<?php if ( is_array( $result ) ) : ?>
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
		<?php elseif ( 'flushed' === $result ) : ?>
			<div class="notice notice-success"><p>パーマリンクを再構築しました。</p></div>
		<?php endif; ?>

		<h2>必要な固定ページ</h2>
		<table class="widefat striped">
			<thead>
				<tr>
					<th style="width:22%;">スラッグ</th>
					<th style="width:26%;">ページ名</th>
					<th style="width:16%;">状態</th>
					<th style="width:22%;">使われるテンプレート</th>
					<th>確認</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $required as $slug => $title ) :
					$page     = get_page_by_path( $slug );
					$template = 'page-' . $slug . '.php';
					$has_tpl  = file_exists( get_theme_file_path( '/' . $template ) );
					if ( ! $page ) {
						++$missing;
					}
					?>
					<tr>
						<td><code><?php echo esc_html( $slug ); ?></code></td>
						<td><?php echo esc_html( $title ); ?></td>
						<td>
							<?php if ( $page ) : ?>
								<span style="color:#146c43;font-weight:600;">✓ 作成済み</span>
							<?php else : ?>
								<span style="color:#b32d2e;font-weight:600;">✗ 未作成（404になります）</span>
							<?php endif; ?>
						</td>
						<td>
							<?php if ( $has_tpl ) : ?>
								<code><?php echo esc_html( $template ); ?></code>
							<?php else : ?>
								<span style="color:#b32d2e;">テンプレートなし</span>
							<?php endif; ?>
						</td>
						<td>
							<?php if ( $page ) : ?>
								<a href="<?php echo esc_url( get_permalink( $page ) ); ?>" target="_blank">表示</a>　
								<a href="<?php echo esc_url( get_edit_post_link( $page->ID ) ); ?>">編集</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<form method="post" style="margin:22px 0;">
			<?php wp_nonce_field( 'naniwa_setup' ); ?>
			<input type="hidden" name="naniwa_setup_action" value="create">
			<?php
			submit_button(
				$missing ? sprintf( '不足している %d 件のページを作成する', $missing ) : 'ページはすべて揃っています',
				'primary',
				'submit',
				false,
				$missing ? array() : array( 'disabled' => 'disabled' )
			);
			?>
			<p class="description">既にあるページは変更しません。本文は空で作成され、デザインはテンプレート側から出力されます。</p>
		</form>

		<h2>いま存在する固定ページのスラッグ</h2>
		<p class="description">意図したスラッグになっていないページがないか確認してください。日本語タイトルのまま作成すると、スラッグも日本語になり、テンプレートが割り当たりません。</p>
		<?php
		$all = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => array( 'publish', 'draft', 'private' ),
				'posts_per_page' => 200,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
		?>
		<table class="widefat striped">
			<thead><tr><th style="width:30%;">タイトル</th><th style="width:26%;">スラッグ</th><th style="width:14%;">状態</th><th>テンプレート判定</th></tr></thead>
			<tbody>
				<?php foreach ( $all as $one ) : ?>
					<?php
					$slug     = $one->post_name;
					$expected = isset( $required[ $slug ] );
					$has_tpl  = file_exists( get_theme_file_path( '/page-' . $slug . '.php' ) );
					?>
					<tr>
						<td><a href="<?php echo esc_url( get_edit_post_link( $one->ID ) ); ?>"><?php echo esc_html( get_the_title( $one ) ); ?></a></td>
						<td><code><?php echo esc_html( urldecode( $slug ) ); ?></code></td>
						<td><?php echo esc_html( get_post_status( $one ) ); ?></td>
						<td>
							<?php if ( $has_tpl ) : ?>
								<span style="color:#146c43;">専用テンプレート適用</span>
							<?php elseif ( $expected ) : ?>
								<span style="color:#b32d2e;">テンプレートなし</span>
							<?php else : ?>
								<span style="color:#8a6d00;">page.php（汎用）</span>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2>その他</h2>
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
 * テーマ有効化時にパーマリンクを再構築する。
 */
function naniwa_after_switch_theme() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'naniwa_after_switch_theme' );
