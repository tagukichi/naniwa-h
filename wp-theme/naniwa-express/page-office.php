<?php
/**
 * 固定ページ：オフィスの引越・事務所移転（スラッグ: office）
 *
 * Template Name: オフィスの引越・事務所移転
 *
 * @package naniwa
 */

get_header();
?>

<section class="page-head">
  <div class="inner"><div class="ph-copy">
    <span class="en">OFFICE</span>
    <h1>オフィスの引越</h1>
    <p class="page-lead">大きなオフィスからSOHOまで、スムーズに移転！</p>
  </div><p class="ph-chara"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/chara-building.svg' ) ); ?>" alt=""></p></div>
</section>

<nav class="breadcrumb" aria-label="パンくずリスト">
  <div class="inner">
    <ol>
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
      <li>オフィスの引越</li>
    </ol>
  </div>
</nav>

<div class="page-body">
  <div class="inner">

    <div class="lead-block">
      <h2>大きなオフィスからSOHOまで、<br><span class="mark">スムーズに移転！</span></h2>
      <p>事務所移転でいちばん大切なことは、いかに日常業務への影響を小さくし、迅速な引越ができるかです。これは一般的な引越とは、ややテクニックが違います。なにわ引越センターでは、これまでの事務所移転の実績を活かしスピーディーな移転を可能にします。</p>
    </div>

    <div class="block">
      <div class="flow-panel">
        <p class="fp-title">経験豊富な私たちにお任せください！</p>
        <div class="fp-lead">
          <p>事務所移転には、通常の業務に支障をきたさないスムーズな進行が求められます。</p>
          <p>当社にお任せいただきますと、綿密な打ち合わせから始まり、長年の経験で培ったノウハウと、経験豊富な人材を多数揃え、効率良く搬出、搬入作業を行います。</p>
        </div>

        <h2 class="fp-heading">事務所移転の流れ</h2>
        <div class="flowcards">

          <div class="flowcard">
            <h3>事務所移転<br>スケジュール作成</h3>
            <span class="fc-icon"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-calendar.svg' ) ); ?>" alt="" loading="lazy"></span>
            <p>事務所移転日の決定から、作業の詳細まで効率的なスケジュールを打ち合わせの上決定します。</p>
          </div>

          <div class="flowcard">
            <h3>オフィスレイアウトの<br>確定</h3>
            <span class="fc-icon"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-layout.svg' ) ); ?>" alt="" loading="lazy"></span>
            <p>新事務所のレイアウト詳細を確定していただき、それを元に効率の良い搬入方法を考えます。</p>
          </div>

          <div class="flowcard">
            <h3>お荷物の荷造り</h3>
            <span class="fc-icon"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-carton.svg' ) ); ?>" alt="" loading="lazy"></span>
            <p>引越用の資材をお送りいたしますので、事務所内にある小物類の荷造りをお願いいたします。</p>
          </div>

          <div class="flowcard">
            <h3>荷物の搬出・搬入</h3>
            <span class="fc-icon"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-truck.svg' ) ); ?>" alt="" loading="lazy"></span>
            <p>建物が傷つかないように専用資材を使用し、旧事務所から新事務所まで速やかに搬出・搬入を行います。</p>
          </div>

          <div class="flowcard">
            <h3>専用資材の撤去</h3>
            <span class="fc-icon"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-roll.svg' ) ); ?>" alt="" loading="lazy"></span>
            <p>お仕事の邪魔にならないよう、荷解き後、速やかに専用資材を回収します。</p>
          </div>

          <div class="flowcard">
            <h3>新しい事務所で<br>サービス開始！</h3>
            <span class="fc-icon"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/chars/ico-laptop.svg' ) ); ?>" alt="" loading="lazy"></span>
            <p>当初の予定通りに仕事が開始できるよう、電気・電話工事等は前日に完了させておくことをおすすめいたします。</p>
          </div>

        </div>
      </div>
    </div>

    <div class="block">
      <div class="notice-box">
        <h4>不用品・什器の処分もあわせて承ります</h4>
        <p>移転にともなうOA機器やオフィス什器の処分も対応可能です。事前にご提示した処分料金のみで承ります。詳しくは<a href="<?php echo esc_url( naniwa_page_url( 'disused' ) ); ?>" style="color:var(--green-600);font-weight:700;text-decoration:underline;">不用品処分</a>をご覧ください。</p>
      </div>
    </div>

  </div>
</div>

<?php
get_footer();
