<?php
/**
 * web見積フォームのスパム対策（Cloudflare Turnstile）
 *
 * 確認画面の送信ボタンの直前にウィジェットを置き、送信時にサーバー側で検証する。
 * 実際に送信されるのは確認画面の1回だけなので、各ステップには置かない。
 *
 * キーはカスタマイザー（なにわ：フォーム設定）で指定する。未入力のときは
 * Contact Form 7 のインテグレーションに登録済みのキーを使う。
 * どちらにも無ければ、Turnstile は使わず従来どおり送信できる。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

const NANIWA_TURNSTILE_VERIFY = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
const NANIWA_TURNSTILE_SCRIPT = 'https://challenges.cloudflare.com/turnstile/v0/api.js';

/**
 * サイトキーとシークレットキーを返す。
 *
 * @return array{sitekey:string, secret:string, source:string}
 */
function naniwa_turnstile_keys() {
	$site   = trim( (string) get_theme_mod( 'naniwa_turnstile_sitekey', '' ) );
	$secret = trim( (string) get_theme_mod( 'naniwa_turnstile_secret', '' ) );
	$source = 'customizer';

	// 片方だけ入っている状態は使わない（組み合わせが崩れるため）。
	if ( '' === $site || '' === $secret ) {
		$site   = '';
		$secret = '';
		$source = '';

		// Contact Form 7 のインテグレーションに登録済みのキー（sitekey => secret）。
		$wpcf7 = get_option( 'wpcf7' );
		if ( is_array( $wpcf7 ) && ! empty( $wpcf7['turnstile'] ) && is_array( $wpcf7['turnstile'] ) ) {
			foreach ( $wpcf7['turnstile'] as $k => $v ) {
				if ( is_string( $k ) && is_string( $v ) && '' !== trim( $k ) && '' !== trim( $v ) ) {
					$site   = trim( $k );
					$secret = trim( $v );
					$source = 'cf7';
					break;
				}
			}
		}
	}

	/**
	 * Turnstile のキーを差し替える。
	 *
	 * @param array $keys sitekey / secret / source.
	 */
	return apply_filters(
		'naniwa_turnstile_keys',
		array(
			'sitekey' => $site,
			'secret'  => $secret,
			'source'  => $source,
		)
	);
}

/**
 * Turnstile を使うかどうか。
 *
 * @return bool
 */
function naniwa_turnstile_enabled() {
	$keys = naniwa_turnstile_keys();
	return '' !== $keys['sitekey'] && '' !== $keys['secret'];
}

/**
 * 確認画面でだけ Turnstile のスクリプトを読み込む。
 */
