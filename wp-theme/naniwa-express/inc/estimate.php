<?php
/**
 * web見積フォームの送信処理
 *
 * STEP1〜7 を POST でつないでいき、確認画面から送信された内容を
 * メールで通知して完了ページへリダイレクトする。
 * 荷物の個数は name="item[ラベル]" で届く。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * 送信されたリクエストを返す。
 *
 * ステップ間は POST だが、メールのリンクなどから GET で来ることも
 * 想定して両方を見る。
 *
 * @return array<string, mixed>
 */
function naniwa_estimate_request() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	$source = ! empty( $_POST ) ? $_POST : $_GET;
	return wp_unslash( $source );
	// phpcs:enable
}

/**
 * 引き継いだ値を1件取り出す（表示・value属性用）。
 *
 * @param string $key            キー.
 * @param string $default_value  値が無いときの既定値.
 * @return string
 */
function naniwa_estimate_value( $key, $default_value = '' ) {
	$request = naniwa_estimate_request();
	if ( ! isset( $request[ $key ] ) ) {
		return $default_value;
	}
	$raw = $request[ $key ];
	if ( is_array( $raw ) ) {
		return implode( '、', array_map( 'sanitize_text_field', $raw ) );
	}
	return sanitize_text_field( $raw );
}

/**
 * 引き継いだ値を配列のまま取り出す（チェックボックス用）。
 *
 * @param string $key キー.
 * @return array<int, string>
 */
function naniwa_estimate_raw( $key ) {
	$request = naniwa_estimate_request();
	if ( ! isset( $request[ $key ] ) ) {
		return array();
	}
	return array_map( 'sanitize_text_field', (array) $request[ $key ] );
}

/**
 * 荷物の個数を取り出す。
 *
 * @param string $label 荷物名.
 * @return string
 */
function naniwa_estimate_item( $label ) {
	$request = naniwa_estimate_request();
	if ( ! isset( $request['item'][ $label ] ) ) {
		return '0';
	}
	return (string) max( 0, (int) $request['item'][ $label ] );
}

/**
 * 個数が1以上の荷物だけを返す。
 *
 * @return array<string, int>
 */
function naniwa_estimate_items() {
	$request = naniwa_estimate_request();
	$items   = array();

	if ( empty( $request['item'] ) || ! is_array( $request['item'] ) ) {
		return $items;
	}
	foreach ( $request['item'] as $label => $count ) {
		$count = (int) $count;
		if ( $count > 0 ) {
			$items[ sanitize_text_field( $label ) ] = $count;
		}
	}
	return $items;
}

/**
 * これまでのステップで受け取った値を hidden で引き継ぐ。
 *
 * @param array<int, string> $exclude この画面で入力させるため除外するキー.
 */
function naniwa_estimate_carry_over( $exclude = array() ) {
	$exclude[] = 'naniwa_estimate_nonce';
	$exclude[] = 'naniwa_estimate_submit';
	$exclude[] = '_wp_http_referer';

	foreach ( naniwa_estimate_request() as $key => $raw ) {
		if ( ! is_string( $key ) || '' === $key || in_array( $key, $exclude, true ) ) {
			continue;
		}
		naniwa_estimate_hidden_field( $key, $raw );
	}
}

/**
 * hidden を1件（配列なら再帰的に）出力する。
 *
 * @param string       $name フィールド名.
 * @param mixed        $raw  値.
 */
function naniwa_estimate_hidden_field( $name, $raw ) {
	if ( is_array( $raw ) ) {
		foreach ( $raw as $key => $one ) {
			$child = is_int( $key ) ? $name . '[]' : $name . '[' . $key . ']';
			naniwa_estimate_hidden_field( $child, $one );
		}
		return;
	}

	printf(
		'<input type="hidden" name="%s" value="%s">' . "\n",
		esc_attr( $name ),
		esc_attr( sanitize_text_field( (string) $raw ) )
	);
}

/**
 * 見積フォームの送信を処理する。
 */
