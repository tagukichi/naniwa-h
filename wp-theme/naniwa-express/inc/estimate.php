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

	$to      = apply_filters( 'naniwa_estimate_mail_to', get_option( 'admin_email' ) );
	$subject = '【web見積】' . ( '' !== $name ? $name . ' 様' : 'お問い合わせ' );
	$body    = "web見積フォームから以下の内容で送信がありました。\n\n" . implode( "\n", $lines );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

	$email = naniwa_estimate_value( 'email' );
	if ( $email && is_email( $email ) ) {
		$headers[] = 'Reply-To: ' . $email;
	}

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( home_url( '/estimate-thanks/' ) );
	exit;
}
add_action( 'template_redirect', 'naniwa_handle_estimate_submit' );
