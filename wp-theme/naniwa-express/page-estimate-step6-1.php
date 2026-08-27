<?php
/**
 * 固定ページ：STEP6 荷物情報について（家電）（スラッグ: estimate-step6-1）
 *
 * Template Name: STEP6 荷物情報について（家電）
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

    <form class="form-card" action="<?php echo esc_url( naniwa_page_url( 'estimate-step6-2' ) ); ?>" method="post" novalidate>
      <h2>荷物情報について（1/3）家電</h2>
      <div class="form-inner">
<?php
// このステップより前の入力内容を hidden で持ち回る。
naniwa_estimate_carry_over( array( 'item' ) );
?>
        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label">AV家電</span>
          <div class="item-grid">
            <div class="item-row">
              <span class="name">液晶テレビ（〜42型）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="液晶テレビ（〜42型）を減らす">−</button>
                <input type="number" name="item[液晶テレビ（〜42型）]" value="<?php echo esc_attr( naniwa_estimate_item( '液晶テレビ（〜42型）' ) ); ?>" min="0" aria-label="液晶テレビ（〜42型）の個数">
                <button type="button" data-step="up" aria-label="液晶テレビ（〜42型）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">液晶テレビ（43型〜）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="液晶テレビ（43型〜）を減らす">−</button>
                <input type="number" name="item[液晶テレビ（43型〜）]" value="<?php echo esc_attr( naniwa_estimate_item( '液晶テレビ（43型〜）' ) ); ?>" min="0" aria-label="液晶テレビ（43型〜）の個数">
                <button type="button" data-step="up" aria-label="液晶テレビ（43型〜）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">有機ELテレビ（〜55型）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="有機ELテレビ（〜55型）を減らす">−</button>
                <input type="number" name="item[有機ELテレビ（〜55型）]" value="<?php echo esc_attr( naniwa_estimate_item( '有機ELテレビ（〜55型）' ) ); ?>" min="0" aria-label="有機ELテレビ（〜55型）の個数">
                <button type="button" data-step="up" aria-label="有機ELテレビ（〜55型）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">有機ELテレビ（56型〜）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="有機ELテレビ（56型〜）を減らす">−</button>
                <input type="number" name="item[有機ELテレビ（56型〜）]" value="<?php echo esc_attr( naniwa_estimate_item( '有機ELテレビ（56型〜）' ) ); ?>" min="0" aria-label="有機ELテレビ（56型〜）の個数">
                <button type="button" data-step="up" aria-label="有機ELテレビ（56型〜）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">デスクトップパソコン</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="デスクトップパソコンを減らす">−</button>
                <input type="number" name="item[デスクトップパソコン]" value="<?php echo esc_attr( naniwa_estimate_item( 'デスクトップパソコン' ) ); ?>" min="0" aria-label="デスクトップパソコンの個数">
                <button type="button" data-step="up" aria-label="デスクトップパソコンを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ノートパソコン</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ノートパソコンを減らす">−</button>
                <input type="number" name="item[ノートパソコン]" value="<?php echo esc_attr( naniwa_estimate_item( 'ノートパソコン' ) ); ?>" min="0" aria-label="ノートパソコンの個数">
                <button type="button" data-step="up" aria-label="ノートパソコンを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ゲーム機</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ゲーム機を減らす">−</button>
                <input type="number" name="item[ゲーム機]" value="<?php echo esc_attr( naniwa_estimate_item( 'ゲーム機' ) ); ?>" min="0" aria-label="ゲーム機の個数">
                <button type="button" data-step="up" aria-label="ゲーム機を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">オーディオ機器</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="オーディオ機器を減らす">−</button>
                <input type="number" name="item[オーディオ機器]" value="<?php echo esc_attr( naniwa_estimate_item( 'オーディオ機器' ) ); ?>" min="0" aria-label="オーディオ機器の個数">
                <button type="button" data-step="up" aria-label="オーディオ機器を増やす">＋</button>
              </span>
            </div>
          </div>
        </div>

        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label">一般家電</span>
          <div class="item-grid">
            <div class="item-row">
              <span class="name">縦型洗濯機</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="縦型洗濯機を減らす">−</button>
                <input type="number" name="item[縦型洗濯機]" value="<?php echo esc_attr( naniwa_estimate_item( '縦型洗濯機' ) ); ?>" min="0" aria-label="縦型洗濯機の個数">
                <button type="button" data-step="up" aria-label="縦型洗濯機を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ドラム式洗濯機</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ドラム式洗濯機を減らす">−</button>
                <input type="number" name="item[ドラム式洗濯機]" value="<?php echo esc_attr( naniwa_estimate_item( 'ドラム式洗濯機' ) ); ?>" min="0" aria-label="ドラム式洗濯機の個数">
                <button type="button" data-step="up" aria-label="ドラム式洗濯機を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">冷蔵庫：4ドア以上</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="冷蔵庫：4ドア以上を減らす">−</button>
                <input type="number" name="item[冷蔵庫：4ドア以上]" value="<?php echo esc_attr( naniwa_estimate_item( '冷蔵庫：4ドア以上' ) ); ?>" min="0" aria-label="冷蔵庫：4ドア以上の個数">
                <button type="button" data-step="up" aria-label="冷蔵庫：4ドア以上を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">冷蔵庫：3ドア</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="冷蔵庫：3ドアを減らす">−</button>
                <input type="number" name="item[冷蔵庫：3ドア]" value="<?php echo esc_attr( naniwa_estimate_item( '冷蔵庫：3ドア' ) ); ?>" min="0" aria-label="冷蔵庫：3ドアの個数">
                <button type="button" data-step="up" aria-label="冷蔵庫：3ドアを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">冷蔵庫：2ドア</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="冷蔵庫：2ドアを減らす">−</button>
                <input type="number" name="item[冷蔵庫：2ドア]" value="<?php echo esc_attr( naniwa_estimate_item( '冷蔵庫：2ドア' ) ); ?>" min="0" aria-label="冷蔵庫：2ドアの個数">
                <button type="button" data-step="up" aria-label="冷蔵庫：2ドアを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">エアコン</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="エアコンを減らす">−</button>
                <input type="number" name="item[エアコン]" value="<?php echo esc_attr( naniwa_estimate_item( 'エアコン' ) ); ?>" min="0" aria-label="エアコンの個数">
                <button type="button" data-step="up" aria-label="エアコンを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">オーブントースター</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="オーブントースターを減らす">−</button>
                <input type="number" name="item[オーブントースター]" value="<?php echo esc_attr( naniwa_estimate_item( 'オーブントースター' ) ); ?>" min="0" aria-label="オーブントースターの個数">
                <button type="button" data-step="up" aria-label="オーブントースターを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">電子レンジ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="電子レンジを減らす">−</button>
                <input type="number" name="item[電子レンジ]" value="<?php echo esc_attr( naniwa_estimate_item( '電子レンジ' ) ); ?>" min="0" aria-label="電子レンジの個数">
                <button type="button" data-step="up" aria-label="電子レンジを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ガスコンロ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ガスコンロを減らす">−</button>
                <input type="number" name="item[ガスコンロ]" value="<?php echo esc_attr( naniwa_estimate_item( 'ガスコンロ' ) ); ?>" min="0" aria-label="ガスコンロの個数">
                <button type="button" data-step="up" aria-label="ガスコンロを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">扇風機</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="扇風機を減らす">−</button>
                <input type="number" name="item[扇風機]" value="<?php echo esc_attr( naniwa_estimate_item( '扇風機' ) ); ?>" min="0" aria-label="扇風機の個数">
                <button type="button" data-step="up" aria-label="扇風機を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ストーブ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ストーブを減らす">−</button>
                <input type="number" name="item[ストーブ]" value="<?php echo esc_attr( naniwa_estimate_item( 'ストーブ' ) ); ?>" min="0" aria-label="ストーブの個数">
                <button type="button" data-step="up" aria-label="ストーブを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">照明器具</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="照明器具を減らす">−</button>
                <input type="number" name="item[照明器具]" value="<?php echo esc_attr( naniwa_estimate_item( '照明器具' ) ); ?>" min="0" aria-label="照明器具の個数">
                <button type="button" data-step="up" aria-label="照明器具を増やす">＋</button>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions">
      <button class="btn btn-back" type="submit" formaction="<?php echo esc_url( naniwa_page_url( 'estimate-step5' ) ); ?>" formnovalidate>←　戻る</button>
      <button class="btn btn-primary" type="submit">次へ　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
