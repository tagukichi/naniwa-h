<?php
/**
 * お客様の声 一覧
 *
 * @package naniwa
 */

get_header();

naniwa_page_head( 'VOICE', 'お客様の声', 'お客様からご意見をいただき、サービス向上に役立てています。', 'chars/chara-listen.svg' );
naniwa_breadcrumb( array( array( 'label' => 'お客様の声' ) ) );
?>

<div class="page-body wide">
	<div class="inner">

		<div class="lead-block">
			<h2>お客様からご意見をいただき<br><span class="mark">サービス向上に役立てています。</span></h2>
			<p>お引越が終わったお客様からご意見をいただき、サービス向上に役立てています。</p>
		</div>

		<div class="block">
			<?php if ( have_posts() ) : ?>
				<div class="voice-archive">
					<?php
					while ( have_posts() ) :
						the_post();
						naniwa_voice_card( 90 );
					endwhile;
					?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '←', 'next_text' => '→' ) ); ?>
			<?php else : ?>
				<p>お客様の声がまだ登録されていません。</p>
			<?php endif; ?>
		</div>

	</div>
</div>

<?php
get_footer();
