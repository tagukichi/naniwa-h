<?php
/**
 * お知らせ 詳細
 *
 * @package naniwa
 */

get_header();

naniwa_page_head( 'NEWS', 'お知らせ', '', 'chars/ico-calendar-white.svg' );
naniwa_breadcrumb(
	array(
		array( 'label' => 'お知らせ', 'url' => get_post_type_archive_link( 'news' ) ),
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
				</div>
				<h2 class="h-sec"><?php the_title(); ?></h2>
				<div class="article-body"><?php the_content(); ?></div>
				<p class="center-more" style="margin-top:40px;">
					<a class="btn btn-outline" href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>">← お知らせ一覧へ戻る</a>
				</p>
			</article>
		<?php endwhile; ?>
	</div>
</div>

<?php
get_footer();
