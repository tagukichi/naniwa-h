<?php
/**
 * 固定ページ：STEP1 お客様情報（スラッグ: estimate-step1）
 *
 * Template Name: STEP1 お客様情報
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
      <li>STEP1</li>
    </ol>
  </div>
</nav>

<div class="page-body">
  <div class="inner">

    <ol class="form-steps">
      <li class="current">Step1<br><span style="font-size:10.5px;font-weight:600;opacity:.9">お客様情報</span></li>
      <li>Step2<br><span style="font-size:10.5px;font-weight:600;opacity:.9">プラン選択</span></li>
      <li>Step3<br><span style="font-size:10.5px;font-weight:600;opacity:.9">現住所</span></li>
      <li>Step4<br><span style="font-size:10.5px;font-weight:600;opacity:.9">引越先</span></li>
      <li>Step5<br><span style="font-size:10.5px;font-weight:600;opacity:.9">道路状況</span></li>
      <li>Step6<br><span style="font-size:10.5px;font-weight:600;opacity:.9">荷物情報</span></li>
      <li>Step7<br><span style="font-size:10.5px;font-weight:600;opacity:.9">オプション</span></li>
    </ol>

    <form class="form-card" action="<?php echo esc_url( home_url( '/estimate-step2/' ) ); ?>" method="post" novalidate>
      <h2>お客様情報</h2>
      <div class="form-inner">
<?php
// このステップより前の入力内容を hidden で持ち回る。
naniwa_estimate_carry_over( array( 'email', 'kana', 'name', 'request', 'tel' ) );
?>
        <div class="form-row">
          <label class="label" for="name">お名前 <span class="req">必須</span></label>
          <div><input type="text" id="name" name="name" placeholder="例：浪花 太郎" required value="<?php echo esc_attr( naniwa_estimate_value( 'name', '' ) ); ?>"></div>
        </div>

        <div class="form-row">
          <label class="label" for="kana">ふりがな <span class="req">必須</span></label>
          <div><input type="text" id="kana" name="kana" placeholder="例：なにわ たろう" required value="<?php echo esc_attr( naniwa_estimate_value( 'kana', '' ) ); ?>"></div>
        </div>

        <div class="form-row">
          <label class="label" for="tel">電話番号 <span class="req">必須</span></label>
          <div>
            <input type="tel" id="tel" name="tel" placeholder="例：045-580-0728" inputmode="tel" required value="<?php echo esc_attr( naniwa_estimate_value( 'tel', '' ) ); ?>">
            <p class="hint">日中つながりやすい番号をご入力ください。</p>
          </div>
        </div>

        <div class="form-row">
          <label class="label" for="email">メールアドレス <span class="req">必須</span></label>
          <div>
            <input type="email" id="email" name="email" placeholder="例：info@naniwa-h.com" inputmode="email" required value="<?php echo esc_attr( naniwa_estimate_value( 'email', '' ) ); ?>">
            <p class="hint">お見積り結果をこちらのアドレスへお送りします。</p>
          </div>
        </div>

        <div class="form-row">
          <label class="label" for="request">その他ご要望 <span class="req any">任意</span></label>
          <div><textarea id="request" name="request" placeholder="ご希望の連絡時間帯、ご不明な点などがありましたらご記入ください。"><?php echo esc_textarea( naniwa_estimate_value( 'request' ) ); ?></textarea></div>
        </div>
      </div>
      <div class="form-actions">
      <button class="btn btn-primary" type="submit">次へ　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
