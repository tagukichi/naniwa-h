<?php
/**
 * 固定ページ：STEP2 引越プランの選択（スラッグ: estimate-step2）
 *
 * Template Name: STEP2 引越プランの選択
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
      <li>STEP2</li>
    </ol>
  </div>
</nav>

<div class="page-body">
  <div class="inner">

    <ol class="form-steps">
      <li class="done">Step1<br><span style="font-size:10.5px;font-weight:600;opacity:.9">お客様情報</span></li>
      <li class="current">Step2<br><span style="font-size:10.5px;font-weight:600;opacity:.9">プラン選択</span></li>
      <li>Step3<br><span style="font-size:10.5px;font-weight:600;opacity:.9">現住所</span></li>
      <li>Step4<br><span style="font-size:10.5px;font-weight:600;opacity:.9">引越先</span></li>
      <li>Step5<br><span style="font-size:10.5px;font-weight:600;opacity:.9">道路状況</span></li>
      <li>Step6<br><span style="font-size:10.5px;font-weight:600;opacity:.9">荷物情報</span></li>
      <li>Step7<br><span style="font-size:10.5px;font-weight:600;opacity:.9">オプション</span></li>
    </ol>

    <form class="form-card" action="<?php echo esc_url( home_url( '/estimate-step3/' ) ); ?>" method="post" novalidate>
      <h2>引越プランの選択</h2>
      <div class="form-inner">
<?php
// このステップより前の入力内容を hidden で持ち回る。
naniwa_estimate_carry_over( array( 'plan', 'plan_note' ) );
?>
        <div class="form-row">
          <span class="label">引越プラン <span class="req">必須</span></span>
          <div>
            <p class="h-sub" style="margin-bottom:10px;">単身の引越</p>
            <div class="choice-grid">
              <label class="choice"><input type="radio" name="plan" value="単身：スタンダードプラン"<?php checked( naniwa_estimate_value( 'plan' ), '単身：スタンダードプラン' ); ?>><span>スタンダードプラン</span></label>
              <label class="choice"><input type="radio" name="plan" value="単身：梱包プラスプラン"<?php checked( naniwa_estimate_value( 'plan' ), '単身：梱包プラスプラン' ); ?>><span>梱包プラスプラン</span></label>
              <label class="choice"><input type="radio" name="plan" value="単身：フルコースプラン"<?php checked( naniwa_estimate_value( 'plan' ), '単身：フルコースプラン' ); ?>><span>フルコースプラン</span></label>
            </div>

            <p class="h-sub" style="margin:22px 0 10px;">ご家族の引越</p>
            <div class="choice-grid">
              <label class="choice"><input type="radio" name="plan" value="家族：スタンダードプラン"<?php checked( naniwa_estimate_value( 'plan' ), '家族：スタンダードプラン' ); ?>><span>スタンダードプラン</span></label>
              <label class="choice"><input type="radio" name="plan" value="家族：梱包プラスプラン"<?php checked( naniwa_estimate_value( 'plan' ), '家族：梱包プラスプラン' ); ?>><span>梱包プラスプラン</span></label>
              <label class="choice"><input type="radio" name="plan" value="家族：フルコースプラン"<?php checked( naniwa_estimate_value( 'plan' ), '家族：フルコースプラン' ); ?>><span>フルコースプラン</span></label>
            </div>

            <p class="h-sub" style="margin:22px 0 10px;">その他のプラン</p>
            <div class="choice-grid">
              <label class="choice"><input type="radio" name="plan" value="カップルの引越"<?php checked( naniwa_estimate_value( 'plan' ), 'カップルの引越' ); ?>><span>カップルの引越</span></label>
              <label class="choice"><input type="radio" name="plan" value="今すぐの引越"<?php checked( naniwa_estimate_value( 'plan' ), '今すぐの引越' ); ?>><span>今すぐの引越</span></label>
              <label class="choice"><input type="radio" name="plan" value="オフィスの引越"<?php checked( naniwa_estimate_value( 'plan' ), 'オフィスの引越' ); ?>><span>オフィスの引越</span></label>
            </div>
          </div>
        </div>

        <div class="form-row">
          <label class="label" for="plan-note">プランに対する追記事項 <span class="req any">任意</span></label>
          <div><textarea id="plan-note" name="plan_note" placeholder="「台所部分だけ梱包を手伝ってほしい」など、ご要望をご記入ください。"><?php echo esc_textarea( naniwa_estimate_value( 'plan_note' ) ); ?></textarea></div>
        </div>
      </div>
      <div class="form-actions">
      <button class="btn btn-back" type="submit" formaction="<?php echo esc_url( home_url( '/estimate-step1/' ) ); ?>" formnovalidate>←　戻る</button>
      <button class="btn btn-primary" type="submit">次へ　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
