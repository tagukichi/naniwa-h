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

	// 見積フォームの送信内容の保存先。フロントには出さない。
	register_post_type(
		'estimate',
		array(
			'label'           => 'web見積の送信',
			'labels'          => array(
				'name'          => 'web見積の送信',
				'singular_name' => 'web見積の送信',
				'all_items'     => '送信一覧',
				'edit_item'     => '送信内容',
				'search_items'  => '送信内容を検索',
				'not_found'     => '送信はまだありません。',
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 26,
			'supports'        => array( 'title', 'editor' ),
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
			'has_archive'     => false,
			'rewrite'         => false,
			'query_var'       => false,
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'naniwa_register_post_types', 20 );

/**
 * 送信一覧に、お名前・電話・メールの列を出す。
 *
 * @param array<string, string> $columns 既定の列.
 * @return array<string, string>
 */
function naniwa_estimate_columns( $columns ) {
	return array(
		'cb'             => isset( $columns['cb'] ) ? $columns['cb'] : '',
		'title'          => '件名',
		'naniwa_tel'     => '電話番号',
		'naniwa_email'   => 'メールアドレス',
		'naniwa_plan'    => 'ご希望プラン',
		'date'           => '受信日時',
	);
}
add_filter( 'manage_estimate_posts_columns', 'naniwa_estimate_columns' );

/**
 * 追加した列の中身を出力する。
 *
 * @param string $column  列名.
 * @param int    $post_id 投稿ID.
 */
function naniwa_estimate_column_content( $column, $post_id ) {
	$map = array(
		'naniwa_tel'   => '_naniwa_tel',
		'naniwa_email' => '_naniwa_email',
		'naniwa_plan'  => '_naniwa_plan',
	);
	if ( isset( $map[ $column ] ) ) {
		echo esc_html( get_post_meta( $post_id, $map[ $column ], true ) );
	}
}
add_action( 'manage_estimate_posts_custom_column', 'naniwa_estimate_column_content', 10, 2 );
