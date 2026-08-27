<?php
/**
 * 固定ページ：単身の引越（スラッグ: single）
 *
 * Template Name: 単身の引越
 *
 * @package naniwa
 */

get_header();
?>

<section class="page-head">
  <div class="inner"><div class="ph-copy">
    <span class="en">SINGLE</span>
    <h1>単身の引越</h1>
    <p class="page-lead">お値段安くて当たりまえ！仕事もサービスも充実！！</p>
  </div><p class="ph-chara"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/chara-girl.svg' ) ); ?>" alt=""></p></div>
</section>

<nav class="breadcrumb" aria-label="パンくずリスト">
  <div class="inner">
    <ol>
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
      <li>単身の引越</li>
    </ol>
  </div>
</nav>

<div class="page-body">
  <div class="inner">

    <div class="lead-block">
      <h2><span class="mark">お値段安くて当たりまえ！</span><br>仕事もサービスも充実！！</h2>
      <p>単身のお客様はお持ちになっている荷物がそれほど多くないので、安いのは当然です。値段にとらわれ疎かになりがちなサービスも、なにわ引越センターは全力で行っております！</p>
    </div>

    <div class="block">
      <h2 class="h-sec">3つのプランからお選びいただけます</h2>

      <div class="plan-detail">
        <p class="ribbon">とことん値段にこだわりたい！</p>
        <div class="pd-body">
          <h3>単身引越スタンダードプラン</h3>
          <p>小物の梱包および開梱をお客様が行い、大型家具・家電の梱包、荷物の搬出、搬入、配置をなにわ引越センターで行うプランです。</p>
          <p>別途オプションにて、お荷物の一部から梱包を承っておりますので、「台所部分だけ手伝って欲しい！」など、ご要望がございましたら、お気軽にお問い合わせください。</p>
                  <div class="plan-dialog"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/dialog-single-std.svg' ) ); ?>" alt="女性「引越準備は自分でします」／なにわ「大型家具、梱包と荷物を運びます！」" loading="lazy"></div>
        </div>
      </div>

      <div class="plan-detail">
        <p class="ribbon">梱包も手伝って欲しい！忙しい人の梱包プラン</p>
        <div class="pd-body">
          <h3>梱包＋単身引越スタンダードプラン</h3>
          <p>こちらのプランでは梱包の全て、搬出、搬入、配置まで全てなにわ引越センターのスタッフが行っております。</p>
          <p>「荷造りする時間が無い！」と考えているお客様には最適なプランになっております。</p>
                  <div class="plan-dialog"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/dialog-single-pack.svg' ) ); ?>" alt="女性「準備はラク、引越後はゆっくり開梱」／なにわ「梱包から運搬、配置までお任せ！」" loading="lazy"></div>
        </div>
      </div>

      <div class="plan-detail">
        <p class="ribbon">新しい生活をすぐにスタート！ラクしたい人のフルコースプラン</p>
        <div class="pd-body">
          <h3>単身引越全てお任せフルコースプラン</h3>
          <p>こちらのプランでは梱包の全て、搬出、搬入、配置まで全てなにわ引越センターのスタッフが行っております。</p>
          <p>「荷造りする時間が無い！」と考えているお客様には最適なプランになっております。</p>
                  <div class="plan-dialog"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/dialog-single-full.svg' ) ); ?>" alt="女性「引越準備は自分でします」／なにわ「大型家具、梱包と荷物を運びます！」" loading="lazy"></div>
        </div>
      </div>
    </div>

    <div class="block">
      <h2 class="h-sec">単身のお引越しでも、サービスは充実</h2>
      <div class="card-grid">
        <div class="info-card">
          <h3>梱包資材が無料</h3>
          <p>段ボール・ガムテープ・食器梱包用紙を無料でご提供。お荷物の量に応じてお届けします。</p>
        </div>
        <div class="info-card">
          <h3>24時間以内にお見積り返信</h3>
          <p>単身のお客様からのお見積りは24時間以内にご返信。お急ぎの方でも安心です。</p>
        </div>
        <div class="info-card">
          <h3>段ボールを回収</h3>
          <p>荷解きが落ち着かれた頃に、段ボールの回収にお伺いします（一部有料の場合あり）。</p>
        </div>
      </div>
    </div>

    <div class="block">
      <div class="notice-box green">
        <h4>お引越しの流れを知りたい方へ</h4>
        <p>お見積りから当日の作業、アフターフォローまでの流れは<a href="<?php echo esc_url( home_url( '/flow/' ) ); ?>" style="color:var(--green-600);font-weight:700;text-decoration:underline;">引越全体の流れ</a>でご確認いただけます。荷造りの方法は<a href="<?php echo esc_url( home_url( '/packing/' ) ); ?>" style="color:var(--green-600);font-weight:700;text-decoration:underline;">梱包の仕方</a>をご覧ください。</p>
      </div>
    </div>

  </div>
</div>

<?php
get_footer();
