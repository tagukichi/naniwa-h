<?php
/**
 * 固定ページ：お見積りのご依頼ありがとうございました（スラッグ: estimate-thanks）
 *
 * Template Name: お見積りのご依頼ありがとうございました
 *
 * @package naniwa
 */

get_header();
?>

<section class="page-head">
  <div class="inner"><div class="ph-copy">
    <span class="en">THANK YOU</span>
    <h1>送信が完了しました</h1>
  </div><p class="ph-chara"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-carton-white.svg' ) ); ?>" alt=""></p></div>
</section>

<nav class="breadcrumb" aria-label="パンくずリスト">
  <div class="inner">
    <ol>
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
      <li>web見積</li>
      <li>送信完了</li>
    </ol>
  </div>
</nav>

<div class="page-body">
  <div class="inner">

    <div class="form-card">
      <div class="form-inner">
        <div class="form-done">
          <span class="icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
          </span>
          <h2>お見積りのご依頼<br>ありがとうございました</h2>
          <p>ご入力いただいた内容を受け付けました。<br>担当者より、24時間以内にご連絡いたします。</p>
          <p style="margin-top:18px;" class="note">※まれに休業日などをはさみ、24時間以内にお送りできない場合がございます。<br>※自動返信メールが届かない場合は、迷惑メールフォルダをご確認のうえ、お電話にてお問い合わせください。</p>
        </div>
      </div>
    </div>

    <div class="block" style="margin-top:44px;">
      <div class="notice-box">
        <h4>お急ぎの方はお電話ください</h4>
        <p>当日・翌日のお引越しなどお急ぎの場合は、お電話のほうがスムーズです。</p>
        <p style="margin-top:14px;"><a class="btn btn-primary" href="tel:0120562728" style="padding:14px 32px;font-size:16px;">0120-562-728 に電話する</a></p>
        <p class="note" style="margin-top:10px;">受付 9:00〜20:00（年中無休）</p>
      </div>
    </div>

    <div class="block">
      <h2 class="h-sec">お引越しまでにご確認ください</h2>
      <div class="card-grid">
        <a class="info-card" href="<?php echo esc_url( naniwa_page_url( 'flow' ) ); ?>">
          <h3>引越全体の流れ →</h3>
          <p>お申し込みから当日の作業、アフターフォローまでの流れをご確認いただけます。</p>
        </a>
        <a class="info-card" href="<?php echo esc_url( naniwa_page_url( 'packing' ) ); ?>">
          <h3>梱包の仕方 →</h3>
          <p>段ボールの選び方から食器の包み方まで、正しい荷造りの方法をご紹介します。</p>
        </a>
        <a class="info-card" href="<?php echo esc_url( naniwa_page_url( 'checklist' ) ); ?>">
          <h3>引越前後やることリスト →</h3>
          <p>役所・学校・ライフラインなど、各種お手続きをまとめています。</p>
        </a>
      </div>
    </div>

    <p class="center-more"><a class="btn btn-outline" href="<?php echo esc_url( home_url( '/' ) ); ?>">← トップページへ戻る</a></p>

  </div>
</div>

<?php
get_footer();
