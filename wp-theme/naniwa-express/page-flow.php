<?php
/**
 * 固定ページ：引越全体のながれ（スラッグ: flow）
 *
 * Template Name: 引越全体のながれ
 *
 * @package naniwa
 */

get_header();
?>

<section class="page-head">
  <div class="inner"><div class="ph-copy">
    <span class="en">FLOW</span>
    <h1>引越全体のながれ</h1>
    <p class="page-lead">新しい生活をスムーズに始めるために知っておきたい引越入門</p>
  </div><p class="ph-chara"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-truckkey-white.svg' ) ); ?>" alt=""></p></div>
</section>

<nav class="breadcrumb" aria-label="パンくずリスト">
  <div class="inner">
    <ol>
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
      <li>引越安心ガイド</li>
      <li>引越全体のながれ</li>
    </ol>
  </div>
</nav>

<div class="page-body">
  <div class="inner">

    <div class="lead-block">
      <h2>新しい生活をスムーズに始めるために<br><span class="mark">知っておきたい引越入門</span></h2>
      <p>お見積りのご依頼から、お引越し当日、そしてアフターフォローまで。なにわ引越センターにご依頼いただいた場合の流れをご紹介します。</p>
    </div>

    <div class="block">
      <div class="steps">

        <div class="step-item">
          <div class="step-no"></div>
          <div class="step-body">
            <h3>お見積り無料！パソコン・またはお電話で簡単にお見積り依頼！</h3>

            <h4>(1) インターネット（パソコン）からのご依頼</h4>
            <p>パソコンからご依頼のお客様は、<a href="<?php echo esc_url( naniwa_page_url( 'estimate-step1' ) ); ?>" style="color:var(--green-600);font-weight:700;text-decoration:underline;">お見積りフォーム</a>からお問い合わせください。インターネットでのお見積りは24時間受け付けております。ご依頼いただくと、24時間以内に引越料金記載のメールをお送りいたします。</p>
            <p>引越の内容を入力する際は、引越先の間取りや道幅、エレベーターの有無、エアコン設置の有無など詳しい情報を入力していただきますと、より詳しい料金を提案することができます。</p>
            <p class="note">※入力内容で確認しきれない点がある場合、概算でのお見積りになることがございます。<br>※まれに休業日などをはさみ、お見積もりを24時間以内にお送りできない事がございます。</p>

            <h4>(2) お電話でのご依頼</h4>
            <p>お電話でのご依頼のお客様は、当社引越受付専用のフリーダイヤル（<a href="tel:0120562728" style="color:var(--green-600);font-weight:700;">0120-562-728</a>）をご利用ください。</p>

            <h4>(3) 訪問見積もり（ご家族様、お荷物の多いお客様）</h4>
            <p>お客様のご自宅にお伺いし、お荷物の量をチェックさせていただきます。その場で詳しいお見積もり料金をご提示いたします。</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-no"></div>
          <div class="step-body">
            <h3>正式なお申し込み・梱包資材のお届け</h3>
            <p>正式なお申し込みは、お電話またはメールで承ります。お申し込みいただきましたら、梱包材および契約書をお客様のご希望日にお送りします。</p>
            <p>スタンダードプランのお客様は、引越当日までに小物の荷造りをお願いいたします。荷造りを行う際には<a href="<?php echo esc_url( naniwa_page_url( 'packing' ) ); ?>" style="color:var(--green-600);font-weight:700;text-decoration:underline;">梱包の仕方</a>をご参考にしてください。</p>
            <div class="notice-box green" style="margin-top:16px;">
              <p><strong>段ボールとガムテープ、食器梱包用紙</strong>を無料で提供しております（提供できる量は引越の量によって違います。ご提供できない場合もございますのでご了承ください）。</p>
            </div>
          </div>
        </div>

        <div class="step-item">
          <div class="step-no"></div>
          <div class="step-body">
            <h3>お時間の確認</h3>
            <p>引越前日の夕方に電話またはメールにて、トラックの到着時間の連絡を差し上げます。</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-no"></div>
          <div class="step-body">
            <h3>ご自宅に到着・搬出まで</h3>

            <h4>大型家具はなにわがプロの技で梱包します。</h4>
            <p>タンスやクローゼット、洗濯機やテレビなどの大型家具・家電の梱包などは、スタッフが専用資材を使用し、プロの技で行います。</p>
            <p class="note">※梱包の際、雑巾などをお貸しいただければ、家具・家電の汚れをキレイにふき取ります。</p>

            <h4>手際よく搬出します。</h4>
            <p>しっかりと梱包した後は搬出です。当社スタッフがスピーディに手際よく搬出し、トラックまで運びます。建物の養生もしっかりと行いますので、思い出一杯の住み慣れた旧居を傷つけることはありません！</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-no"></div>
          <div class="step-body">
            <h3>住所の確認、移動</h3>
            <p>お届け先の住所を確認させていただき、新居へ向け移動します。お客様もスムーズな移動をお願いします。</p>
            <p class="note">※大幅な待機時間が発生しますと、別途料金を頂戴する恐れがございます。</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-no"></div>
          <div class="step-body">
            <h3>新居に到着・搬入</h3>

            <h4>設置場所の打ち合わせをお願いします。</h4>
            <p>引越先に到着したら、家具・家電の設置場所などの打ち合わせをお願いします。</p>

            <h4>養生、搬入開始。配置位置を指示してください。</h4>
            <p>専用資材でしっかりと建物の養生を行い、お荷物の搬入開始です。お荷物の搬入作業も当社スタッフが行いますので、お客様にはお立ち会いいただき、お荷物の配置位置の指示をお願いします。大きなお荷物から小さなお荷物まで、細心の注意を払いスムーズに搬入・配置を進めていきます。</p>

            <h4>家具の組み立て、取り付けもお手伝いいたします。</h4>
            <p>お荷物の搬入・配置のみではなく、家具の組み立て、家電の取り付けなどもお手伝いしますので、なんなりとお申し付けください。「全てお任せフルコースプラン」をお申し込みのお客様は、小物類の「解梱」まで全て当社スタッフが行います。</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-no"></div>
          <div class="step-body">
            <h3>お荷物の搬入完了確認・料金のお支払い</h3>
            <p>全てのお荷物の搬入を完了した後、スタッフよりお客様に搬入作業の完了確認をさせていただきます。運び忘れたお荷物がないかどうかのご確認をお願いいたします。細かな部分などチェックした後、搬入作業の完了となりますので、内容確認後にスタッフが領収書をお持ちしますので、料金をお支払いください。</p>
            <p class="note">※格安長距離便と長距離直送便は、積み込み時のご精算となります。</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-no"></div>
          <div class="step-body">
            <h3>アフターフォロー</h3>
            <p>なにわ引越センターの考える引越はお荷物を全てお運びし、料金をいただいたら終了ではありません。アフターフォローまできっちりと行い、はじめて引越全作業が終了いたします。これがなにわの精神です。</p>

            <h4>段ボールを回収に伺います。</h4>
            <p>お運びしたお荷物の荷解きが落ち着かれましたら、段ボールを回収に伺います（回収は当社が指定した地域に限定させて頂きます）。お引取り日をご相談の上お伺いさせていただきますので、担当者までお問い合わせください。</p>

            <h4>配置の変更はありませんか？</h4>
            <p>新居で不都合な点がございましたらご連絡ください。スタッフが直ちにお伺いし、快適に過ごしていただける環境作りをお手伝いさせていただきます（要相談）。</p>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<?php
get_footer();
