<?php
/**
 * 固定ページ：STEP4 引越先の情報（スラッグ: estimate-step4）
 *
 * Template Name: STEP4 引越先の情報
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
      <li>STEP4</li>
    </ol>
  </div>
</nav>

<div class="page-body">
  <div class="inner">

    <ol class="form-steps">
      <li class="done">Step1<br><span style="font-size:10.5px;font-weight:600;opacity:.9">お客様情報</span></li>
      <li class="done">Step2<br><span style="font-size:10.5px;font-weight:600;opacity:.9">プラン選択</span></li>
      <li class="done">Step3<br><span style="font-size:10.5px;font-weight:600;opacity:.9">現住所</span></li>
      <li class="current">Step4<br><span style="font-size:10.5px;font-weight:600;opacity:.9">引越先</span></li>
      <li>Step5<br><span style="font-size:10.5px;font-weight:600;opacity:.9">道路状況</span></li>
      <li>Step6<br><span style="font-size:10.5px;font-weight:600;opacity:.9">荷物情報</span></li>
      <li>Step7<br><span style="font-size:10.5px;font-weight:600;opacity:.9">オプション</span></li>
    </ol>

    <form class="form-card" action="<?php echo esc_url( naniwa_page_url( 'estimate-step5' ) ); ?>" method="post" novalidate>
      <h2>引越先の情報</h2>
      <div class="form-inner">
<?php
// このステップより前の入力内容を hidden で持ち回る。
naniwa_estimate_carry_over( array( 'to_bldg', 'to_carry', 'to_city', 'to_elevator', 'to_floor', 'to_floors', 'to_layout', 'to_maisonette', 'to_parking', 'to_pref', 'to_street', 'to_type', 'to_zip' ) );
?>
        <div class="form-row">
          <label class="label" for="to-zip">郵便番号 <span class="req any">任意</span></label>
          <div>
            <input type="text" id="to-zip" name="to_zip" placeholder="例：230-0075" inputmode="numeric" value="<?php echo esc_attr( naniwa_estimate_value( 'to_zip', '' ) ); ?>">
          </div>
        </div>

        <div class="form-row">
          <label class="label" for="to-pref">都道府県 <span class="req any">任意</span></label>
          <div>
            <select id="to-pref" name="to_pref">
            <option value=""<?php selected( naniwa_estimate_value( 'to_pref' ), '' ); ?>>—以下から選択してください—</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '北海道' ); ?>>北海道</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '青森県' ); ?>>青森県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '岩手県' ); ?>>岩手県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '宮城県' ); ?>>宮城県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '秋田県' ); ?>>秋田県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '山形県' ); ?>>山形県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '福島県' ); ?>>福島県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '茨城県' ); ?>>茨城県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '栃木県' ); ?>>栃木県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '群馬県' ); ?>>群馬県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '埼玉県' ); ?>>埼玉県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '千葉県' ); ?>>千葉県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '東京都' ); ?>>東京都</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '神奈川県' ); ?>>神奈川県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '新潟県' ); ?>>新潟県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '富山県' ); ?>>富山県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '石川県' ); ?>>石川県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '福井県' ); ?>>福井県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '山梨県' ); ?>>山梨県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '長野県' ); ?>>長野県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '岐阜県' ); ?>>岐阜県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '静岡県' ); ?>>静岡県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '愛知県' ); ?>>愛知県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '三重県' ); ?>>三重県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '滋賀県' ); ?>>滋賀県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '京都府' ); ?>>京都府</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '大阪府' ); ?>>大阪府</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '兵庫県' ); ?>>兵庫県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '奈良県' ); ?>>奈良県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '和歌山県' ); ?>>和歌山県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '鳥取県' ); ?>>鳥取県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '島根県' ); ?>>島根県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '岡山県' ); ?>>岡山県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '広島県' ); ?>>広島県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '山口県' ); ?>>山口県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '徳島県' ); ?>>徳島県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '香川県' ); ?>>香川県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '愛媛県' ); ?>>愛媛県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '高知県' ); ?>>高知県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '福岡県' ); ?>>福岡県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '佐賀県' ); ?>>佐賀県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '長崎県' ); ?>>長崎県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '熊本県' ); ?>>熊本県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '大分県' ); ?>>大分県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '宮崎県' ); ?>>宮崎県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '鹿児島県' ); ?>>鹿児島県</option>
            <option<?php selected( naniwa_estimate_value( 'to_pref' ), '沖縄県' ); ?>>沖縄県</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <label class="label" for="to-city">市区町村 <span class="req any">任意</span></label>
          <div><input type="text" id="to-city" name="to_city" placeholder="例：横浜市鶴見区" value="<?php echo esc_attr( naniwa_estimate_value( 'to_city', '' ) ); ?>"></div>
        </div>

        <div class="form-row">
          <label class="label" for="to-street">番地・号 <span class="req any">任意</span></label>
          <div><input type="text" id="to-street" name="to_street" placeholder="例：上の宮2-19-25" value="<?php echo esc_attr( naniwa_estimate_value( 'to_street', '' ) ); ?>"></div>
        </div>

        <div class="form-row">
          <label class="label" for="to-bldg">建物名など <span class="req any">任意</span></label>
          <div><input type="text" id="to-bldg" name="to_bldg" placeholder="例：なにわマンション101号室" value="<?php echo esc_attr( naniwa_estimate_value( 'to_bldg', '' ) ); ?>"></div>
        </div>

        <p class="h-sub" style="margin:26px 0 4px;">住居形態</p>

        <div class="form-row">
          <span class="label">建物の種類 <span class="req">必須</span></span>
          <div class="choice-grid">
            <label class="choice"><input type="radio" name="to_type" value="戸建て"<?php checked( naniwa_estimate_value( 'to_type' ), '戸建て' ); ?>><span>戸建て</span></label>
            <label class="choice"><input type="radio" name="to_type" value="アパート"<?php checked( naniwa_estimate_value( 'to_type' ), 'アパート' ); ?>><span>アパート</span></label>
            <label class="choice"><input type="radio" name="to_type" value="マンション"<?php checked( naniwa_estimate_value( 'to_type' ), 'マンション' ); ?>><span>マンション</span></label>
          </div>
        </div>

        <div class="form-row">
          <span class="label">建物の階数／住居の階数 <span class="req">必須</span></span>
          <div class="form-inline">
            <label class="visually-hidden" for="to-floors">建物の階数</label>
            <input type="number" id="to-floors" name="to_floors" min="1" placeholder="建物の階数" value="<?php echo esc_attr( naniwa_estimate_value( 'to_floors', '0' ) ); ?>">
            <span>階建の</span>
            <label class="visually-hidden" for="to-floor">住居の階数</label>
            <input type="number" id="to-floor" name="to_floor" min="1" placeholder="住居の階数" value="<?php echo esc_attr( naniwa_estimate_value( 'to_floor', '0' ) ); ?>">
            <span>階</span>
          </div>
        </div>

        <div class="form-row">
          <span class="label">エレベーター <span class="req">必須</span></span>
          <div class="choice-grid">
            <label class="choice"><input type="radio" name="to_elevator" value="有"<?php checked( naniwa_estimate_value( 'to_elevator' ), '有' ); ?>><span>有</span></label>
            <label class="choice"><input type="radio" name="to_elevator" value="無"<?php checked( naniwa_estimate_value( 'to_elevator' ), '無' ); ?>><span>無</span></label>
          </div>
        </div>

        <div class="form-row">
          <span class="label">間取り <span class="req">必須</span></span>
          <div class="choice-grid">
            <label class="choice"><input type="radio" name="to_layout" value="1R/1K"<?php checked( naniwa_estimate_value( 'to_layout' ), '1R/1K' ); ?>><span>1R/1K</span></label>
            <label class="choice"><input type="radio" name="to_layout" value="1DK・2K"<?php checked( naniwa_estimate_value( 'to_layout' ), '1DK・2K' ); ?>><span>1DK・2K</span></label>
            <label class="choice"><input type="radio" name="to_layout" value="1LDK・2DK"<?php checked( naniwa_estimate_value( 'to_layout' ), '1LDK・2DK' ); ?>><span>1LDK・2DK</span></label>
            <label class="choice"><input type="radio" name="to_layout" value="2LDK・3K"<?php checked( naniwa_estimate_value( 'to_layout' ), '2LDK・3K' ); ?>><span>2LDK・3K</span></label>
            <label class="choice"><input type="radio" name="to_layout" value="3LDK・4DK"<?php checked( naniwa_estimate_value( 'to_layout' ), '3LDK・4DK' ); ?>><span>3LDK・4DK</span></label>
            <label class="choice"><input type="radio" name="to_layout" value="4LDK以上"<?php checked( naniwa_estimate_value( 'to_layout' ), '4LDK以上' ); ?>><span>4LDK以上</span></label>
          </div>
        </div>

        <div class="form-row">
          <span class="label">メゾネットタイプですか？ <span class="req any">任意</span></span>
          <div class="choice-grid">
            <label class="choice"><input type="radio" name="to_maisonette" value="有"<?php checked( naniwa_estimate_value( 'to_maisonette' ), '有' ); ?>><span>有</span></label>
            <label class="choice"><input type="radio" name="to_maisonette" value="無"<?php checked( naniwa_estimate_value( 'to_maisonette' ), '無' ); ?>><span>無</span></label>
          </div>
        </div>

        <div class="form-row">
          <span class="label">一番大きな荷物の搬出方法 <span class="req any">任意</span></span>
          <div class="choice-grid">
            <label class="choice"><input type="radio" name="to_carry" value="階段"<?php checked( naniwa_estimate_value( 'to_carry' ), '階段' ); ?>><span>階段</span></label>
            <label class="choice"><input type="radio" name="to_carry" value="エレベーター"<?php checked( naniwa_estimate_value( 'to_carry' ), 'エレベーター' ); ?>><span>エレベーター</span></label>
            <label class="choice"><input type="radio" name="to_carry" value="窓から"<?php checked( naniwa_estimate_value( 'to_carry' ), '窓から' ); ?>><span>窓から</span></label>
            <label class="choice"><input type="radio" name="to_carry" value="わからない"<?php checked( naniwa_estimate_value( 'to_carry' ), 'わからない' ); ?>><span>わからない</span></label>
          </div>
        </div>

        <div class="form-row">
          <span class="label">住居入口での駐車 <span class="req any">任意</span></span>
          <div class="choice-grid">
            <label class="choice"><input type="radio" name="to_parking" value="できる"<?php checked( naniwa_estimate_value( 'to_parking' ), 'できる' ); ?>><span>できる</span></label>
            <label class="choice"><input type="radio" name="to_parking" value="できない"<?php checked( naniwa_estimate_value( 'to_parking' ), 'できない' ); ?>><span>できない</span></label>
            <label class="choice"><input type="radio" name="to_parking" value="わからない"<?php checked( naniwa_estimate_value( 'to_parking' ), 'わからない' ); ?>><span>わからない</span></label>
          </div>
        </div>
      </div>
      <div class="form-actions">
      <button class="btn btn-back" type="submit" formaction="<?php echo esc_url( naniwa_page_url( 'estimate-step3' ) ); ?>" formnovalidate>←　戻る</button>
      <button class="btn btn-primary" type="submit">次へ　→</button>
      </div>
    </form>

  </div>
</div>

<?php
get_footer();
