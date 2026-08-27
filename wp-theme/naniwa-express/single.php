<?php
/**
 * ブログ記事詳細
 *
 * @package naniwa
 */

get_header();

$naniwa_blog_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );

naniwa_page_head( 'BLOG', 'ブログ', '', 'chars/ico-laptop-white.svg' );
naniwa_breadcrumb(
	array(
		array( 'label' => 'ブログ', 'url' => $naniwa_blog_url ),
		array( 'label' => get_the_title() ),
	)
);
?>

<div class="page-body">
	<div class="inner">
		<?php while ( have_posts() ) : the_post(); ?>
			<article>
				<div class="article-meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d（D）' ) ); ?></time>
					<?php foreach ( get_the_category() as $naniwa_cat ) : ?>
						<span class="cat"><?php echo esc_html( $naniwa_cat->name ); ?></span>
					<?php endforeach; ?>
				</div>

				<h2 class="h-sec"><?php the_title(); ?></h2>

				<?php if ( has_post_thumbnail() ) : ?>
					<p class="article-thumb"><?php the_post_thumbnail( 'large' ); ?></p>
				<?php endif; ?>

				<div class="article-body">
					<?php the_content(); ?>
				</div>

				<p class="center-more" style="margin-top:40px;">
					<a class="btn btn-outline" href="<?php echo esc_url( $naniwa_blog_url ); ?>">← ブログ一覧へ戻る</a>
				</p>
			</article>
		<?php endwhile; ?>
	</div>
</div>

<?php
get_footer();
