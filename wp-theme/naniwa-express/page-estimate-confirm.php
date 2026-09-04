<?php
/**
 * 固定ページ：入力内容の確認（スラッグ: estimate-confirm）
 *
 * Template Name: 入力内容の確認
 *
 * @package naniwa
 */

get_header();
?>

<section class="page-head">
  <div class="inner"><div class="ph-copy">
    <span class="en">ESTIMATE</span>
    <h1>web見積</h1>
    <p class="page-lead">ご入力いただいた内容をご確認ください。</p>
  </div><p class="ph-chara"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-carton-white.svg' ) ); ?>" alt=""></p></div>
</section>

<nav class="breadcrumb" aria-label="パンくずリスト">
  <div class="inner">
    <ol>
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
      <li>web見積</li>
      <li>確認ページ</li>
    </ol>
  </div>
</nav>

<div class="page-body">
  <div class="inner">

    <ol class="form-steps">
      <li class="done">Step1<br><span style="font-size:10.5px;font-weight:600;opacity:.9">お客様情報</span></li>
      <li class="done">Step2<br><span style="font-size:10.5px;font-weight:600;opacity:.9">プラン選択</span></li>
      <li class="done">Step3<br><span style="font-size:10.5px;font-weight:600;opacity:.9">現住所</span></li>
      <li class="done">Step4<br><span style="font-size:10.5px;font-weight:600;opacity:.9">引越先</span></li>
      <li class="done">Step5<br><span style="font-size:10.5px;font-weight:600;opacity:.9">道路状況</span></li>
      <li class="done">Step6<br><span style="font-size:10.5px;font-weight:600;opacity:.9">荷物情報</span></li>
      <li class="current">確認<br><span style="font-size:10.5px;font-weight:600;opacity:.9">内容確認</span></li>
    </ol>

    <form class="form-card" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<?php naniwa_estimate_form_fields(); ?>
      <h2>入力内容の確認</h2>
      <div class="form-inner">
        <p style="margin-bottom:22px;">下記の内容で送信します。修正が必要な場合は、各項目の「修正する」からお戻りください。</p>

<?php
$naniwa_printed = false;
foreach ( naniwa_estimate_steps() as $naniwa_slug => $naniwa_step ) :
	$naniwa_rows = array();
	foreach ( $naniwa_step['fields'] as $naniwa_key => $naniwa_label ) {
		$naniwa_val = naniwa_estimate_value( $naniwa_key );
		if ( '' !== $naniwa_val && '0' !== $naniwa_val ) {
			$naniwa_rows[ $naniwa_label ] = $naniwa_val;
		}
	}
	// 荷物はステップが3つに分かれているが、確認画面では1つにまとめる。
	if ( 'estimate-items' === $naniwa_slug ) {
		foreach ( naniwa_estimate_items() as $naniwa_label => $naniwa_count ) {
			$naniwa_rows[ $naniwa_label ] = $naniwa_count . '個';
		}
	}
	if ( ! $naniwa_rows ) {
		continue;
	}
	$naniwa_printed = true;
	?>
		<h3 class="h-sub"><?php echo esc_html( $naniwa_step['title'] ); ?>
			<button type="submit" name="naniwa_next" value="<?php echo esc_attr( $naniwa_slug ); ?>" formnovalidate class="confirm-edit">修正する</button>
		</h3>
		<table class="confirm-table" style="margin-bottom:30px;">
			<tbody>
				<?php foreach ( $naniwa_rows as $naniwa_label => $naniwa_val ) : ?>
					<tr><th><?php echo esc_html( $naniwa_label ); ?></th><td><?php echo esc_html( $naniwa_val ); ?></td></tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php
endforeach;

if ( ! $naniwa_printed ) :
	?>
	<div class="notice-box">
		<p>入力内容が引き継がれていません。お手数ですが
			<a href="<?php echo esc_url( naniwa_page_url( 'estimate-step1' ) ); ?>">STEP1</a> からやり直してください。</p>
	</div>
	<?php
endif;
?>
      </div>
      <div class="form-actions">
        <button class="btn btn-back" type="submit" name="naniwa_next" value="estimate-step7" formnovalidate>←　戻る</button>
        <button class="btn btn-primary" type="submit" name="naniwa_estimate_submit" value="1">この内容で送信する</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
