<?php
/**
 * web見積フォームのステップと入力項目の対応表
 *
 * このファイルは tools/build_theme.py が静的HTMLから自動生成する。
 * 直接編集せず、src/pages/estimate-*.html を直してから再生成すること。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * ステップ定義を返す。
 *
 * @return array<string, array{title:string, fields:array<string, string>}>
 */
function naniwa_estimate_steps() {
	return array(
		'estimate-step1' => array(
			'title'  => 'お客様情報',
			'fields' => array(
					'name' => 'お名前',
					'kana' => 'ふりがな',
					'tel' => '電話番号',
					'email' => 'メールアドレス',
					'request' => 'その他ご要望',
			),
		),
		'estimate-step2' => array(
			'title'  => '引越プラン',
			'fields' => array(
					'plan' => '引越プラン',
					'plan_note' => 'プランに対する追記事項',
			),
		),
		'estimate-step3' => array(
			'title'  => '現在のお住まい',
			'fields' => array(
					'from_zip' => '郵便番号',
					'from_pref' => '都道府県',
					'from_city' => '市区町村',
					'from_street' => '番地・号',
					'from_bldg' => '建物名など',
					'from_type' => '建物の種類',
					'from_floors' => '建物の階数／住居の階数',
					'from_floor' => '建物の階数／住居の階数',
					'from_elevator' => 'エレベーター',
					'from_layout' => '間取り',
					'from_maisonette' => 'メゾネットタイプですか？',
					'from_carry' => '一番大きな荷物の搬出方法',
					'from_parking' => '住居入口での駐車',
			),
		),
		'estimate-step4' => array(
			'title'  => '引越先',
			'fields' => array(
					'to_zip' => '郵便番号',
					'to_pref' => '都道府県',
					'to_city' => '市区町村',
					'to_street' => '番地・号',
					'to_bldg' => '建物名など',
					'to_type' => '建物の種類',
					'to_floors' => '建物の階数／住居の階数',
					'to_floor' => '建物の階数／住居の階数',
					'to_elevator' => 'エレベーター',
					'to_layout' => '間取り',
					'to_maisonette' => 'メゾネットタイプですか？',
					'to_carry' => '一番大きな荷物の搬出方法',
					'to_parking' => '住居入口での駐車',
			),
		),
		'estimate-step5' => array(
			'title'  => '道路状況',
			'fields' => array(
					'from_road' => 'お住まいの前の道路（現在）',
					'to_road' => 'お住まいの前の道路（引越先）',
					'distance' => '直前の道路から玄関までの距離',
			),
		),
		'estimate-items' => array(
			'title'  => 'お荷物',
			'fields' => array(
			),
		),
		'estimate-step7' => array(
			'title'  => 'オプション',
			'fields' => array(
					'aircon_on' => 'エアコン（取り付け）',
					'aircon_off' => 'エアコン（取り外し）',
					'washlet_on' => 'ウォシュレット（取り付け）',
					'washlet_off' => 'ウォシュレット（取り外し）',
					'dishwasher_on' => '食器洗浄機（取り付け）',
					'dishwasher_off' => '食器洗浄機（取り外し）',
					'special_on' => '特殊家具（取り付け）',
					'special_off' => '特殊家具（取り外し）',
					'other_items' => 'その他のお荷物',
					'other_request' => 'その他、依頼したいこと',
			),
		),
	);
}
