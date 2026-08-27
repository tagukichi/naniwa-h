<?php
/**
 * NANIWA EXPRESS テーマの初期設定
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

define( 'NANIWA_VERSION', '1.0.0' );

require_once get_theme_file_path( '/inc/cpt.php' );
require_once get_theme_file_path( '/inc/meta-voice.php' );
require_once get_theme_file_path( '/inc/voice-fields.php' );
require_once get_theme_file_path( '/inc/template-tags.php' );
require_once get_theme_file_path( '/inc/estimate-fields.php' );
require_once get_theme_file_path( '/inc/estimate.php' );

/**
 * テーマサポートの宣言。
 */
function naniwa_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'naniwa_setup' );

/**
 * CSS / JS の読み込み。
 */
function naniwa_enqueue_assets() {
	wp_enqueue_style(
		'naniwa-style',
		get_theme_file_uri( '/assets/css/style.css' ),
		array(),
		NANIWA_VERSION
	);

	// テーマ情報用の style.css も読み込んでおく（子テーマからの上書き用）。
	wp_enqueue_style( 'naniwa-theme', get_stylesheet_uri(), array( 'naniwa-style' ), NANIWA_VERSION );

	wp_enqueue_script(
		'naniwa-main',
		get_theme_file_uri( '/assets/js/main.js' ),
		array(),
		NANIWA_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'naniwa_enqueue_assets' );

/**
 * 見積CTAを出さないページに body クラスを付ける。
 *
 * @param array<int, string> $classes body クラス.
 * @return array<int, string>
 */
function naniwa_body_class( $classes ) {
	if ( naniwa_hides_estimate_cta() ) {
		$classes[] = 'no-estimate-cta';
	}
	return $classes;
}
add_filter( 'body_class', 'naniwa_body_class' );

/**
 * 見積CTA（フッター上の帯・スマホ固定バー）を隠すページかどうか。
 *
 * @return bool
 */
function naniwa_hides_estimate_cta() {
	/**
	 * 見積CTAを隠すページのスラッグ。
	 *
	 * @param array<int, string> $slugs スラッグの配列.
	 */
	$slugs = apply_filters( 'naniwa_no_estimate_cta_slugs', array( 'recruit' ) );

	if ( is_page( $slugs ) ) {
		return true;
	}

	// 見積フォームの中では二重に見積CTAを出さない。
	return is_page() && 0 === strpos( (string) get_post_field( 'post_name', get_queried_object_id() ), 'estimate-' );
}

/**
 * 抜粋の省略記号を「…」にする。
 *
 * @return string
 */
function naniwa_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'naniwa_excerpt_more' );

/**
 * 日本語向けに抜粋の文字数を調整する。
 *
 * @return int
 */
function naniwa_excerpt_length() {
	return 60;
}
add_filter( 'excerpt_length', 'naniwa_excerpt_length' );

/**
 * お客様の声・お知らせのアーカイブ表示件数。
 *
 * @param WP_Query $query メインクエリ.
 */
function naniwa_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'voice' ) ) {
		$query->set( 'posts_per_page', 12 );
	}
	if ( $query->is_post_type_archive( 'news' ) ) {
		$query->set( 'posts_per_page', 20 );
	}
}
add_action( 'pre_get_posts', 'naniwa_pre_get_posts' );

/**
 * 応募フォーム（Contact Form 7）のショートコードをカスタマイザーで設定できるようにする。
 *
 * @param WP_Customize_Manager $wp_customize カスタマイザー.
 */
function naniwa_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'naniwa_forms',
		array(
			'title'    => 'なにわ：フォーム設定',
			'priority' => 160,
		)
	);

	$wp_customize->add_setting(
		'naniwa_recruit_form',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'naniwa_recruit_form',
		array(
			'label'       => '応募フォームのショートコード',
			'description' => '求人ページに表示するフォーム。例：[contact-form-7 id="123" title="応募フォーム"]　空欄の場合はデザイン確認用のダミーフォームが表示されます。',
			'section'     => 'naniwa_forms',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'naniwa_customize_register' );
