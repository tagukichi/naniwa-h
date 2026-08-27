<?php
/**
 * 固定ページ：STEP6 荷物情報について（家具）（スラッグ: estimate-step6-2）
 *
 * Template Name: STEP6 荷物情報について（家具）
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

    <form class="form-card" action="<?php echo esc_url( naniwa_page_url( 'estimate-step6-3' ) ); ?>" method="post" novalidate>
      <h2>荷物情報について（2/3）家具・寝具</h2>
      <div class="form-inner">
<?php
// このステップより前の入力内容を hidden で持ち回る。
naniwa_estimate_carry_over( array( 'item' ) );
?>
        <div class="form-row" style="grid-template-columns:1fr;">
          <span class="label">収納家具</span>
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
          <span class="label">一般家具</span>
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
          <span class="label">寝具</span>
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
      </div>
      <div class="form-actions">
      <button class="btn btn-back" type="submit" formaction="<?php echo esc_url( naniwa_page_url( 'estimate-step6-1' ) ); ?>" formnovalidate>←　戻る</button>
      <button class="btn btn-primary" type="submit">次へ　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