function naniwa_turnstile_enqueue() {
	if ( ! naniwa_turnstile_enabled() ) {
		return;
	}

	$confirm = naniwa_page_id( 'estimate-confirm' );
	if ( ! $confirm || ! is_page( $confirm ) ) {
		return;
	}

	wp_enqueue_script(
		'cf-turnstile',
		NANIWA_TURNSTILE_SCRIPT,
		array(),
		null, // Cloudflare 側のURLにバージョン文字列を付けない。
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'naniwa_turnstile_enqueue', 20 );

/**
 * ウィジェットを出力する（確認画面の送信ボタンの直前）。
 */
function naniwa_turnstile_widget() {
	if ( ! naniwa_turnstile_enabled() ) {
		return;
	}

	$keys = naniwa_turnstile_keys();

	echo '<div class="naniwa-turnstile">';
	printf(
		'<div class="cf-turnstile" data-sitekey="%s" data-language="ja" data-refresh-expired="auto"></div>',
		esc_attr( $keys['sitekey'] )
	);
	echo '<noscript><p class="hint">スパム対策のため、JavaScript を有効にしてください。</p></noscript>';
	echo '</div>' . "\n";
}

/**
 * 送信されたトークンを Cloudflare に問い合わせて検証する。
 *
 * お客様の依頼を取りこぼさないことを優先し、こちら側・Cloudflare 側の
 * 都合で検証できないとき（通信エラー、キーの設定ミスなど）は通す。
 * そのかわり結果を控えに記録し、管理画面で気付けるようにする。
 *
 * @param string $token cf-turnstile-response の値.
 * @return array{ok:bool, status:string, error:string}
 */
function naniwa_turnstile_verify( $token ) {
	$keys = naniwa_turnstile_keys();

	if ( '' === $keys['secret'] ) {
		return array(
			'ok'     => true,
			'status' => 'disabled',
			'error'  => '',
		);
	}

	$token = trim( (string) $token );
	if ( '' === $token ) {
		return array(
			'ok'     => false,
			'status' => 'missing',
			'error'  => '',
		);
	}

	$response = wp_remote_post(
		NANIWA_TURNSTILE_VERIFY,
		array(
			'timeout' => 10,
			'body'    => array(
				'secret'   => $keys['secret'],
				'response' => $token,
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return array(
			'ok'     => true,
			'status' => 'unreachable',
			'error'  => $response->get_error_message(),
		);
	}

	$code = (int) wp_remote_retrieve_response_code( $response );
	$data = json_decode( (string) wp_remote_retrieve_body( $response ), true );

	if ( 200 !== $code || ! is_array( $data ) ) {
		return array(
			'ok'     => true,
			'status' => 'unreachable',
			'error'  => 'HTTP ' . $code,
		);
	}

	if ( ! empty( $data['success'] ) ) {
		return array(
			'ok'     => true,
			'status' => 'passed',
			'error'  => '',
		);
	}

	$codes = isset( $data['error-codes'] ) ? array_map( 'strval', (array) $data['error-codes'] ) : array();

	// キーの設定ミスや Cloudflare 側の障害は、お客様のせいではないので通す。
	$config_errors = array( 'missing-input-secret', 'invalid-input-secret', 'internal-error' );
	if ( array_intersect( $codes, $config_errors ) ) {
		return array(
			'ok'     => true,
			'status' => 'config',
			'error'  => implode( ', ', $codes ),
		);
	}

	return array(
		'ok'     => false,
		'status' => 'failed',
		'error'  => implode( ', ', $codes ),
	);
}

/**
 * 検証に失敗したときにお客様へ出す案内文。
 *
 * @param string $status naniwa_turnstile_verify() の status.
 * @return string
 */
function naniwa_turnstile_message( $status ) {
	if ( 'missing' === $status ) {
		return 'スパム対策の確認が完了していませんでした。送信ボタンの上の確認欄にチェックが付いてから、もう一度「この内容で送信する」を押してください。表示されない場合は、お手数ですがお電話（0120-562-728）でご依頼ください。';
	}

	return 'スパム対策の確認ができませんでした。お手数ですが、もう一度「この内容で送信する」を押してください。うまくいかない場合は、お電話（0120-562-728）でご依頼ください。';
}

/**
 * 管理画面に出す検証結果の表記。
 *
 * @param array|string $result naniwa_turnstile_verify() の戻り値.
 * @return array{label:string, color:string}
 */
function naniwa_turnstile_status_label( $result ) {
	$status = is_array( $result ) && isset( $result['status'] ) ? $result['status'] : '';

	switch ( $status ) {
		case 'passed':
			return array( 'label' => '✓ 確認済み', 'color' => '#1a8a5c' );
		case 'disabled':
			return array( 'label' => '— 未設定（キー未登録）', 'color' => '#777' );
		case 'unreachable':
			return array( 'label' => '△ Cloudflareに接続できず未確認で受付', 'color' => '#b26a00' );
		case 'config':
			return array( 'label' => '△ キーの設定エラーのため未確認で受付', 'color' => '#b26a00' );
		default:
			return array( 'label' => '記録なし', 'color' => '#777' );
	}
}
