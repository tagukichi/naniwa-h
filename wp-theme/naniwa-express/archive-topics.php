<?php
/**
 * お知らせ 一覧
 *
 * @package naniwa
 */

get_header();

naniwa_page_head( 'NEWS', 'お知らせ', 'なにわ引越センターからのお知らせです。', 'chars/ico-calendar-white.svg' );
naniwa_breadcrumb( array( array( 'label' => 'お知らせ' ) ) );
?>

<div class="page-body">
	<div class="inner">
		<div class="block">
			<?php if ( have_posts() ) : ?>
				<ul class="news-list">
					<?php while ( have_posts() ) : the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>">
								<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
								<?php the_title(); ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '←', 'next_text' => '→' ) ); ?>
			<?php else : ?>
				<p>お知らせはまだありません。</p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
get_footer();
