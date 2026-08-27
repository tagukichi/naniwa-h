<?php
/**
 * 404 ページ
 *
 * @package naniwa
 */

get_header();

naniwa_page_head( '404', 'ページが見つかりません', 'お探しのページは移動または削除された可能性があります。', 'chars/chara-think.svg' );
naniwa_breadcrumb( array( array( 'label' => 'ページが見つかりません' ) ) );
?>

<div class="page-body">
	<div class="inner">
		<div class="block" style="text-align:center;">
			<p>URLをご確認いただくか、下記より目的のページをお探しください。</p>
			<p class="center-more" style="margin-top:28px;">
				<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a>
			</p>
		</div>
	</div>
</div>

<?php
get_footer();
