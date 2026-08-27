<?php
/**
 * 共通フッター
 *
 * @package naniwa
 */

?>
</main>
<!-- 見積CTA -->
<section class="cta-band">
  <div class="inner">
    <p class="cta-catch">条件入力で仮見積！</p>

    <div class="cta-box">
      <a class="cta-estimate" href="<?php echo esc_url( naniwa_page_url( 'estimate-step1' ) ); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        <span>無料お見積もり</span>
      </a>

      <div class="cta-tel">
        <a href="tel:0120562728">
          <img class="freedial" src="<?php echo esc_url( get_theme_file_uri( '/assets/img/freedial.svg' ) ); ?>" alt="フリーダイヤル" width="59" height="35">
          <span class="num">0120-562-728</span>
        </a>
        <small>9:00〜20:00（年中無休）</small>
        <p class="cta-tel-label">お電話でのお問い合わせ</p>
      </div>
    </div>

    <p class="cta-tiktok">
      <a href="https://www.tiktok.com/@naniwahikkoshi?is_from_webapp=1&amp;sender_device=pc" target="_blank" rel="noopener">
        <img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/tiktok-5off.svg' ) ); ?>" alt="TikTokを見た方に5%off" width="963" height="99" loading="lazy">
      </a>
    </p>
  </div>
</section>

<footer class="site-footer">
  <div class="inner">
    <div class="footer-grid">
      <div class="footer-about">
        <p class="footer-logo"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/logo.svg' ) ); ?>" alt="なにわ引越センター NANIWA EXPRESS" width="200" height="52"></p>
        <address class="footer-addr">〒230-0075 横浜市鶴見区上の宮2-19-25</address>
        <p class="footer-tel">
          <a href="tel:0120562728"><img class="freedial" src="<?php echo esc_url( get_theme_file_uri( '/assets/img/freedial.svg' ) ); ?>" alt="フリーダイヤル" width="59" height="35">0120-562-728</a>
          <small>受付 9:00〜20:00（年中無休）</small>
        </p>
        <div class="sns-links">
          <a href="https://page.line.me/168xzwvo" target="_blank" rel="noopener" aria-label="LINE公式アカウント"><svg viewBox="0 0 24 24"><path d="M12 2.5C6.2 2.5 1.5 6.4 1.5 11.2c0 4.3 3.7 7.9 8.8 8.6.3.1.8.2.9.5.1.3.1.7 0 1l-.1.9c0 .3-.2 1 .9.6 1.1-.5 6-3.6 8.2-6.1 1.5-1.7 2.3-3.4 2.3-5.4 0-4.9-4.7-8.8-10.5-8.8z"/></svg></a>
          <a href="#" aria-label="TikTok"><svg viewBox="0 0 24 24"><path d="M16.6 3c.4 2 1.7 3.4 3.9 3.6v3c-1.5 0-2.8-.5-3.9-1.3v6.3c0 3.9-2.7 6.4-6.2 6.4-3.4 0-5.9-2.5-5.9-5.8 0-3.2 2.4-5.7 5.8-5.7.3 0 .7 0 1 .1v3.2c-.3-.1-.7-.2-1-.2-1.6 0-2.8 1.2-2.8 2.7 0 1.6 1.2 2.7 2.9 2.7 1.8 0 3.1-1.3 3.1-3.5V3h3.1z"/></svg></a>
        </div>
      </div>
      <nav class="footer-nav" aria-label="フッターナビゲーション">
        <h4>引越プラン</h4>
        <ul>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'single' ) ); ?>">単身の引越</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'family' ) ); ?>">ご家族の引越</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'couple' ) ); ?>">カップルの引越</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'now' ) ); ?>">今すぐの引越</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'office' ) ); ?>">オフィスの引越</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'disused' ) ); ?>">不用品処分</a></li>
        </ul>
      </nav>
      <nav class="footer-nav" aria-label="ガイドナビゲーション">
        <h4>引越安心ガイド</h4>
        <ul>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'flow' ) ); ?>">引越全体の流れ</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'packing' ) ); ?>">梱包の仕方</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'others' ) ); ?>">電気工事、ペット、貴重品</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'faq' ) ); ?>">よくあるご質問</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'checklist' ) ); ?>">引越前後やることリスト</a></li>
        </ul>
      </nav>
      <nav class="footer-nav" aria-label="会社情報ナビゲーション">
        <h4>ABOUT US</h4>
        <ul>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'company' ) ); ?>">会社案内</a></li>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'voice' ) ); ?>">お客様の声</a></li>
          <li><a href="<?php echo esc_url( naniwa_blog_url() ); ?>">ブログ</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'recruit' ) ); ?>">求人情報</a></li>
          <li><a href="<?php echo esc_url( naniwa_page_url( 'kiyaku' ) ); ?>">運送約款</a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="footer-bottom">
    <p class="links"><a href="<?php echo esc_url( naniwa_page_url( 'company' ) ); ?>">会社概要</a><a href="#">プライバシーポリシー</a></p>
    <p>© なにわ引越センター All Rights Reserved.</p>
  </div>
</footer>

<!-- モバイル固定CTA -->
<div class="fixed-cta">
  <a class="btn btn-telbar" href="tel:0120562728">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
    電話で相談</a>
  <a class="btn btn-primary" href="<?php echo esc_url( naniwa_page_url( 'estimate-step1' ) ); ?>">無料お見積もり</a>
</div>

<?php wp_footer(); ?>
</body>
</html>
