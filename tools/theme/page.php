<?php
/**
 * 汎用固定ページ
 *
 * デザイン確定済みのページはスラッグ別テンプレート（page-{slug}.php）が
 * 使われる。ここは新規追加されたページ向けのフォールバック。
 *
 * @package naniwa
 */

get_header();

while ( have_posts() ) :
	the_post();

	naniwa_page_head( 'PAGE', get_the_title(), '', 'chars/eagle.png' );
	naniwa_breadcrumb( array( array( 'label' => get_the_title() ) ) );
	?>

	<div class="page-body">
		<div class="inner">
			<div class="block">
				<div class="article-body"><?php the_content(); ?></div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
