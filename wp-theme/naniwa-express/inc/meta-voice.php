<?php
/**
 * お客様の声のカスタムフィールド（プラグイン非依存）
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * 登録するフィールドの定義を返す。
 *
 * @return array<string, array{label:string, type:string, hint?:string}>
 */
function naniwa_voice_fields() {
	return array(
		'_naniwa_rating' => array(
			'label' => 'ご満足度（★の数）',
			'type'  => 'rating',
		),
		'_naniwa_plan'   => array(
			'label' => 'ご利用プラン',
			'type'  => 'text',
			'hint'  => '例：ご家族の引越 スタンダード',
		),
		'_naniwa_route'  => array(
			'label' => 'お引越し区間',
			'type'  => 'text',
			'hint'  => '例：磯子区 → 中区',
		),
		'_naniwa_who'    => array(
			'label' => '年代・性別',
			'type'  => 'text',
			'hint'  => '例：30代／男性　※非公開の場合は「秘密」',
		),
		'_naniwa_reply'  => array(
			'label' => 'なにわ引越センターより',
			'type'  => 'textarea',
			'hint'  => '返信コメント。空欄の場合はブロックごと非表示になります。',
		),
	);
}

/**
 * メタボックスを追加する。
 *
 * ACF が同じ項目を管理している環境では出さない（入力欄が二重になるため）。
 */
function naniwa_add_voice_meta_box() {
	if ( function_exists( 'get_field_objects' ) ) {
		return;
	}

	add_meta_box(
		'naniwa-voice-detail',
		'お客様の声の詳細',
		'naniwa_render_voice_meta_box',
		'voice',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'naniwa_add_voice_meta_box' );

/**
 * メタボックスの中身を出力する。
 *
 * @param WP_Post $post 編集中の投稿.
 */
function naniwa_render_voice_meta_box( $post ) {
	wp_nonce_field( 'naniwa_save_voice', 'naniwa_voice_nonce' );
	echo '<style>.naniwa-mb p{margin:0 0 16px}.naniwa-mb label{display:block;font-weight:600;margin-bottom:4px}.naniwa-mb input[type=text],.naniwa-mb textarea,.naniwa-mb select{width:100%}.naniwa-mb .hint{color:#666;font-size:12px;margin-top:4px}</style>';
	echo '<div class="naniwa-mb">';

	foreach ( naniwa_voice_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		$id    = esc_attr( $key );

		echo '<p>';
		printf( '<label for="%s">%s</label>', $id, esc_html( $field['label'] ) );

		if ( 'rating' === $field['type'] ) {
			echo '<select name="' . $id . '" id="' . $id . '">';
			echo '<option value="">未設定</option>';
			for ( $i = 5; $i >= 1; $i-- ) {
				printf(
					'<option value="%1$d"%2$s>%1$d（%3$s）</option>',
					$i,
					selected( (string) $i, (string) $value, false ),
					esc_html( str_repeat( '★', $i ) )
				);
			}
			echo '</select>';
		} elseif ( 'textarea' === $field['type'] ) {
			printf( '<textarea name="%s" id="%s" rows="4">%s</textarea>', $id, $id, esc_textarea( $value ) );
		} else {
			printf( '<input type="text" name="%s" id="%s" value="%s">', $id, $id, esc_attr( $value ) );
		}

		if ( ! empty( $field['hint'] ) ) {
			printf( '<span class="hint">%s</span>', esc_html( $field['hint'] ) );
		}
		echo '</p>';
	}

	echo '</div>';
}

/**
 * メタボックスの値を保存する。
 *
 * @param int $post_id 投稿ID.
 */
function naniwa_save_voice_meta( $post_id ) {
	if ( ! isset( $_POST['naniwa_voice_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['naniwa_voice_nonce'] ) ), 'naniwa_save_voice' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( naniwa_voice_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $key ] );

		if ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( $raw );
		} elseif ( 'rating' === $field['type'] ) {
			$value = '' === $raw ? '' : (string) max( 1, min( 5, (int) $raw ) );
		} else {
			$value = sanitize_text_field( $raw );
		}

		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_voice', 'naniwa_save_voice_meta' );
