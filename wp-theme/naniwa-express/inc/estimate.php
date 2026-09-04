<?php
/**
 * web見積フォームの送信処理
 *
 * 各ステップの送信先は WordPress 標準の admin-post.php に固定している。
 * ページURLへ直接 POST するとサーバー側で弾かれる環境があるため。
 *
 * 入力内容はサーバー側（トランジェント）に保持し、処理後は次のステップへ
 * リダイレクトする（POST/Redirect/GET）。再読み込みで再送信にならない。
 * 荷物の個数は name="item[ラベル]" で届く。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

const NANIWA_ESTIMATE_COOKIE = 'naniwa_estimate';
const NANIWA_ESTIMATE_TTL    = 3 * HOUR_IN_SECONDS;

/**
 * 入力内容を保存するキーを返す。無ければ発行してCookieに載せる。
 *
 * @param bool $create 未発行のときに新しく作るか.
 * @return string
 */
function naniwa_estimate_token( $create = false ) {
	static $token = null;

	if ( null !== $token ) {
		return $token;
	}

	$token = '';
	if ( ! empty( $_COOKIE[ NANIWA_ESTIMATE_COOKIE ] ) ) {
		$candidate = sanitize_key( wp_unslash( $_COOKIE[ NANIWA_ESTIMATE_COOKIE ] ) );
		if ( 32 === strlen( $candidate ) ) {
			$token = $candidate;
		}
	}

	if ( ! $token && $create ) {
		$token = wp_generate_password( 32, false, false );
		setcookie(
			NANIWA_ESTIMATE_COOKIE,
			$token,
			array(
				'expires'  => time() + NANIWA_ESTIMATE_TTL,
				'path'     => COOKIEPATH ? COOKIEPATH : '/',
				'secure'   => is_ssl(),
				'httponly' => true,
				'samesite' => 'Lax',
			)
		);
		$_COOKIE[ NANIWA_ESTIMATE_COOKIE ] = $token;
	}

	return $token;
}

/**
 * これまでに入力された内容をすべて返す。
 *
 * @return array<string, mixed>
 */
function naniwa_estimate_request() {
	$token = naniwa_estimate_token();
	if ( ! $token ) {
		return array();
	}
	$data = get_transient( 'naniwa_estimate_' . $token );
	return is_array( $data ) ? $data : array();
}

/**
 * 送信された値を保存済みの内容にマージする。
 *
 * @param array<string, mixed> $posted 今回のステップで送られた値.
 */
function naniwa_estimate_merge( $posted ) {
	$token = naniwa_estimate_token( true );
	$data  = naniwa_estimate_request();

	$skip = array( 'action', 'naniwa_next', 'naniwa_estimate_nonce', 'naniwa_estimate_submit', '_wp_http_referer' );

	foreach ( $posted as $key => $value ) {
		if ( ! is_string( $key ) || in_array( $key, $skip, true ) ) {
			continue;
		}
		$data[ $key ] = is_array( $value )
			? array_map( 'sanitize_text_field', $value )
			: sanitize_textarea_field( $value );
	}

	set_transient( 'naniwa_estimate_' . $token, $data, NANIWA_ESTIMATE_TTL );
}

/**
 * 保存した入力内容を破棄する。
 */
function naniwa_estimate_clear() {
	$token = naniwa_estimate_token();
	if ( $token ) {
		delete_transient( 'naniwa_estimate_' . $token );
	}
}

/**
 * 各ステップのフォームに必要な hidden を出力する。
 */
function naniwa_estimate_form_fields() {
	wp_nonce_field( 'naniwa_estimate', 'naniwa_estimate_nonce' );
	echo '<input type="hidden" name="action" value="naniwa_estimate">' . "\n";
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
 * admin-post.php で受け取り、次のステップへリダイレクトする。
 *
 * 送信ボタンが押されたときだけメール送信まで進む。
 */
function naniwa_handle_estimate_post() {
	if ( ! isset( $_POST['naniwa_estimate_nonce'] ) ||
		! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['naniwa_estimate_nonce'] ) ), 'naniwa_estimate' ) ) {
		wp_die( '送信内容を確認できませんでした。お手数ですが最初からやり直してください。' );
	}

	naniwa_estimate_merge( wp_unslash( $_POST ) );

	// 送信ボタン以外は、指定されたステップへ戻す・進める。
	if ( ! isset( $_POST['naniwa_estimate_submit'] ) ) {
		$next = isset( $_POST['naniwa_next'] ) ? sanitize_key( wp_unslash( $_POST['naniwa_next'] ) ) : '';
		$next = array_key_exists( $next, naniwa_required_pages() ) ? $next : 'estimate-step1';

		wp_safe_redirect( naniwa_page_url( $next ) );
		exit;
	}

	naniwa_estimate_send();
}
add_action( 'admin_post_naniwa_estimate', 'naniwa_handle_estimate_post' );
add_action( 'admin_post_nopriv_naniwa_estimate', 'naniwa_handle_estimate_post' );

/**
 * 入力内容をメールで通知し、保存して完了ページへ送る。
 */
