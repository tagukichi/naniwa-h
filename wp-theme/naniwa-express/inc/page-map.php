<?php
/**
 * 固定ページの割り当て解決
 *
 * このテーマはテンプレートをスラッグで割り当てるが、実際のサイトでは
 * スラッグが異なることがある（例：estimate-step1 が step1、
 * recruit が既に使われていて recruit2 になっている、など）。
 * ここでは想定スラッグから実際のページを探し出し、
 * リンク先とテンプレートの両方を正しく解決する。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

const NANIWA_PAGE_MAP_OPTION = 'naniwa_page_map';

/**
 * 想定スラッグに対して自動で探しにいく候補スラッグを返す。
 *
 * @param string $key 想定スラッグ.
 * @return array<int, string>
 */
function naniwa_page_slug_candidates( $key ) {
	$candidates = array( $key );

	// estimate-step1 → step1 のように接頭辞を落としたもの。
	if ( 0 === strpos( $key, 'estimate-' ) ) {
		$candidates[] = substr( $key, strlen( 'estimate-' ) );
	}

	/**
	 * 候補スラッグを追加・変更する。
	 *
	 * @param array<int, string> $candidates 候補.
	 * @param string             $key        想定スラッグ.
	 */
	return apply_filters( 'naniwa_page_slug_candidates', $candidates, $key );
}

/**
 * 想定スラッグから実際の固定ページIDを解決する。
 *
 * 1. 管理画面で手動割り当てされていればそれを使う
 * 2. 候補スラッグと完全一致するページ
 * 3. 候補スラッグに連番が付いたページ（recruit2 / recruit-2 など）
 *
 * @param string $key 想定スラッグ.
 * @return int 見つからなければ 0.
 */
function naniwa_page_id( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}

	$found = 0;

	$map = (array) get_option( NANIWA_PAGE_MAP_OPTION, array() );
	if ( ! empty( $map[ $key ] ) && 'page' === get_post_type( (int) $map[ $key ] ) ) {
		$found = (int) $map[ $key ];
	}

	$candidates = naniwa_page_slug_candidates( $key );

	if ( ! $found ) {
		foreach ( $candidates as $slug ) {
			$page = get_page_by_path( $slug );
			if ( $page ) {
				$found = (int) $page->ID;
				break;
			}
		}
	}

	// get_page_by_path() はルート直下のページしか拾えないため、
	// 下層ページとして作られている場合はスラッグそのもので探し直す。
	if ( ! $found ) {
		$found = naniwa_page_id_by_name( $candidates );
	}

	// recruit → recruit2 のように、後ろに連番が付いてしまったページを拾う。
	if ( ! $found ) {
		$found = naniwa_page_id_by_numbered_slug( $candidates );
	}

	$cache[ $key ] = $found;
	return $found;
}

/**
 * 「スラッグ＋連番」のページを探す。
 *
 * get_page_by_path() は「親/子」の完全なパスを要求するため、
 * 下層ページとして作られていると見つけられない。ここでは階層を無視して探す。
 * 公開 → 非公開 → 下書き の順に優先する。
 *
 * @param array<int, string> $slugs 候補スラッグ.
 * @return int
 */
function naniwa_page_id_by_name( $slugs ) {
	global $wpdb;

	foreach ( $slugs as $slug ) {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts}
				 WHERE post_type = 'page'
				   AND post_status IN ( 'publish', 'private', 'draft' )
				   AND post_name = %s
				 ORDER BY FIELD( post_status, 'publish', 'private', 'draft' ), ID ASC
				 LIMIT 1",
				$slug
			)
		);
		if ( $id ) {
			return (int) $id;
		}
	}
	return 0;
}

/**
 * 「スラッグ＋連番」のページを探す。
 *
 * @param array<int, string> $slugs 候補スラッグ.
 * @return int
 */
function naniwa_page_id_by_numbered_slug( $slugs ) {
	global $wpdb;

	foreach ( $slugs as $slug ) {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$rows = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT ID, post_name FROM {$wpdb->posts}
				 WHERE post_type = 'page' AND post_status = 'publish' AND post_name REGEXP %s
				 ORDER BY ID ASC",
				'^' . $slug . '-?[0-9]+$'
			)
		);
		if ( $rows ) {
			return (int) $rows[0]->ID;
		}
	}
	return 0;
}

/**
 * 想定スラッグに対応するページのURLを返す。
 *
 * 見つからない場合は従来どおり /スラッグ/ を返すので、
 * ページ作成前でもリンク自体は壊れない。
 *
 * @param string $key 想定スラッグ.
 * @return string
 */
function naniwa_page_url( $key ) {
	$id = naniwa_page_id( $key );
	return $id ? get_permalink( $id ) : home_url( '/' . $key . '/' );
}

/**
 * スラッグが違っていても、対応するテンプレートを使わせる。
 *
 * @param string $template WordPress が選んだテンプレート.
 * @return string
 */
function naniwa_template_include( $template ) {
	if ( ! is_page() ) {
		return $template;
	}

	$current = get_queried_object_id();
	$slug    = get_post_field( 'post_name', $current );

	// スラッグがそのまま一致しているなら WordPress の判定に任せる。
	if ( file_exists( get_theme_file_path( '/page-' . $slug . '.php' ) ) ) {
		return $template;
	}

	foreach ( array_keys( naniwa_required_pages() ) as $key ) {
		if ( naniwa_page_id( $key ) !== $current ) {
			continue;
		}
		$candidate = get_theme_file_path( '/page-' . $key . '.php' );
		if ( file_exists( $candidate ) ) {
			return $candidate;
		}
	}

	return $template;
}
add_filter( 'template_include', 'naniwa_template_include', 20 );
