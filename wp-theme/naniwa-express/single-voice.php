<?php
/**
 * お客様の声 詳細
 *
 * @package naniwa
 */

get_header();

naniwa_page_head( 'VOICE', 'お客様の声', '', 'chars/chara-listen.svg' );
naniwa_breadcrumb(
	array(
		array( 'label' => 'お客様の声', 'url' => get_post_type_archive_link( 'voice' ) ),
		array( 'label' => get_the_title() ),
	)
);
?>

<div class="page-body">
	<div class="inner">
		<?php
		while ( have_posts() ) :
			the_post();

			$naniwa_rating = (int) get_post_meta( get_the_ID(), '_naniwa_rating', true );
			$naniwa_plan   = get_post_meta( get_the_ID(), '_naniwa_plan', true );
			$naniwa_route  = get_post_meta( get_the_ID(), '_naniwa_route', true );
			$naniwa_who    = get_post_meta( get_the_ID(), '_naniwa_who', true );
			$naniwa_reply  = get_post_meta( get_the_ID(), '_naniwa_reply', true );
			?>
			<article>
				<div class="article-meta">
					<?php if ( $naniwa_rating ) : ?>
						<img class="voice-face" src="<?php echo esc_url( naniwa_voice_face_url( $naniwa_rating ) ); ?>" alt="<?php echo esc_attr( '評価' . $naniwa_rating ); ?>" width="56" height="56">
					<?php endif; ?>
					<?php if ( $naniwa_plan ) : ?>
						<span class="cat"><?php echo esc_html( $naniwa_plan ); ?></span>
					<?php endif; ?>
					<?php if ( $naniwa_rating ) : ?>
						<span class="stars"><?php echo esc_html( naniwa_stars( $naniwa_rating ) ); ?></span>
					<?php endif; ?>
				</div>

				<h2 class="h-sec"><?php the_title(); ?></h2>

				<div class="table-wrap" style="margin-bottom:28px;">
					<table class="data">
						<tbody>
							<?php if ( $naniwa_plan ) : ?>
								<tr><th>ご利用プラン</th><td><?php echo esc_html( $naniwa_plan ); ?></td></tr>
							<?php endif; ?>
							<?php if ( $naniwa_route ) : ?>
								<tr><th>お引越し区間</th><td><?php echo esc_html( $naniwa_route ); ?></td></tr>
							<?php endif; ?>
							<?php if ( $naniwa_who ) : ?>
								<tr><th>年代・性別</th><td><?php echo esc_html( $naniwa_who ); ?></td></tr>
							<?php endif; ?>
							<?php if ( $naniwa_rating ) : ?>
								<tr><th>ご満足度</th><td><span class="stars"><?php echo esc_html( naniwa_stars( $naniwa_rating ) ); ?></span> <?php echo esc_html( number_format( $naniwa_rating, 1 ) ); ?></td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>

				<div class="article-body">
					<?php the_content(); ?>
				</div>

				<?php if ( $naniwa_reply ) : ?>
					<div class="reply-box">
						<p class="reply-head">なにわ引越センターより</p>
						<div class="reply-body">
							<img class="reply-mark" src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/eagle-mark.svg' ) ); ?>" alt="" width="120" height="120" loading="lazy">
							<p><?php echo nl2br( esc_html( $naniwa_reply ) ); ?></p>
						</div>
					</div>
				<?php endif; ?>

				<p class="center-more" style="margin-top:40px;">
					<a class="btn btn-outline" href="<?php echo esc_url( get_post_type_archive_link( 'voice' ) ); ?>">← お客様の声 一覧へ戻る</a>
				</p>
			</article>
		<?php endwhile; ?>
	</div>
</div>

<?php
get_footer();
