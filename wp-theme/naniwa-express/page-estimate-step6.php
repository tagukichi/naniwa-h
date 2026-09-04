<?php
/**
 * 固定ページ：STEP6 荷物情報について（スラッグ: estimate-step6）
 *
 * Template Name: STEP6 荷物情報について
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
      <h2>荷物情報について</h2>

      <nav class="item-nav" aria-label="カテゴリ内リンク">
        <p class="item-nav-title">カテゴリから探す</p>
        <ul>
          <li><a href="#cat-1">AV家電</a></li>
          <li><a href="#cat-2">一般家電</a></li>
          <li><a href="#cat-3">収納家具</a></li>
          <li><a href="#cat-4">一般家具</a></li>
          <li><a href="#cat-5">寝具</a></li>
          <li><a href="#cat-6">その他の家具</a></li>
          <li><a href="#cat-7">その他のお荷物</a></li>
          <li><a href="#cat-8">特殊運搬</a></li>
        </ul>
      </nav>

      <p class="item-lead">お運びするお荷物の個数をご入力ください。<br class="sp-only">数量が0のものは入力不要です。</p>

      <div class="form-inner">
<?php
// このステップより前の入力内容を hidden で持ち回る。
naniwa_estimate_carry_over( array( 'item' ) );
?>
        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label" id="cat-1">AV家電</span>
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
          <span class="label" id="cat-2">一般家電</span>
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

        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label" id="cat-3">収納家具</span>
          <div class="item-grid">
            <div class="item-row">
              <span class="name">洋ダンス（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="洋ダンス（大）を減らす">−</button>
                <input type="number" name="item[洋ダンス（大）]" value="<?php echo esc_attr( naniwa_estimate_item( '洋ダンス（大）' ) ); ?>" min="0" aria-label="洋ダンス（大）の個数">
                <button type="button" data-step="up" aria-label="洋ダンス（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">洋ダンス（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="洋ダンス（小）を減らす">−</button>
                <input type="number" name="item[洋ダンス（小）]" value="<?php echo esc_attr( naniwa_estimate_item( '洋ダンス（小）' ) ); ?>" min="0" aria-label="洋ダンス（小）の個数">
                <button type="button" data-step="up" aria-label="洋ダンス（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">和ダンス（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="和ダンス（大）を減らす">−</button>
                <input type="number" name="item[和ダンス（大）]" value="<?php echo esc_attr( naniwa_estimate_item( '和ダンス（大）' ) ); ?>" min="0" aria-label="和ダンス（大）の個数">
                <button type="button" data-step="up" aria-label="和ダンス（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">和ダンス（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="和ダンス（小）を減らす">−</button>
                <input type="number" name="item[和ダンス（小）]" value="<?php echo esc_attr( naniwa_estimate_item( '和ダンス（小）' ) ); ?>" min="0" aria-label="和ダンス（小）の個数">
                <button type="button" data-step="up" aria-label="和ダンス（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">整理ダンス（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="整理ダンス（大）を減らす">−</button>
                <input type="number" name="item[整理ダンス（大）]" value="<?php echo esc_attr( naniwa_estimate_item( '整理ダンス（大）' ) ); ?>" min="0" aria-label="整理ダンス（大）の個数">
                <button type="button" data-step="up" aria-label="整理ダンス（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">整理ダンス（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="整理ダンス（小）を減らす">−</button>
                <input type="number" name="item[整理ダンス（小）]" value="<?php echo esc_attr( naniwa_estimate_item( '整理ダンス（小）' ) ); ?>" min="0" aria-label="整理ダンス（小）の個数">
                <button type="button" data-step="up" aria-label="整理ダンス（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">本棚（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="本棚（大）を減らす">−</button>
                <input type="number" name="item[本棚（大）]" value="<?php echo esc_attr( naniwa_estimate_item( '本棚（大）' ) ); ?>" min="0" aria-label="本棚（大）の個数">
                <button type="button" data-step="up" aria-label="本棚（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">本棚（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="本棚（小）を減らす">−</button>
                <input type="number" name="item[本棚（小）]" value="<?php echo esc_attr( naniwa_estimate_item( '本棚（小）' ) ); ?>" min="0" aria-label="本棚（小）の個数">
                <button type="button" data-step="up" aria-label="本棚（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">食器棚（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="食器棚（大）を減らす">−</button>
                <input type="number" name="item[食器棚（大）]" value="<?php echo esc_attr( naniwa_estimate_item( '食器棚（大）' ) ); ?>" min="0" aria-label="食器棚（大）の個数">
                <button type="button" data-step="up" aria-label="食器棚（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">食器棚（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="食器棚（小）を減らす">−</button>
                <input type="number" name="item[食器棚（小）]" value="<?php echo esc_attr( naniwa_estimate_item( '食器棚（小）' ) ); ?>" min="0" aria-label="食器棚（小）の個数">
                <button type="button" data-step="up" aria-label="食器棚（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">衣装ケース</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="衣装ケースを減らす">−</button>
                <input type="number" name="item[衣装ケース]" value="<?php echo esc_attr( naniwa_estimate_item( '衣装ケース' ) ); ?>" min="0" aria-label="衣装ケースの個数">
                <button type="button" data-step="up" aria-label="衣装ケースを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">カラーボックス</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="カラーボックスを減らす">−</button>
                <input type="number" name="item[カラーボックス]" value="<?php echo esc_attr( naniwa_estimate_item( 'カラーボックス' ) ); ?>" min="0" aria-label="カラーボックスの個数">
                <button type="button" data-step="up" aria-label="カラーボックスを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">下駄箱</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="下駄箱を減らす">−</button>
                <input type="number" name="item[下駄箱]" value="<?php echo esc_attr( naniwa_estimate_item( '下駄箱' ) ); ?>" min="0" aria-label="下駄箱の個数">
                <button type="button" data-step="up" aria-label="下駄箱を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">壁面収納</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="壁面収納を減らす">−</button>
                <input type="number" name="item[壁面収納]" value="<?php echo esc_attr( naniwa_estimate_item( '壁面収納' ) ); ?>" min="0" aria-label="壁面収納の個数">
                <button type="button" data-step="up" aria-label="壁面収納を増やす">＋</button>
              </span>
            </div>
          </div>
        </div>

        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label" id="cat-4">一般家具</span>
          <div class="item-grid">
            <div class="item-row">
              <span class="name">テレビ台（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="テレビ台（大）を減らす">−</button>
                <input type="number" name="item[テレビ台（大）]" value="<?php echo esc_attr( naniwa_estimate_item( 'テレビ台（大）' ) ); ?>" min="0" aria-label="テレビ台（大）の個数">
                <button type="button" data-step="up" aria-label="テレビ台（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">テレビ台（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="テレビ台（小）を減らす">−</button>
                <input type="number" name="item[テレビ台（小）]" value="<?php echo esc_attr( naniwa_estimate_item( 'テレビ台（小）' ) ); ?>" min="0" aria-label="テレビ台（小）の個数">
                <button type="button" data-step="up" aria-label="テレビ台（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">食卓・テーブル 4人掛</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="食卓・テーブル 4人掛を減らす">−</button>
                <input type="number" name="item[食卓・テーブル 4人掛]" value="<?php echo esc_attr( naniwa_estimate_item( '食卓・テーブル 4人掛' ) ); ?>" min="0" aria-label="食卓・テーブル 4人掛の個数">
                <button type="button" data-step="up" aria-label="食卓・テーブル 4人掛を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">食卓・テーブル 2人掛</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="食卓・テーブル 2人掛を減らす">−</button>
                <input type="number" name="item[食卓・テーブル 2人掛]" value="<?php echo esc_attr( naniwa_estimate_item( '食卓・テーブル 2人掛' ) ); ?>" min="0" aria-label="食卓・テーブル 2人掛の個数">
                <button type="button" data-step="up" aria-label="食卓・テーブル 2人掛を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ローテーブル</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ローテーブルを減らす">−</button>
                <input type="number" name="item[ローテーブル]" value="<?php echo esc_attr( naniwa_estimate_item( 'ローテーブル' ) ); ?>" min="0" aria-label="ローテーブルの個数">
                <button type="button" data-step="up" aria-label="ローテーブルを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">こたつ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="こたつを減らす">−</button>
                <input type="number" name="item[こたつ]" value="<?php echo esc_attr( naniwa_estimate_item( 'こたつ' ) ); ?>" min="0" aria-label="こたつの個数">
                <button type="button" data-step="up" aria-label="こたつを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">机（大）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="机（大）を減らす">−</button>
                <input type="number" name="item[机（大）]" value="<?php echo esc_attr( naniwa_estimate_item( '机（大）' ) ); ?>" min="0" aria-label="机（大）の個数">
                <button type="button" data-step="up" aria-label="机（大）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">机（小）</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="机（小）を減らす">−</button>
                <input type="number" name="item[机（小）]" value="<?php echo esc_attr( naniwa_estimate_item( '机（小）' ) ); ?>" min="0" aria-label="机（小）の個数">
                <button type="button" data-step="up" aria-label="机（小）を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ソファー 3人掛</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ソファー 3人掛を減らす">−</button>
                <input type="number" name="item[ソファー 3人掛]" value="<?php echo esc_attr( naniwa_estimate_item( 'ソファー 3人掛' ) ); ?>" min="0" aria-label="ソファー 3人掛の個数">
                <button type="button" data-step="up" aria-label="ソファー 3人掛を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ソファー 2人掛</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ソファー 2人掛を減らす">−</button>
                <input type="number" name="item[ソファー 2人掛]" value="<?php echo esc_attr( naniwa_estimate_item( 'ソファー 2人掛' ) ); ?>" min="0" aria-label="ソファー 2人掛の個数">
                <button type="button" data-step="up" aria-label="ソファー 2人掛を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ソファー 1人掛</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ソファー 1人掛を減らす">−</button>
                <input type="number" name="item[ソファー 1人掛]" value="<?php echo esc_attr( naniwa_estimate_item( 'ソファー 1人掛' ) ); ?>" min="0" aria-label="ソファー 1人掛の個数">
                <button type="button" data-step="up" aria-label="ソファー 1人掛を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">椅子</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="椅子を減らす">−</button>
                <input type="number" name="item[椅子]" value="<?php echo esc_attr( naniwa_estimate_item( '椅子' ) ); ?>" min="0" aria-label="椅子の個数">
                <button type="button" data-step="up" aria-label="椅子を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">マッサージチェア</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="マッサージチェアを減らす">−</button>
                <input type="number" name="item[マッサージチェア]" value="<?php echo esc_attr( naniwa_estimate_item( 'マッサージチェア' ) ); ?>" min="0" aria-label="マッサージチェアの個数">
                <button type="button" data-step="up" aria-label="マッサージチェアを増やす">＋</button>
              </span>
            </div>
          </div>
        </div>

        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label" id="cat-5">寝具</span>
          <div class="item-grid">
            <div class="item-row">
              <span class="name">ベッド：シングル</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ベッド：シングルを減らす">−</button>
                <input type="number" name="item[ベッド：シングル]" value="<?php echo esc_attr( naniwa_estimate_item( 'ベッド：シングル' ) ); ?>" min="0" aria-label="ベッド：シングルの個数">
                <button type="button" data-step="up" aria-label="ベッド：シングルを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ベッド：ダブル</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ベッド：ダブルを減らす">−</button>
                <input type="number" name="item[ベッド：ダブル]" value="<?php echo esc_attr( naniwa_estimate_item( 'ベッド：ダブル' ) ); ?>" min="0" aria-label="ベッド：ダブルの個数">
                <button type="button" data-step="up" aria-label="ベッド：ダブルを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ベッド：クイーン以上</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ベッド：クイーン以上を減らす">−</button>
                <input type="number" name="item[ベッド：クイーン以上]" value="<?php echo esc_attr( naniwa_estimate_item( 'ベッド：クイーン以上' ) ); ?>" min="0" aria-label="ベッド：クイーン以上の個数">
                <button type="button" data-step="up" aria-label="ベッド：クイーン以上を増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ベッド：跳ね上げ</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ベッド：跳ね上げを減らす">−</button>
                <input type="number" name="item[ベッド：跳ね上げ]" value="<?php echo esc_attr( naniwa_estimate_item( 'ベッド：跳ね上げ' ) ); ?>" min="0" aria-label="ベッド：跳ね上げの個数">
                <button type="button" data-step="up" aria-label="ベッド：跳ね上げを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ベッド：チェスト</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ベッド：チェストを減らす">−</button>
                <input type="number" name="item[ベッド：チェスト]" value="<?php echo esc_attr( naniwa_estimate_item( 'ベッド：チェスト' ) ); ?>" min="0" aria-label="ベッド：チェストの個数">
                <button type="button" data-step="up" aria-label="ベッド：チェストを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">ベッド：ロフト</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="ベッド：ロフトを減らす">−</button>
                <input type="number" name="item[ベッド：ロフト]" value="<?php echo esc_attr( naniwa_estimate_item( 'ベッド：ロフト' ) ); ?>" min="0" aria-label="ベッド：ロフトの個数">
                <button type="button" data-step="up" aria-label="ベッド：ロフトを増やす">＋</button>
              </span>
            </div>
            <div class="item-row">
              <span class="name">布団</span>
              <span class="counter">
                <button type="button" data-step="down" aria-label="布団を減らす">−</button>
                <input type="number" name="item[布団]" value="<?php echo esc_attr( naniwa_estimate_item( '布団' ) ); ?>" min="0" aria-label="布団の個数">
                <button type="button" data-step="up" aria-label="布団を増やす">＋</button>
              </span>
            </div>
          </div>
        </div>

        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label" id="cat-6">その他の家具</span>
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
          <span class="label" id="cat-7">その他のお荷物</span>
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
          <span class="label" id="cat-8">特殊運搬</span>
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
      <button class="btn btn-back" type="submit" formaction="<?php echo esc_url( naniwa_page_url( 'estimate-step5' ) ); ?>" formnovalidate>←　戻る</button>
      <button class="btn btn-primary" type="submit">次へ　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
