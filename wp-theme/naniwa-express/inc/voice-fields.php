<?php
/**
 * お客様の声のフィールド取得
 *
 * 旧サイトの ACF 定義（docs/acf-export-2026-08-27.json）に合わせている。
 * フィールド名で直接引き、取れない場合はラベルで照合するフォールバックを持つ。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * 評価の7軸（表示順）。
 *
 * @return array<int, array{label:string, name:string, aliases:array<int, string>}>
 */
function naniwa_voice_axes() {
	return array(
		array(
			'label'   => '受付時の対応',
			'name'    => 'rating_reception',
			'aliases' => array( '受付時の対応（星の数を入力します）', '受付時の対応' ),
		),
		array(
			'label'   => '訪問見積り時',
			'name'    => 'rating_estimate',
			'aliases' => array( '訪問見積り時（星の数を入力します）', '訪問見積り時' ),
		),
		array(
			'label'   => '作業員の対応',
			'name'    => 'rating_staff',
			'aliases' => array( '作業員の対応（星の数を入力します）', '作業員の対応' ),
		),
		array(
			'label'   => 'スムーズさ',
			'name'    => 'rating_speed',
			'aliases' => array( 'スムーズさ（星の数を入力します）', 'スムーズさ' ),
		),
		array(
			'label'   => 'サービス',
			'name'    => 'rating_service',
			'aliases' => array( 'サービス（星の数を入力します）', 'サービス' ),
		),
		array(
			'label'   => '料金',
			'name'    => 'rating_price',
			'aliases' => array( '料金（星の数を入力します）', '料　金' ),
		),
		array(
			'label'   => '満足度',
			'name'    => 'rating_total',
			'aliases' => array( '満足度（星の数を入力します）', '満足度' ),
		),
	);
}

/**
 * 1件分のフィールドを「ラベル => 値」で返す（フォールバック用）。
 *
 * @param int $post_id 投稿ID.
 * @return array<string, mixed>
 */
function naniwa_voice_data( $post_id ) {
	static $cache = array();
	if ( isset( $cache[ $post_id ] ) ) {
		return $cache[ $post_id ];
	}

	$data = array();

	if ( function_exists( 'get_field_objects' ) ) {
		$objects = get_field_objects( $post_id );
		if ( $objects ) {
			foreach ( $objects as $object ) {
				if ( isset( $object['label'] ) && '' !== $object['label'] ) {
					$data[ $object['label'] ] = $object['value'];
				}
			}
		}
	}

	$cache[ $post_id ] = $data;
	return $data;
}

/**
 * フィールド名で値を取り出す。取れなければラベルで探す。
 *
 * @param int                $post_id 投稿ID.
 * @param string             $name    ACF のフィールド名.
 * @param array<int, string> $aliases 代替のラベル.
 * @return string
 */
function naniwa_voice_field( $post_id, $name, $aliases = array() ) {
	$value = null;

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, $post_id );
	}
	if ( null === $value || '' === $value || false === $value ) {
		$value = get_post_meta( $post_id, $name, true );
	}
	if ( '' === $value || null === $value || false === $value ) {
		$data = naniwa_voice_data( $post_id );
		foreach ( (array) $aliases as $label ) {
			if ( isset( $data[ $label ] ) && '' !== $data[ $label ] ) {
				$value = $data[ $label ];
				break;
			}
		}
	}

	if ( is_array( $value ) ) {
		$value = implode( '、', array_filter( array_map( 'strval', $value ) ) );
	}
	return trim( (string) $value );
}

/**
 * 0〜5 の評価値として取り出す。範囲外・未入力なら null。
 *
 * @param int                $post_id 投稿ID.
 * @param string             $name    ACF のフィールド名.
 * @param array<int, string> $aliases 代替のラベル.
 * @return float|null
 */
function naniwa_voice_rating( $post_id, $name, $aliases = array() ) {
	$value = naniwa_voice_field( $post_id, $name, $aliases );
	if ( '' === $value || ! is_numeric( $value ) ) {
		return null;
	}
	$value = (float) $value;
	return ( $value >= 0 && $value <= 5 ) ? $value : null;
}

/**
 * 料金（金額）を整形して返す。
 *
 * @param int $post_id 投稿ID.
 * @return string
 */
function naniwa_voice_price( $post_id ) {
	$value = naniwa_voice_field( $post_id, 'fee', array( '料金' ) );
	if ( '' === $value ) {
		return '';
	}
	$digits = str_replace( array( ',', '円', '￥', '¥' ), '', $value );
	if ( is_numeric( $digits ) ) {
		return number_format( (float) $digits ) . '円';
	}
	return $value;
}

/**
 * カード・詳細で共通して使う値をまとめて返す。
 *
 * @param int $post_id 投稿ID.
 * @return array<string, string|float|null>
 */
function naniwa_voice_summary( $post_id ) {
	// 顔アイコン用の総合評価。「評価画像」が無ければ満足度で代用する。
	$rating = naniwa_voice_rating( $post_id, 'rating', array( '評価画像' ) );
	if ( null === $rating ) {
		$rating = naniwa_voice_rating( $post_id, 'rating_total', array( '満足度（星の数を入力します）', '満足度' ) );
	}

	// それも無ければ、値の入っている軸の平均で代用する。
	if ( null === $rating ) {
		$values = array();
		foreach ( naniwa_voice_axes() as $axis ) {
			$one = naniwa_voice_rating( $post_id, $axis['name'], $axis['aliases'] );
			if ( null !== $one && $one > 0 ) {
				$values[] = $one;
			}
		}
		if ( $values ) {
			$rating = array_sum( $values ) / count( $values );
		}
	}

	return array(
		'rating'  => $rating,
		'kind'    => naniwa_voice_field( $post_id, 'kinds', array( '引越の種別' ) ),
		'grade'   => naniwa_voice_field( $post_id, 'grade', array( 'グレード' ) ),
		'area'    => naniwa_voice_field( $post_id, 'place', array( '地域（例：磯子区→中区）', '地域' ) ),
		'lead'    => naniwa_voice_field( $post_id, 'introduction', array( '冒頭文章' ) ),
		'age'     => naniwa_voice_field( $post_id, 'age', array( '年代' ) ),
		'gender'  => naniwa_voice_field( $post_id, 'gender', array( '性別' ) ),
		'workday' => naniwa_voice_field( $post_id, 'sagyoubi', array( '作業日' ) ),
		'rated'   => naniwa_voice_field( $post_id, 'date', array( '評価日' ) ),
		'price'   => naniwa_voice_price( $post_id ),
		'good'    => naniwa_voice_field( $post_id, 'good', array( '良かった点' ) ),
		'bad'     => naniwa_voice_field( $post_id, 'bad', array( '悪かった点' ) ),
		'reply'   => naniwa_voice_field( $post_id, 'message', array( 'メッセージ' ) ),
	);
}

/**
 * カードに出す肩書き（「ご家族の引越 スタンダード」など）を組み立てる。
 *
 * @param array<string, string|float|null> $s naniwa_voice_summary() の戻り値.
 * @return string
 */
function naniwa_voice_tag_text( $s ) {
	return trim( $s['kind'] . ( $s['kind'] && $s['grade'] ? ' ' : '' ) . $s['grade'] );
}

/**
 * カードに出す属性（「磯子区→中区／30代／男性」など）を組み立てる。
 *
 * @param array<string, string|float|null> $s naniwa_voice_summary() の戻り値.
 * @return string
 */
function naniwa_voice_who_text( $s ) {
	return implode( '／', array_filter( array( $s['area'], $s['age'], $s['gender'] ) ) );
}
