<?php
/**
 * カスタム投稿タイプの登録
 *
 * 旧サイトでは ACF（Pro）側で voice / topics を登録している。
 * ACF が登録済みならこちらでは何もしないので、
 * ACF の有無どちらでもテーマ単体で動作する。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * お客様の声・お知らせを登録する。
 *
 * ACF より後に走らせたいので優先度を下げている。
 */
function naniwa_register_post_types() {
	if ( ! post_type_exists( 'voice' ) ) {
		register_post_type(
			'voice',
			array(
				'label'         => 'お客様の声',
				'labels'        => array(
					'name'          => 'お客様の声',
					'singular_name' => 'お客様の声',
					'add_new_item'  => 'お客様の声を追加',
					'edit_item'     => 'お客様の声を編集',
					'all_items'     => 'お客様の声 一覧',
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'voice', 'with_front' => false ),
				'menu_icon'     => 'dashicons-businesswoman',
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
				'show_in_rest'  => true,
			)
		);
	}

	if ( ! post_type_exists( 'topics' ) ) {
		register_post_type(
			'topics',
			array(
				'label'         => 'お知らせ',
				'labels'        => array(
					'name'          => 'お知らせ',
					'singular_name' => 'お知らせ',
					'add_new_item'  => 'お知らせを追加',
					'edit_item'     => 'お知らせを編集',
					'all_items'     => 'お知らせ 一覧',
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'topics', 'with_front' => false ),
				'menu_icon'     => 'dashicons-megaphone',
				'menu_position' => 6,
				'supports'      => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
				'taxonomies'    => array( 'category' ),
				'show_in_rest'  => true,
			)
		);
	}
}
add_action( 'init', 'naniwa_register_post_types', 20 );
