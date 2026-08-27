<?php
/**
 * Plugin Name: なにわ お客様の声フィールド確認
 * Description: 旧サイトから引き継いだ「お客様の声」がどんなフィールドを持っているかを確認する調査用ツール。確認が終わったら削除してください。
 * Version: 1.0.0
 *
 * 使い方:
 *   wp-content/mu-plugins/ に置き、管理画面「ツール → 声フィールド確認」を開く。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_menu',
	function () {
		add_management_page(
			'声フィールド確認',
			'声フィールド確認',
			'manage_options',
			'naniwa-voice-inspect',
			'naniwa_vi_page'
		);
	}
);

/**
 * 値を読みやすい文字列にする。
 *
 * @param mixed $value 値.
 * @return string
 */
function naniwa_vi_format( $value ) {
	if ( is_array( $value ) || is_object( $value ) ) {
		return wp_json_encode( $value, JSON_UNESCAPED_UNICODE );
	}
	$value = (string) $value;
	if ( mb_strlen( $value ) > 120 ) {
		$value = mb_substr( $value, 0, 120 ) . '…';
	}
	return $value;
}

/**
 * 調査画面を出力する。
 */
function naniwa_vi_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '権限がありません。' );
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$post_id = isset( $_GET['pid'] ) ? (int) $_GET['pid'] : 0;

	$types  = get_post_types( array( 'public' => true ), 'objects' );
	$counts = array();
	foreach ( $types as $type ) {
		$n = wp_count_posts( $type->name );
		$counts[ $type->name ] = array(
			'label'   => $type->label,
			'publish' => isset( $n->publish ) ? (int) $n->publish : 0,
			'total'   => array_sum( array_map( 'intval', (array) $n ) ),
		);
	}

	if ( ! $post_id ) {
		$latest = get_posts(
			array(
				'post_type'      => 'voice',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		$post_id = $latest ? (int) $latest[0] : 0;
	}
	?>
	<div class="wrap">
		<h1>お客様の声 フィールド確認</h1>

		<h2>投稿タイプごとの件数</h2>
		<table class="widefat striped" style="max-width:640px;">
			<thead><tr><th>投稿タイプ</th><th>スラッグ</th><th>公開</th><th>合計</th></tr></thead>
			<tbody>
				<?php foreach ( $counts as $slug => $c ) : ?>
					<tr<?php echo 'voice' === $slug ? ' style="background:#fff8e5;"' : ''; ?>>
						<td><?php echo esc_html( $c['label'] ); ?></td>
						<td><code><?php echo esc_html( $slug ); ?></code></td>
						<td><?php echo esc_html( number_format_i18n( $c['publish'] ) ); ?></td>
						<td><?php echo esc_html( number_format_i18n( $c['total'] ) ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php if ( ! $post_id ) : ?>
			<div class="notice notice-error"><p><strong>voice 投稿タイプの記事が1件も見つかりません。</strong>旧サイトでは別のスラッグだった可能性があります。上の表で件数の多い投稿タイプを確認してください。</p></div>
			</div>
			<?php
			return;
		endif;

		$post = get_post( $post_id );
		?>

		<h2>調査対象の記事</h2>
		<p>
			ID <code><?php echo esc_html( $post_id ); ?></code>　
			<strong><?php echo esc_html( get_the_title( $post_id ) ); ?></strong>　
			（スラッグ: <code><?php echo esc_html( $post->post_name ); ?></code>）
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" target="_blank">表示</a>
		</p>
		<form method="get" style="margin-bottom:20px;">
			<input type="hidden" name="page" value="naniwa-voice-inspect">
			<label>別の記事を見る（記事ID）：<input type="number" name="pid" value="<?php echo esc_attr( $post_id ); ?>" class="small-text"></label>
			<?php submit_button( '表示', 'secondary', '', false ); ?>
		</form>

		<?php if ( function_exists( 'get_field_objects' ) ) : ?>
			<h2>ACF のフィールド</h2>
			<?php $objects = get_field_objects( $post_id ); ?>
			<?php if ( $objects ) : ?>
				<table class="widefat striped">
					<thead><tr><th style="width:22%;">ラベル</th><th style="width:22%;">フィールド名（meta_key）</th><th style="width:10%;">型</th><th>値</th></tr></thead>
					<tbody>
						<?php foreach ( $objects as $name => $obj ) : ?>
							<tr>
								<td><strong><?php echo esc_html( $obj['label'] ); ?></strong></td>
								<td><code><?php echo esc_html( $name ); ?></code></td>
								<td><?php echo esc_html( $obj['type'] ); ?></td>
								<td><?php echo esc_html( naniwa_vi_format( $obj['value'] ) ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<div class="notice notice-warning"><p>ACF は有効ですが、この記事にフィールドが紐づいていません。フィールドグループの表示条件を確認してください。</p></div>
			<?php endif; ?>
		<?php else : ?>
			<div class="notice notice-warning"><p>ACF が有効化されていません。下のカスタムフィールド一覧を参照してください。</p></div>
		<?php endif; ?>

		<h2>カスタムフィールド（生の postmeta）</h2>
		<table class="widefat striped">
			<thead><tr><th style="width:30%;">meta_key</th><th>値</th></tr></thead>
			<tbody>
				<?php
				$meta = get_post_meta( $post_id );
				ksort( $meta );
				foreach ( $meta as $key => $values ) :
					?>
					<tr>
						<td><code><?php echo esc_html( $key ); ?></code></td>
						<td><?php echo esc_html( naniwa_vi_format( count( $values ) > 1 ? $values : reset( $values ) ) ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2>タクソノミー</h2>
		<?php $taxes = get_object_taxonomies( 'voice', 'objects' ); ?>
		<?php if ( $taxes ) : ?>
			<ul style="margin-left:1.5em;list-style:disc;">
				<?php foreach ( $taxes as $tax ) : ?>
					<li>
						<strong><?php echo esc_html( $tax->label ); ?></strong>（<code><?php echo esc_html( $tax->name ); ?></code>）：
						<?php
						$terms = get_the_terms( $post_id, $tax->name );
						echo esc_html( $terms && ! is_wp_error( $terms ) ? implode( '、', wp_list_pluck( $terms, 'name' ) ) : '（なし）' );
						?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p>登録されているタクソノミーはありません。</p>
		<?php endif; ?>

		<p style="margin-top:28px;color:#666;">確認が終わったら <code>wp-content/mu-plugins/naniwa-voice-inspect.php</code> を削除してください。</p>
	</div>
	<?php
}
