<?php
/**
 * テンプレートから使うヘルパー関数
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * ブログ一覧（投稿ページ）のURLを返す。
 *
 * 「設定 > 表示設定」で投稿ページが未指定のときはトップに逃がす。
 *
 * @return string
 */
function naniwa_blog_url() {
	$page_id = (int) get_option( 'page_for_posts' );
	return $page_id ? get_permalink( $page_id ) : home_url( '/' );
}

/**
 * 評価の数値から顔アイコンのURLを返す。
 *
 * 既存サイトの仕様に合わせ、5 は満面の笑み、4 以下は通常の笑顔を使う。
 *
 * @param int $rating 1〜5.
 * @return string
 */
function naniwa_voice_face_url( $rating ) {
	$file = ( round( (float) $rating ) >= 5 ) ? 'face-5.png' : 'face-4.png';
	return get_theme_file_uri( '/assets/img/chars/' . $file );
}

/**
 * ★を組み立てて返す。
 *
 * @param int $rating 1〜5.
 * @return string
 */
function naniwa_stars( $rating ) {
	$filled = (int) round( max( 0, min( 5, (float) $rating ) ) );
	return str_repeat( '★', $filled ) . str_repeat( '☆', 5 - $filled );
}

/**
 * お客様の声カードを1枚出力する。voice-grid / voice-archive の両方で使う。
 *
 * @param int $excerpt_length 抜粋の文字数。0 で全文.
 */
function naniwa_voice_card( $excerpt_length = 0 ) {
	$summary = naniwa_voice_summary( get_the_ID() );
	$rating  = $summary['rating'];
	$tag     = naniwa_voice_tag_text( $summary );
	$who     = naniwa_voice_who_text( $summary );

	// 一覧に出す本文は「冒頭文章」を最優先で使う（既存サイトと同じ挙動）。
	$body = $summary['lead'];
	if ( '' === $body ) {
		$body = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( get_the_content() );
	}
	if ( '' === trim( $body ) ) {
		$body = $summary['good'];
	}
	if ( $excerpt_length > 0 ) {
		$body = wp_trim_words( $body, $excerpt_length, '…' );
	}
	?>
	<a class="voice-card" href="<?php the_permalink(); ?>">
		<div class="voice-head">
			<?php if ( null !== $rating ) : ?>
				<img class="voice-face" src="<?php echo esc_url( naniwa_voice_face_url( $rating ) ); ?>" alt="<?php echo esc_attr( '評価' . round( $rating ) ); ?>" width="64" height="64" loading="lazy">
			<?php endif; ?>
			<div>
				<?php if ( null !== $rating ) : ?>
					<span class="stars" aria-label="<?php echo esc_attr( '5点満点中' . round( $rating, 1 ) . '点' ); ?>"><?php echo esc_html( naniwa_stars( $rating ) ); ?></span>
				<?php endif; ?>
				<p class="meta">
					<?php if ( $tag ) : ?><span class="tag"><?php echo esc_html( $tag ); ?></span><?php endif; ?>
					<?php if ( $who ) : ?><span class="who"><?php echo esc_html( $who ); ?></span><?php endif; ?>
				</p>
			</div>
		</div>
		<p class="voice-body"><?php echo esc_html( $body ); ?></p>
	</a>
	<?php
}

/**
 * ブログカードを1枚出力する。
 */
function naniwa_blog_card() {
	?>
	<a class="blog-card" href="<?php the_permalink(); ?>">
		<span class="thumb">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy' ) ); ?>
			<?php else : ?>
				<svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21"/></svg>
			<?php endif; ?>
		</span>
		<span class="body">
			<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d（D）' ) ); ?></time>
			<h3><?php the_title(); ?></h3>
		</span>
	</a>
	<?php
}

/**
 * パンくずリストを出力する。
 *
 * @param array<int, array{label:string, url?:string}> $items ホーム以降の項目.
 */
function naniwa_breadcrumb( $items ) {
	?>
	<nav class="breadcrumb" aria-label="パンくずリスト">
		<div class="inner">
			<ol>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
				<?php foreach ( $items as $item ) : ?>
					<li>
						<?php if ( ! empty( $item['url'] ) ) : ?>
							<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $item['label'] ); ?>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</nav>
	<?php
}

/**
 * 下層ページのヘッダーを出力する。
 *
 * @param string $en    英語見出し.
 * @param string $title 日本語見出し.
 * @param string $lead  リード文（省略可）.
 * @param string $icon  assets/img/ からの相対パス（省略可）.
 */
function naniwa_page_head( $en, $title, $lead = '', $icon = 'chars/eagle.png' ) {
	?>
	<section class="page-head">
		<div class="inner"><div class="ph-copy">
			<span class="en"><?php echo esc_html( $en ); ?></span>
			<h1><?php echo esc_html( $title ); ?></h1>
			<?php if ( $lead ) : ?><p class="page-lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
		</div><?php if ( $icon ) : ?><p class="ph-chara"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/' . $icon ) ); ?>" alt=""></p><?php endif; ?></div>
	</section>
	<?php
}