function naniwa_estimate_send() {
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
	$post_id = naniwa_estimate_store( $name, $detail );

	// 1通目：管理者宛
	$to      = apply_filters( 'naniwa_estimate_mail_to', get_option( 'admin_email' ) );
	$subject = '【web見積】' . ( '' !== $name ? $name . ' 様' : 'お問い合わせ' );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

	if ( $email && is_email( $email ) ) {
		$headers[] = 'Reply-To: ' . $email;
	}

	$admin_result = naniwa_estimate_mail( $to, $subject, "web見積フォームから以下の内容で送信がありました。\n\n" . $detail, $headers );
	naniwa_estimate_log_mail( $post_id, 'admin', $to, $admin_result );

	// 2通目：お客様宛の自動返信
	if ( $email && is_email( $email ) ) {
		$reply_result = naniwa_estimate_send_autoreply( $email, $name, $detail );
		naniwa_estimate_log_mail( $post_id, 'reply', $email, $reply_result );
	} else {
		naniwa_estimate_log_mail(
			$post_id,
			'reply',
			$email,
			array(
				'sent'  => false,
				'error' => '' === $email ? 'メールアドレスが入力されていません' : '入力されたメールアドレスの形式が正しくありません',
			)
		);
	}

	naniwa_estimate_clear();

	wp_safe_redirect( naniwa_page_url( 'estimate-thanks' ) );
	exit;
}

/**
 * wp_mail() を実行し、成否とエラー内容を返す。
 *
 * サーバーやSMTPプラグイン側で弾かれた場合、wp_mail() は false を返すだけで
 * 理由が分からないため、wp_mail_failed の WP_Error を拾っておく。
 *
 * @param string|string[] $to      宛先.
 * @param string          $subject 件名.
 * @param string          $body    本文.
 * @param string[]        $headers ヘッダー.
 * @return array{sent:bool, error:string}
 */
function naniwa_estimate_mail( $to, $subject, $body, $headers ) {
	$error = '';

	$catch = function ( $wp_error ) use ( &$error ) {
		if ( is_wp_error( $wp_error ) ) {
			$error = $wp_error->get_error_message();
		}
	};

	add_action( 'wp_mail_failed', $catch );
	$sent = wp_mail( $to, $subject, $body, $headers );
	remove_action( 'wp_mail_failed', $catch );

	if ( ! $sent && '' === $error ) {
		$error = '理由不明（wp_mail が false を返しました）';
	}

	return array(
		'sent'  => (bool) $sent,
		'error' => $error,
	);
}

/**
 * メールの送信結果を控えに記録する。
 *
 * @param int    $post_id 控えの投稿ID.
 * @param string $kind    admin または reply.
 * @param string $to      宛先.
 * @param array  $result  naniwa_estimate_mail() の戻り値.
 */
function naniwa_estimate_log_mail( $post_id, $kind, $to, $result ) {
	if ( ! $post_id ) {
		return;
	}

	update_post_meta(
		$post_id,
		'_naniwa_mail_' . $kind,
		array(
			'to'    => (string) $to,
			'sent'  => ! empty( $result['sent'] ),
			'error' => isset( $result['error'] ) ? (string) $result['error'] : '',
			'time'  => time(),
		)
	);
}

/**
 * お客様宛の自動返信メールを送る。
 *
 * @param string $email  宛先.
 * @param string $name   お名前.
 * @param string $detail 入力内容.
 * @return array{sent:bool, error:string}
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

	return naniwa_estimate_mail(
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

/**
 * 管理画面から自動返信メールを再送する。
 */
function naniwa_handle_estimate_resend() {
	$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;

	if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( '権限がありません。' );
	}

	check_admin_referer( 'naniwa_estimate_resend_' . $post_id );

	$post = get_post( $post_id );

	if ( ! $post || 'estimate' !== $post->post_type ) {
		wp_die( '対象の記録が見つかりませんでした。' );
	}

	$email = get_post_meta( $post_id, '_naniwa_email', true );
	$name  = get_post_meta( $post_id, '_naniwa_name', true );

	if ( ! $email || ! is_email( $email ) ) {
		wp_die( 'メールアドレスが記録されていないため再送できません。' );
	}

	$result = naniwa_estimate_send_autoreply( $email, (string) $name, $post->post_content );
	naniwa_estimate_log_mail( $post_id, 'reply', $email, $result );

	wp_safe_redirect(
		add_query_arg(
			'naniwa_resent',
			empty( $result['sent'] ) ? 'failed' : 'ok',
			get_edit_post_link( $post_id, 'url' )
		)
	);
	exit;
}
add_action( 'admin_post_naniwa_estimate_resend', 'naniwa_handle_estimate_resend' );

/**
 * 再送の結果を編集画面に知らせる。
 */
function naniwa_estimate_resend_notice() {
	if ( ! isset( $_GET['naniwa_resent'] ) ) {
		return;
	}

	if ( 'ok' === $_GET['naniwa_resent'] ) {
		echo '<div class="notice notice-success is-dismissible"><p>自動返信メールを再送しました。</p></div>';
	} else {
		echo '<div class="notice notice-error is-dismissible"><p>自動返信メールを再送できませんでした。右の「メールの送信結果」に理由が出ていないか確認してください。</p></div>';
	}
}
add_action( 'admin_notices', 'naniwa_estimate_resend_notice' );
