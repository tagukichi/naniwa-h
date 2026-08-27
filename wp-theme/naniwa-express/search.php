<?php
/**
 * 検索結果
 *
 * @package naniwa
 */

get_header();

$naniwa_query = get_search_query();

naniwa_page_head( 'SEARCH', '検索結果', sprintf( '「%s」の検索結果', $naniwa_query ), 'chars/chara-think.svg' );
naniwa_breadcrumb( array( array( 'label' => '検索結果' ) ) );
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
				<p>該当する内容が見つかりませんでした。別のキーワードでお試しください。</p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
get_footer();
