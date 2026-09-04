<?php
/**
 * 固定ページ：STEP5 建物前の道路状況について（スラッグ: estimate-step5）
 *
 * Template Name: STEP5 建物前の道路状況について
 *
 * @package naniwa
 */

get_header();
?>

<section class="page-head">
  <div class="inner"><div class="ph-copy">
    <span class="en">ESTIMATE</span>
    <h1>web見積</h1>
    <p class="page-lead">24時間受付・お見積りは無料です。単身・カップルのお客様には24時間以内にご返信いたします。</p>
  </div><p class="ph-chara"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-carton-white.svg' ) ); ?>" alt=""></p></div>
</section>

<nav class="breadcrumb" aria-label="パンくずリスト">
  <div class="inner">
    <ol>
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
      <li>web見積</li>
      <li>STEP5</li>
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
      <li class="current">Step5<br><span style="font-size:10.5px;font-weight:600;opacity:.9">道路状況</span></li>
      <li>Step6<br><span style="font-size:10.5px;font-weight:600;opacity:.9">荷物情報</span></li>
      <li>Step7<br><span style="font-size:10.5px;font-weight:600;opacity:.9">オプション</span></li>
    </ol>

    <form class="form-card" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
      <h2>建物前の道路状況について</h2>
      <div class="form-inner">
<?php
// 送信先は admin-post.php に固定し、入力内容はサーバー側で保持する。
naniwa_estimate_form_fields();
?>
        <div class="form-row">
          <span class="label">お住まいの前の道路 <span class="req any">任意</span></span>
          <div>
            <p class="hint" style="margin:0 0 14px;">現在と引越先をそれぞれ選択してください。</p>
            <p class="h-sub" style="margin-bottom:10px;">現在</p>
            <div class="choice-grid">
              <label class="choice"><input type="radio" name="from_road" value="自動車2台が余裕ですれ違える"<?php checked( naniwa_estimate_value( 'from_road' ), '自動車2台が余裕ですれ違える' ); ?>><span>自動車2台が余裕ですれ違える</span></label>
              <label class="choice"><input type="radio" name="from_road" value="自動車2台が通行できる"<?php checked( naniwa_estimate_value( 'from_road' ), '自動車2台が通行できる' ); ?>><span>自動車2台が通行できる</span></label>
              <label class="choice"><input type="radio" name="from_road" value="自動車1台が通行できる"<?php checked( naniwa_estimate_value( 'from_road' ), '自動車1台が通行できる' ); ?>><span>自動車1台が通行できる</span></label>
              <label class="choice"><input type="radio" name="from_road" value="自動車が通行できない"<?php checked( naniwa_estimate_value( 'from_road' ), '自動車が通行できない' ); ?>><span>自動車が通行できない</span></label>
            </div>
            <div style="margin-top:22px;"></div>
            <p class="h-sub" style="margin-bottom:10px;">引越先</p>
            <div class="choice-grid">
              <label class="choice"><input type="radio" name="to_road" value="自動車2台が余裕ですれ違える"<?php checked( naniwa_estimate_value( 'to_road' ), '自動車2台が余裕ですれ違える' ); ?>><span>自動車2台が余裕ですれ違える</span></label>
              <label class="choice"><input type="radio" name="to_road" value="自動車2台が通行できる"<?php checked( naniwa_estimate_value( 'to_road' ), '自動車2台が通行できる' ); ?>><span>自動車2台が通行できる</span></label>
              <label class="choice"><input type="radio" name="to_road" value="自動車1台が通行できる"<?php checked( naniwa_estimate_value( 'to_road' ), '自動車1台が通行できる' ); ?>><span>自動車1台が通行できる</span></label>
              <label class="choice"><input type="radio" name="to_road" value="自動車が通行できない"<?php checked( naniwa_estimate_value( 'to_road' ), '自動車が通行できない' ); ?>><span>自動車が通行できない</span></label>
            </div>
          </div>
        </div>

        <div class="form-row">
          <label class="label" for="distance">直前の道路から玄関までの距離 <span class="req any">任意</span></label>
          <div>
            <div class="form-inline">
              <input type="number" id="distance" name="distance" min="0" placeholder="例：10" value="<?php echo esc_attr( naniwa_estimate_value( 'distance', '0' ) ); ?>">
              <span>m</span>
            </div>
            <p class="hint">マンションの場合、玄関先から階段・エレベーターまでの距離も加えてください。</p>
          </div>
        </div>
      </div>
      <div class="form-actions">
      <button class="btn btn-back" type="submit" name="naniwa_next" value="estimate-step4" formnovalidate>←　戻る</button>
      <button class="btn btn-primary" type="submit" name="naniwa_next" value="estimate-items">次へ　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
