<?php
/**
 * カテゴリー・タグ・日付などの汎用アーカイブ
 *
 * @package naniwa
 */

get_header();

naniwa_page_head( 'ARCHIVE', wp_strip_all_tags( get_the_archive_title() ), '', 'chars/ico-laptop-white.svg' );
naniwa_breadcrumb( array( array( 'label' => wp_strip_all_tags( get_the_archive_title() ) ) ) );
?>

<div class="page-body wide">
	<div class="inner">
		<div class="block">
			<?php if ( have_posts() ) : ?>
				<div class="blog-archive">
					<?php
					while ( have_posts() ) :
						the_post();
						naniwa_blog_card();
					endwhile;
					?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '←', 'next_text' => '→' ) ); ?>
			<?php else : ?>
				<p>該当する記事が見つかりませんでした。</p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
get_footer();
