<?php
/**
 * ブログ一覧（投稿ページ）
 *
 * @package naniwa
 */

get_header();

naniwa_page_head( 'BLOG', 'ブログ', 'お引越しやエリア情報など、お役立ち情報をお届けします。', 'chars/ico-laptop-white.svg' );
naniwa_breadcrumb( array( array( 'label' => 'ブログ' ) ) );
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

				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => '←',
						'next_text' => '→',
					)
				);
				?>
			<?php else : ?>
				<p>記事がまだありません。</p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
get_footer();
