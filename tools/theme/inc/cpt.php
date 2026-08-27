<?php
/**
 * カスタム投稿タイプ・タクソノミーの登録
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * お客様の声・お知らせを登録する。
 */
function naniwa_register_post_types() {
	register_post_type(
		'voice',
		array(
			'label'         => 'お客様の声',
			'labels'        => array(
				'name'          => 'お客様の声',
				'singular_name' => 'お客様の声',
				'add_new_item'  => 'お客様の声を追加',
				'edit_item'     => 'お客様の声を編集',
				'all_items'     => 'お客様の声一覧',
			),
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'voice', 'with_front' => false ),
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'excerpt' ),
			'show_in_rest'  => true,
		)
	);

	register_post_type(
		'news',
		array(
			'label'         => 'お知らせ',
			'labels'        => array(
				'name'          => 'お知らせ',
				'singular_name' => 'お知らせ',
				'add_new_item'  => 'お知らせを追加',
				'edit_item'     => 'お知らせを編集',
				'all_items'     => 'お知らせ一覧',
			),
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'news', 'with_front' => false ),
			'menu_icon'     => 'dashicons-megaphone',
			'menu_position' => 6,
			'supports'      => array( 'title', 'editor' ),
			'show_in_rest'  => true,
		)
	);

	register_taxonomy(
		'voice_plan',
		'voice',
		array(
			'label'        => 'ご利用プラン',
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'voice-plan', 'with_front' => false ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'naniwa_register_post_types' );