function naniwa_handle_estimate_submit() {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	if ( ! isset( $_POST['naniwa_estimate_submit'] ) ) {
		return;
	}
	if ( ! isset( $_POST['naniwa_estimate_nonce'] ) ||
		! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['naniwa_estimate_nonce'] ) ), 'naniwa_estimate' ) ) {
		wp_die( '送信内容を確認できませんでした。お手数ですが最初からやり直してください。' );
	}

	$lines = array();
	$name  = '';

	foreach ( naniwa_estimate_steps() as $step ) {
		$section = array();
		foreach ( $step['fields'] as $key => $label ) {
			$value = naniwa_estimate_value( $key );
			if ( '' === $value ) {
				continue;
			}
			if ( 'name' === $key ) {
				$name = $value;
			}
			$section[] = $label . '：' . $value;
		}
		if ( $section ) {
			$lines[] = '【' . $step['title'] . '】';
			$lines   = array_merge( $lines, $section );
			$lines[] = '';
		}
	}

	$items = naniwa_estimate_items();
	if ( $items ) {
		$lines[] = '【お荷物】';
		foreach ( $items as $label => $count ) {
			$lines[] = $label . '：' . $count;
		}
		$lines[] = '';
	}

	$detail = implode( "\n", $lines );
	$email  = naniwa_estimate_value( 'email' );

	// 送信内容を保存しておく（メールが届かなかった場合の控えになる）
	naniwa_estimate_store( $name, $detail );

	// 1通目：管理者宛
	$to      = apply_filters( 'naniwa_estimate_mail_to', get_option( 'admin_email' ) );
	$subject = '【web見積】' . ( '' !== $name ? $name . ' 様' : 'お問い合わせ' );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

	if ( $email && is_email( $email ) ) {
		$headers[] = 'Reply-To: ' . $email;
	}

	wp_mail( $to, $subject, "web見積フォームから以下の内容で送信がありました。\n\n" . $detail, $headers );

	// 2通目：お客様宛の自動返信
	if ( $email && is_email( $email ) ) {
		naniwa_estimate_send_autoreply( $email, $name, $detail );
	}

	wp_safe_redirect( naniwa_page_url( 'estimate-thanks' ) );
	exit;
}

/**
 * お客様宛の自動返信メールを送る。
 *
 * @param string $email  宛先.
 * @param string $name   お名前.
 * @param string $detail 入力内容.
 */
function naniwa_estimate_send_autoreply( $email, $name, $detail ) {
	$site = get_bloginfo( 'name' );
	$from = apply_filters( 'naniwa_estimate_mail_to', get_option( 'admin_email' ) );

	$subject = apply_filters(
		'naniwa_estimate_autoreply_subject',
		'【' . $site . '】お見積りのご依頼ありがとうございます'
	);

	$body = ( '' !== $name ? $name . ' 様' : 'お客様' ) . "\n\n"
		. "この度は" . $site . "へお見積りをご依頼いただき、誠にありがとうございます。\n"
		. "以下の内容で承りました。担当者より折り返しご連絡いたしますので、恐れ入りますがしばらくお待ちください。\n"
		. "※単身・カップルのお客様には24時間以内にご返信いたします。\n\n"
		. "──────────────────────\n"
		. $detail . "\n"
		. "──────────────────────\n\n"
		. "お急ぎの場合はお電話でも承っております。\n"
		. "フリーダイヤル：0120-562-728（9:00〜20:00／年中無休）\n\n"
		. $site . "\n"
		. home_url( '/' ) . "\n\n"
		. "※このメールは自動送信です。ご返信いただいてもお答えできない場合があります。\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $from,
	);

	wp_mail(
		$email,
		$subject,
		apply_filters( 'naniwa_estimate_autoreply_body', $body, $name, $detail ),
		$headers
	);
}

/**
 * 送信内容を投稿として保存する。
 *
 * @param string $name   お名前.
 * @param string $detail 入力内容.
 * @return int 投稿ID.
 */
function naniwa_estimate_store( $name, $detail ) {
	$post_id = wp_insert_post(
		array(
			'post_type'    => 'estimate',
			'post_status'  => 'private',
			'post_title'   => ( '' !== $name ? $name . ' 様' : 'お名前なし' ) . '（' . wp_date( 'Y-m-d H:i' ) . '）',
			'post_content' => $detail,
		)
	);

	if ( ! $post_id || is_wp_error( $post_id ) ) {
		return 0;
	}

	foreach ( array( 'name', 'kana', 'tel', 'email', 'plan' ) as $key ) {
		$value = naniwa_estimate_value( $key );
		if ( '' !== $value ) {
			update_post_meta( $post_id, '_naniwa_' . $key, $value );
		}
	}

	return (int) $post_id;
}
add_action( 'template_redirect', 'naniwa_handle_estimate_submit' );
