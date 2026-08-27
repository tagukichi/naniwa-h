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

			$naniwa_data = naniwa_voice_data( get_the_ID() );
			$naniwa_s    = naniwa_voice_summary( get_the_ID() );
			$naniwa_tag  = naniwa_voice_tag_text( $naniwa_s );
			?>
			<article class="voice-single">
				<div class="article-meta">
					<?php if ( null !== $naniwa_s['rating'] ) : ?>
						<img class="voice-face" src="<?php echo esc_url( naniwa_voice_face_url( $naniwa_s['rating'] ) ); ?>" alt="<?php echo esc_attr( '評価' . round( $naniwa_s['rating'] ) ); ?>" width="56" height="56">
					<?php endif; ?>
					<?php if ( $naniwa_tag ) : ?>
						<span class="cat"><?php echo esc_html( $naniwa_tag ); ?></span>
					<?php endif; ?>
					<?php if ( null !== $naniwa_s['rating'] ) : ?>
						<span class="stars"><?php echo esc_html( naniwa_stars( $naniwa_s['rating'] ) ); ?></span>
						<span class="score"><?php echo esc_html( number_format( (float) $naniwa_s['rating'], 1 ) ); ?></span>
					<?php endif; ?>
				</div>

				<h2 class="h-sec"><?php the_title(); ?></h2>

				<?php
				// 概要テーブル。値のある行だけを出す。
				$naniwa_rows = array_filter(
					array(
						'引越プラン'  => $naniwa_tag,
						'地域'        => $naniwa_s['area'],
						'年代・性別'  => trim( $naniwa_s['age'] . ( $naniwa_s['age'] && $naniwa_s['gender'] ? '／' : '' ) . $naniwa_s['gender'] ),
						'作業日'      => $naniwa_s['date'],
						'料金'        => $naniwa_s['price'],
						'評価日'      => $naniwa_s['rated'],
					)
				);
				?>
				<?php if ( $naniwa_rows ) : ?>
					<div class="table-wrap" style="margin-bottom:28px;">
						<table class="data">
							<tbody>
								<?php foreach ( $naniwa_rows as $naniwa_label => $naniwa_value ) : ?>
									<tr><th><?php echo esc_html( $naniwa_label ); ?></th><td><?php echo esc_html( $naniwa_value ); ?></td></tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>

				<?php
				// 7軸の評価。1つでも値があれば表示する。
				$naniwa_axes = array();
				foreach ( naniwa_voice_axes() as $naniwa_axis ) {
					$naniwa_value = naniwa_voice_rating( $naniwa_data, $naniwa_axis['aliases'] );
					if ( null !== $naniwa_value ) {
						$naniwa_axes[ $naniwa_axis['label'] ] = $naniwa_value;
					}
				}
				?>
				<?php if ( $naniwa_axes ) : ?>
					<h3 class="h-sub">項目別のご評価</h3>
					<ul class="voice-scores">
						<?php foreach ( $naniwa_axes as $naniwa_label => $naniwa_value ) : ?>
							<li<?php echo ( 0.0 === (float) $naniwa_value ) ? ' class="is-none"' : ''; ?>>
								<span class="name"><?php echo esc_html( $naniwa_label ); ?></span>
								<span class="stars" aria-label="<?php echo esc_attr( '5点満点中' . $naniwa_value . '点' ); ?>"><?php echo esc_html( naniwa_stars( $naniwa_value ) ); ?></span>
								<span class="num"><?php echo esc_html( 0.0 === (float) $naniwa_value ? '—' : number_format( (float) $naniwa_value, 1 ) ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $naniwa_s['good'] ) : ?>
					<h3 class="h-sub">良かった点</h3>
					<div class="article-body"><p><?php echo nl2br( esc_html( $naniwa_s['good'] ) ); ?></p></div>
				<?php endif; ?>

				<?php if ( $naniwa_s['bad'] ) : ?>
					<h3 class="h-sub">悪かった点</h3>
					<div class="article-body"><p><?php echo nl2br( esc_html( $naniwa_s['bad'] ) ); ?></p></div>
				<?php endif; ?>

				<?php if ( trim( wp_strip_all_tags( get_the_content() ) ) ) : ?>
					<div class="article-body"><?php the_content(); ?></div>
				<?php endif; ?>

				<?php if ( $naniwa_s['reply'] ) : ?>
					<div class="reply-box">
						<p class="reply-head">なにわ引越センターより</p>
						<div class="reply-body">
							<img class="reply-mark" src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/eagle-mark.svg' ) ); ?>" alt="" width="120" height="120" loading="lazy">
							<p><?php echo nl2br( esc_html( $naniwa_s['reply'] ) ); ?></p>
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
