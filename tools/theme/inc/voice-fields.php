<?php
/**
 * お客様の声のフィールド取得
 *
 * 旧サイトは ACF で項目を持っており、meta_key が環境によって異なる可能性があるため、
 * フィールド名ではなく「ラベル」で照合する。ACF が無い環境では生の postmeta を見る。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * 評価の7軸（表示順）。
 *
 * @return array<int, array{label:string, aliases:array<int, string>}>
 */
function naniwa_voice_axes() {
	return array(
		array( 'label' => '受付時の対応', 'aliases' => array( '受付時の対応', '受付の対応' ) ),
		array( 'label' => '訪問見積り時', 'aliases' => array( '訪問見積り時', '訪問見積時', '見積り時の対応' ) ),
		array( 'label' => '作業員の対応', 'aliases' => array( '作業員の対応', 'スタッフの対応' ) ),
		array( 'label' => 'スムーズさ', 'aliases' => array( 'スムーズさ', '手際' ) ),
		array( 'label' => 'サービス', 'aliases' => array( 'サービス' ) ),
		array( 'label' => '料金', 'aliases' => array( '料　金', '料金' ) ),
		array( 'label' => '満足度', 'aliases' => array( '満足度', '総合満足度' ) ),
	);
}

/**
 * 1件分のフィールドを「ラベル => 値」で返す。
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

	// ACF が無い、または値が取れない場合は生の postmeta で補う。
	foreach ( get_post_meta( $post_id ) as $key => $values ) {
		if ( '_' === substr( $key, 0, 1 ) || isset( $data[ $key ] ) ) {
			continue;
		}
		$data[ $key ] = count( $values ) > 1 ? $values : reset( $values );
	}

	$cache[ $post_id ] = $data;
	return $data;
}

/**
 * ラベル（別名可）で値を取り出す。
 *
 * @param array<string, mixed> $data    naniwa_voice_data() の戻り値.
 * @param array<int, string>   $aliases 候補ラベル.
 * @param string               $default 見つからないときの値.
 * @return string
 */
function naniwa_voice_get( $data, $aliases, $default = '' ) {
	foreach ( (array) $aliases as $label ) {
		if ( ! isset( $data[ $label ] ) ) {
			continue;
		}
		$value = $data[ $label ];
		if ( is_array( $value ) ) {
			$value = implode( '、', array_filter( array_map( 'strval', $value ) ) );
		}
		$value = trim( (string) $value );
		if ( '' !== $value ) {
			return $value;
		}
	}
	return $default;
}

/**
 * 0〜5 の評価値として取り出す。範囲外・非数値なら null。
 *
 * @param array<string, mixed> $data    naniwa_voice_data() の戻り値.
 * @param array<int, string>   $aliases 候補ラベル.
 * @return float|null
 */
function naniwa_voice_rating( $data, $aliases ) {
	foreach ( (array) $aliases as $label ) {
		if ( ! isset( $data[ $label ] ) || is_array( $data[ $label ] ) ) {
			continue;
		}
		$value = trim( (string) $data[ $label ] );
		if ( '' === $value || ! is_numeric( $value ) ) {
			continue;
		}
		$value = (float) $value;
		if ( $value >= 0 && $value <= 5 ) {
			return $value;
		}
	}
	return null;
}

/**
 * 料金（金額）を取り出す。評価軸の「料　金」と混同しないよう 0〜5 の値は除外する。
 *
 * @param array<string, mixed> $data naniwa_voice_data() の戻り値.
 * @return string
 */
function naniwa_voice_price( $data ) {
	foreach ( array( '料金', 'ご料金', '金額', '料　金' ) as $label ) {
		if ( ! isset( $data[ $label ] ) || is_array( $data[ $label ] ) ) {
			continue;
		}
		$value = trim( (string) $data[ $label ] );
		if ( '' === $value ) {
			continue;
		}
		// 0〜5 の数値は評価軸なので金額としては扱わない。
		if ( is_numeric( $value ) && (float) $value >= 0 && (float) $value <= 5 ) {
			continue;
		}
		if ( is_numeric( str_replace( ',', '', $value ) ) ) {
			return number_format( (float) str_replace( ',', '', $value ) ) . '円';
		}
		return $value;
	}
	return '';
}

/**
 * カード・詳細で共通して使う代表値をまとめて返す。
 *
 * @param int $post_id 投稿ID.
 * @return array<string, string|float|null>
 */
function naniwa_voice_summary( $post_id ) {
	$data = naniwa_voice_data( $post_id );

	$overall = naniwa_voice_rating( $data, array( '満足度', '総合満足度', '評価' ) );

	// 満足度が無い場合は他の軸の平均で代用する。
	if ( null === $overall ) {
		$values = array();
		foreach ( naniwa_voice_axes() as $axis ) {
			$one = naniwa_voice_rating( $data, $axis['aliases'] );
			if ( null !== $one && $one > 0 ) {
				$values[] = $one;
			}
		}
		if ( $values ) {
			$overall = array_sum( $values ) / count( $values );
		}
	}

	return array(
		'rating'  => $overall,
		'kind'    => naniwa_voice_get( $data, array( '引越種別', '種別', 'コース', '引越プラン種別' ) ),
		'plan'    => naniwa_voice_get( $data, array( '引越プラン', 'プラン' ) ),
		'area'    => naniwa_voice_get( $data, array( '地域', '区間', 'お引越し区間', 'エリア' ) ),
		'age'     => naniwa_voice_get( $data, array( '年代', '年齢' ) ),
		'gender'  => naniwa_voice_get( $data, array( '性別' ) ),
		'date'    => naniwa_voice_get( $data, array( '作業日', '引越日' ) ),
		'rated'   => naniwa_voice_get( $data, array( '評価日', '投稿日' ) ),
		'price'   => naniwa_voice_price( $data ),
		'good'    => naniwa_voice_get( $data, array( '良かった点', 'よかった点' ) ),
		'bad'     => naniwa_voice_get( $data, array( '悪かった点', 'わるかった点' ) ),
		'reply'   => naniwa_voice_get( $data, array( 'なにわ引越センターより', '返信', '弊社より', 'コメント返信' ) ),
	);
}

/**
 * カードに出す肩書き（「ご家族の引越 スタンダード」など）を組み立てる。
 *
 * @param array<string, string|float|null> $s naniwa_voice_summary() の戻り値.
 * @return string
 */
function naniwa_voice_tag_text( $s ) {
	return trim( $s['kind'] . ( $s['kind'] && $s['plan'] ? ' ' : '' ) . $s['plan'] );
}

/**
 * カードに出す属性（「磯子区→中区／30代／男性」など）を組み立てる。
 *
 * @param array<string, string|float|null> $s naniwa_voice_summary() の戻り値.
 * @return string
 */
function naniwa_voice_who_text( $s ) {
	$parts = array_filter( array( $s['area'], $s['age'], $s['gender'] ) );
	return implode( '／', $parts );
}
