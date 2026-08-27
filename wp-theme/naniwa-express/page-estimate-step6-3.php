<?php
/**
 * 固定ページ：STEP6 荷物情報について（その他）（スラッグ: estimate-step6-3）
 *
 * Template Name: STEP6 荷物情報について（その他）
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
      <li>STEP6</li>
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
      <li class="current">Step6<br><span style="font-size:10.5px;font-weight:600;opacity:.9">荷物情報</span></li>
      <li>Step7<br><span style="font-size:10.5px;font-weight:600;opacity:.9">オプション</span></li>
    </ol>

    <form class="form-card" action="<?php echo esc_url( naniwa_page_url( 'estimate-step7' ) ); ?>" method="post" novalidate>
      <h2>荷物情報について（3/3）その他・特殊運搬</h2>
      <div class="form-inner">
<?php
// このステップより前の入力内容を hidden で持ち回る。
naniwa_estimate_carry_over( array( 'item' ) );
?>
        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label">その他の家具</span>
          <div class="item-grid">
            <div class="item-row">
              <span class="name">鏡台</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="鏡台を減らす">−</button>
                <input type="number" name="item[鏡台]" value="<?php echo esc_attr( naniwa_estimate_item( '鏡台' ) ); ?>" min="0" aria-label="鏡台の個数">
                <button type="button" data-step="up" aria-label="鏡台を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">姿見</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="姿見を減らす">−</button>
                <input type="number" name="item[姿見]" value="<?php echo esc_attr( naniwa_estimate_item( '姿見' ) ); ?>" min="0" aria-label="姿見の個数">
                <button type="button" data-step="up" aria-label="姿見を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">メタルラック（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="メタルラック（大）を減らす">−</button>
                <input type="number" name="item[メタルラック（大）]" value="<?php echo esc_attr( naniwa_estimate_item( 'メタルラック（大）' ) ); ?>" min="0" aria-label="メタルラック（大）の個数">
                <button type="button" data-step="up" aria-label="メタルラック（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">メタルラック（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="メタルラック（小）を減らす">−</button>
                <input type="number" name="item[メタルラック（小）]" value="<?php echo esc_attr( naniwa_estimate_item( 'メタルラック（小）' ) ); ?>" min="0" aria-label="メタルラック（小）の個数">
                <button type="button" data-step="up" aria-label="メタルラック（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">仏壇（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="仏壇（大）を減らす">−</button>
                <input type="number" name="item[仏壇（大）]" value="<?php echo esc_attr( naniwa_estimate_item( '仏壇（大）' ) ); ?>" min="0" aria-label="仏壇（大）の個数">
                <button type="button" data-step="up" aria-label="仏壇（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">仏壇（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="仏壇（小）を減らす">−</button>
                <input type="number" name="item[仏壇（小）]" value="<?php echo esc_attr( naniwa_estimate_item( '仏壇（小）' ) ); ?>" min="0" aria-label="仏壇（小）の個数">
                <button type="button" data-step="up" aria-label="仏壇（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">カーペット</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="カーペットを減らす">−</button>
                <input type="number" name="item[カーペット]" value="<?php echo esc_attr( naniwa_estimate_item( 'カーペット' ) ); ?>" min="0" aria-label="カーペットの個数">
                <button type="button" data-step="up" aria-label="カーペットを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">観葉植物</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="観葉植物を減らす">−</button>
                <input type="number" name="item[観葉植物]" value="<?php echo esc_attr( naniwa_estimate_item( '観葉植物' ) ); ?>" min="0" aria-label="観葉植物の個数">
                <button type="button" data-step="up" aria-label="観葉植物を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">物置（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="物置（大）を減らす">−</button>
                <input type="number" name="item[物置（大）]" value="<?php echo esc_attr( naniwa_estimate_item( '物置（大）' ) ); ?>" min="0" aria-label="物置（大）の個数">
                <button type="button" data-step="up" aria-label="物置（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">物置（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="物置（小）を減らす">−</button>
                <input type="number" name="item[物置（小）]" value="<?php echo esc_attr( naniwa_estimate_item( '物置（小）' ) ); ?>" min="0" aria-label="物置（小）の個数">
                <button type="button" data-step="up" aria-label="物置（小）を増やす">＋</button>
              </span>
            </div>
          </div>
        </div>

        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label">その他のお荷物</span>
          <div class="item-grid">
            <div class="item-row">
              <span class="name">自転車（大人）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="自転車（大人）を減らす">−</button>
                <input type="number" name="item[自転車（大人）]" value="<?php echo esc_attr( naniwa_estimate_item( '自転車（大人）' ) ); ?>" min="0" aria-label="自転車（大人）の個数">
                <button type="button" data-step="up" aria-label="自転車（大人）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">自転車（子供）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="自転車（子供）を減らす">−</button>
                <input type="number" name="item[自転車（子供）]" value="<?php echo esc_attr( naniwa_estimate_item( '自転車（子供）' ) ); ?>" min="0" aria-label="自転車（子供）の個数">
                <button type="button" data-step="up" aria-label="自転車（子供）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ゴルフバッグ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ゴルフバッグを減らす">−</button>
                <input type="number" name="item[ゴルフバッグ]" value="<?php echo esc_attr( naniwa_estimate_item( 'ゴルフバッグ' ) ); ?>" min="0" aria-label="ゴルフバッグの個数">
                <button type="button" data-step="up" aria-label="ゴルフバッグを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">スキー・スノーボード</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="スキー・スノーボードを減らす">−</button>
                <input type="number" name="item[スキー・スノーボード]" value="<?php echo esc_attr( naniwa_estimate_item( 'スキー・スノーボード' ) ); ?>" min="0" aria-label="スキー・スノーボードの個数">
                <button type="button" data-step="up" aria-label="スキー・スノーボードを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">エレクトーン</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="エレクトーンを減らす">−</button>
                <input type="number" name="item[エレクトーン]" value="<?php echo esc_attr( naniwa_estimate_item( 'エレクトーン' ) ); ?>" min="0" aria-label="エレクトーンの個数">
                <button type="button" data-step="up" aria-label="エレクトーンを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">電子ピアノ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="電子ピアノを減らす">−</button>
                <input type="number" name="item[電子ピアノ]" value="<?php echo esc_attr( naniwa_estimate_item( '電子ピアノ' ) ); ?>" min="0" aria-label="電子ピアノの個数">
                <button type="button" data-step="up" aria-label="電子ピアノを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">物干し台</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="物干し台を減らす">−</button>
                <input type="number" name="item[物干し台]" value="<?php echo esc_attr( naniwa_estimate_item( '物干し台' ) ); ?>" min="0" aria-label="物干し台の個数">
                <button type="button" data-step="up" aria-label="物干し台を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">物干し竿</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="物干し竿を減らす">−</button>
                <input type="number" name="item[物干し竿]" value="<?php echo esc_attr( naniwa_estimate_item( '物干し竿' ) ); ?>" min="0" aria-label="物干し竿の個数">
                <button type="button" data-step="up" aria-label="物干し竿を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ハンガーパイプ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ハンガーパイプを減らす">−</button>
                <input type="number" name="item[ハンガーパイプ]" value="<?php echo esc_attr( naniwa_estimate_item( 'ハンガーパイプ' ) ); ?>" min="0" aria-label="ハンガーパイプの個数">
                <button type="button" data-step="up" aria-label="ハンガーパイプを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ウォーターサーバー</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ウォーターサーバーを減らす">−</button>
                <input type="number" name="item[ウォーターサーバー]" value="<?php echo esc_attr( naniwa_estimate_item( 'ウォーターサーバー' ) ); ?>" min="0" aria-label="ウォーターサーバーの個数">
                <button type="button" data-step="up" aria-label="ウォーターサーバーを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">スーツケース</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="スーツケースを減らす">−</button>
                <input type="number" name="item[スーツケース]" value="<?php echo esc_attr( naniwa_estimate_item( 'スーツケース' ) ); ?>" min="0" aria-label="スーツケースの個数">
                <button type="button" data-step="up" aria-label="スーツケースを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">その他ボックス</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="その他ボックスを減らす">−</button>
                <input type="number" name="item[その他ボックス]" value="<?php echo esc_attr( naniwa_estimate_item( 'その他ボックス' ) ); ?>" min="0" aria-label="その他ボックスの個数">
                <button type="button" data-step="up" aria-label="その他ボックスを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">楽器</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="楽器を減らす">−</button>
                <input type="number" name="item[楽器]" value="<?php echo esc_attr( naniwa_estimate_item( '楽器' ) ); ?>" min="0" aria-label="楽器の個数">
                <button type="button" data-step="up" aria-label="楽器を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ダンボール</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ダンボールを減らす">−</button>
                <input type="number" name="item[ダンボール]" value="<?php echo esc_attr( naniwa_estimate_item( 'ダンボール' ) ); ?>" min="0" aria-label="ダンボールの個数">
                <button type="button" data-step="up" aria-label="ダンボールを増やす">＋</button>
              </span>
            </div>
          </div>
        </div>

        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label">特殊運搬</span>
          <div class="item-grid">
            <div class="item-row">
              <span class="name">グランドピアノ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="グランドピアノを減らす">−</button>
                <input type="number" name="item[グランドピアノ]" value="<?php echo esc_attr( naniwa_estimate_item( 'グランドピアノ' ) ); ?>" min="0" aria-label="グランドピアノの個数">
                <button type="button" data-step="up" aria-label="グランドピアノを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">アップライトピアノ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="アップライトピアノを減らす">−</button>
                <input type="number" name="item[アップライトピアノ]" value="<?php echo esc_attr( naniwa_estimate_item( 'アップライトピアノ' ) ); ?>" min="0" aria-label="アップライトピアノの個数">
                <button type="button" data-step="up" aria-label="アップライトピアノを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">乗用車</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="乗用車を減らす">−</button>
                <input type="number" name="item[乗用車]" value="<?php echo esc_attr( naniwa_estimate_item( '乗用車' ) ); ?>" min="0" aria-label="乗用車の個数">
                <button type="button" data-step="up" aria-label="乗用車を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">バイク</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="バイクを減らす">−</button>
                <input type="number" name="item[バイク]" value="<?php echo esc_attr( naniwa_estimate_item( 'バイク' ) ); ?>" min="0" aria-label="バイクの個数">
                <button type="button" data-step="up" aria-label="バイクを増やす">＋</button>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions">
      <button class="btn btn-back" type="submit" formaction="<?php echo esc_url( naniwa_page_url( 'estimate-step6-2' ) ); ?>" formnovalidate>←　戻る</button>
      <button class="btn btn-primary" type="submit">次へ　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
