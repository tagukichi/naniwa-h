<?php
/**
 * 固定ページ：STEP7 オプション（スラッグ: estimate-step7）
 *
 * Template Name: STEP7 オプション
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
      <li>STEP7</li>
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
      <li class="current">Step7<br><span style="font-size:10.5px;font-weight:600;opacity:.9">オプション</span></li>
    </ol>

    <form class="form-card" action="<?php echo esc_url( naniwa_page_url( 'estimate-confirm' ) ); ?>" method="post" novalidate>
      <h2>オプション</h2>
      <div class="form-inner">
<?php
// このステップより前の入力内容を hidden で持ち回る。
naniwa_estimate_carry_over( array( 'aircon_off', 'aircon_on', 'dishwasher_off', 'dishwasher_on', 'other_items', 'other_request', 'special_off', 'special_on', 'washlet_off', 'washlet_on' ) );
?>
        <div class="form-row">
          <span class="label">エアコン <span class="req any">任意</span></span>
          <div class="form-inline">
            <label for="aircon-on">取り付け</label>
            <input type="number" id="aircon-on" name="aircon_on" min="0" value="<?php echo esc_attr( naniwa_estimate_value( 'aircon_on', '0' ) ); ?>" style="max-width:96px;">
            <span>台</span>
            <label for="aircon-off" style="margin-left:12px;">取り外し</label>
            <input type="number" id="aircon-off" name="aircon_off" min="0" value="<?php echo esc_attr( naniwa_estimate_value( 'aircon_off', '0' ) ); ?>" style="max-width:96px;">
            <span>台</span>
          </div>
        </div>

        <div class="form-row">
          <span class="label">ウォシュレット <span class="req any">任意</span></span>
          <div class="form-inline">
            <label for="washlet-on">取り付け</label>
            <input type="number" id="washlet-on" name="washlet_on" min="0" value="<?php echo esc_attr( naniwa_estimate_value( 'washlet_on', '0' ) ); ?>" style="max-width:96px;">
            <span>台</span>
            <label for="washlet-off" style="margin-left:12px;">取り外し</label>
            <input type="number" id="washlet-off" name="washlet_off" min="0" value="<?php echo esc_attr( naniwa_estimate_value( 'washlet_off', '0' ) ); ?>" style="max-width:96px;">
            <span>台</span>
          </div>
        </div>

        <div class="form-row">
          <span class="label">食器洗浄機 <span class="req any">任意</span></span>
          <div class="form-inline">
            <label for="dishwasher-on">取り付け</label>
            <input type="number" id="dishwasher-on" name="dishwasher_on" min="0" value="<?php echo esc_attr( naniwa_estimate_value( 'dishwasher_on', '0' ) ); ?>" style="max-width:96px;">
            <span>台</span>
            <label for="dishwasher-off" style="margin-left:12px;">取り外し</label>
            <input type="number" id="dishwasher-off" name="dishwasher_off" min="0" value="<?php echo esc_attr( naniwa_estimate_value( 'dishwasher_off', '0' ) ); ?>" style="max-width:96px;">
            <span>台</span>
          </div>
        </div>

        <div class="form-row">
          <span class="label">特殊家具 <span class="req any">任意</span></span>
          <div class="form-inline">
            <label for="special-on">取り付け</label>
            <input type="number" id="special-on" name="special_on" min="0" value="<?php echo esc_attr( naniwa_estimate_value( 'special_on', '0' ) ); ?>" style="max-width:96px;">
            <span>台</span>
            <label for="special-off" style="margin-left:12px;">取り外し</label>
            <input type="number" id="special-off" name="special_off" min="0" value="<?php echo esc_attr( naniwa_estimate_value( 'special_off', '0' ) ); ?>" style="max-width:96px;">
            <span>台</span>
          </div>
        </div>

        <div class="form-row">
          <label class="label" for="other-items">その他のお荷物 <span class="req any">任意</span></label>
          <div>
            <textarea id="other-items" name="other_items" placeholder="品物・サイズなどわかる範囲でご記入ください。"><?php echo esc_textarea( naniwa_estimate_value( 'other_items' ) ); ?></textarea>
          </div>
        </div>

        <div class="form-row">
          <label class="label" for="other-request">その他、依頼したいこと <span class="req any">任意</span></label>
          <div>
            <textarea id="other-request" name="other_request" placeholder="不用品処分のご希望、作業のご要望などをご記入ください。"><?php echo esc_textarea( naniwa_estimate_value( 'other_request' ) ); ?></textarea>
            <p class="hint">不用品処分をご希望の場合は、品目をご記入いただくと事前にお見積りいたします。</p>
          </div>
        </div>
      </div>
      <div class="form-actions">
      <button class="btn btn-back" type="submit" formaction="<?php echo esc_url( naniwa_page_url( 'estimate-items' ) ); ?>" formnovalidate>←　戻る</button>
      <button class="btn btn-primary" type="submit">入力内容を確認する　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
