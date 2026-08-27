<?php
/**
 * このテーマが必要とする固定ページの一覧
 *
 * tools/build_theme.py が自動生成する。直接編集しないこと。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

/**
 * スラッグ => ページ名。
 *
 * @return array<string, string>
 */
function naniwa_required_pages() {
	return array(
		'checklist' => '引越前後やることリスト',
		'company' => '会社案内',
		'couple' => 'カップルの引越',
		'disused' => '不用品処分',
		'estimate-confirm' => '入力内容の確認',
		'estimate-step1' => 'STEP1 お客様情報',
		'estimate-step2' => 'STEP2 引越プランの選択',
		'estimate-step3' => 'STEP3 現在のお住まいの情報',
		'estimate-step4' => 'STEP4 引越先の情報',
		'estimate-step5' => 'STEP5 建物前の道路状況について',
		'estimate-step6-1' => 'STEP6 荷物情報について（家電）',
		'estimate-step6-2' => 'STEP6 荷物情報について（家具）',
		'estimate-step6-3' => 'STEP6 荷物情報について（その他）',
		'estimate-step7' => 'STEP7 オプション',
		'estimate-thanks' => 'お見積りのご依頼ありがとうございました',
		'family' => 'ご家族の引越',
		'faq' => 'よくある質問',
		'flow' => '引越全体のながれ',
		'kiyaku' => '運送約款',
		'now' => '今すぐの引越',
		'office' => 'オフィスの引越・事務所移転',
		'others' => '電気工事、ペット、貴重品 その他',
		'packing' => '梱包の仕方',
		'recruit' => '求人情報',
		'single' => '単身の引越',
	);
}
