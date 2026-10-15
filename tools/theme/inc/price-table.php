<?php
/**
 * 不用品ページの料金表を、固定ページの編集画面から書き換えられるようにする
 *
 * 料金表の見た目（表の組み方・デザイン）はテンプレートで固定し、
 * 中身の「品目／サイズ・種別／処分料金」だけを編集画面の入力欄で直せるようにする。
 *
 * 初期値は静的HTML（src/pages/disused.html）から自動生成した
 * naniwa_price_default_tables()（inc/price-defaults.php）。
 * 編集画面で保存した表は、その初期値より優先される。
 *
 * @package naniwa
 */

defined( 'ABSPATH' ) || exit;

const NANIWA_PRICE_META = '_naniwa_price_tables';

/**
 * 1行ぶんのテキスト「品目 | サイズ・種別 | 料金」を表の行に分解する。
 *
 * @param string $text 入力欄の内容.
 * @return array<int, array{0:string,1:string,2:string}>
 */
function naniwa_price_parse( $text ) {
	$rows = array();

	foreach ( preg_split( '/\R/u', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line || 0 === strpos( $line, '#' ) ) {
			continue;
		}

		// 半角・全角の縦棒どちらでも区切れるようにする。
		$cells = array_map( 'trim', preg_split( '/\s*[|｜]\s*/u', $line ) );

		if ( count( $cells ) < 2 ) {
			continue; // 料金が無い行は表にできない
		}
		if ( 2 === count( $cells ) ) {
			// 「品目 | 料金」だけの行はサイズを「―」にする
			$cells = array( $cells[0], '―', $cells[1] );
		}

		$item  = $cells[0];
		$size  = '' !== $cells[1] ? $cells[1] : '―';
		$price = implode( ' | ', array_slice( $cells, 2 ) ); // 料金に縦棒が入っていてもそのまま

		if ( '' === $item || '' === $price ) {
			continue;
		}
		$rows[] = array( $item, $size, $price );
	}

	return $rows;
}

/**
 * 表の行を入力欄用のテキストに戻す。
 *
 * @param array $rows 行.
 * @return string
 */
function naniwa_price_to_text( $rows ) {
	$lines = array();
	foreach ( (array) $rows as $row ) {
		$lines[] = implode( ' | ', $row );
	}
	return implode( "\n", $lines );
}

/**
 * 表示に使う料金表（保存済みがあればそれ、無ければ初期値）。
 *
 * @return array<string, array<int, array>> 見出し => 行
 */
function naniwa_price_tables() {
	static $tables = null;
	if ( null !== $tables ) {
		return $tables;
	}

	$tables = function_exists( 'naniwa_price_default_tables' ) ? naniwa_price_default_tables() : array();

	$page_id = naniwa_page_id( 'disused' );
	$saved   = $page_id ? get_post_meta( $page_id, NANIWA_PRICE_META, true ) : array();

	if ( is_array( $saved ) ) {
		foreach ( $saved as $caption => $text ) {
			if ( ! isset( $tables[ $caption ] ) ) {
				continue; // テンプレートに無い表は使わない
			}
			$rows = naniwa_price_parse( $text );
			if ( $rows ) {
				$tables[ $caption ] = $rows;
			}
		}
	}

	return $tables;
}

/**
 * 料金表の行（tbody の中身）を出力する。品目が続く行はまとめる。
 *
 * @param string $caption 表の見出し.
 */
function naniwa_price_rows( $caption ) {
	$tables = naniwa_price_tables();
	$rows   = isset( $tables[ $caption ] ) ? $tables[ $caption ] : array();
	$count  = count( $rows );

	for ( $i = 0; $i < $count; $i++ ) {
		list( $item, $size, $price ) = $rows[ $i ];

		echo '<tr>';

		// 同じ品目が続く最初の行にだけ品目を出し、rowspan でまとめる。
		if ( 0 === $i || $rows[ $i - 1 ][0] !== $item ) {
			$span = 1;
			while ( $i + $span < $count && $rows[ $i + $span ][0] === $item ) {
				$span++;
			}
			printf( '<th rowspan="%d">%s</th>', (int) $span, esc_html( $item ) );
		}

		printf( '<td class="name">%s</td><td>%s</td>', esc_html( $size ), esc_html( $price ) );
		echo "</tr>\n";
	}
}

/**
 * 不用品ページの編集画面に「料金表」の入力欄を出す。
 *
 * @param string  $post_type 投稿タイプ.
 * @param WP_Post $post      投稿.
 */
function naniwa_price_add_meta_box( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post || (int) $post->ID !== (int) naniwa_page_id( 'disused' ) ) {
		return;
	}

	add_meta_box(
		'naniwa-price-tables',
		'料金表（不用品処分料金）',
		'naniwa_price_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'naniwa_price_add_meta_box', 10, 2 );

/**
 * 料金表の入力欄を描画する。
 *
 * @param WP_Post $post 投稿.
 */
function naniwa_price_meta_box( $post ) {
	wp_nonce_field( 'naniwa_price_tables', 'naniwa_price_nonce' );

	$tables = naniwa_price_tables();
	?>
	<p>1行に1品目ずつ、<strong>品目 | サイズ・種別 | 処分料金</strong> の形で入力します。</p>
	<ul style="list-style:disc;margin-left:1.5em">
		<li>区切りは縦棒 <code>|</code>（全角の <code>｜</code> でも可）。前後の空白は自由です</li>
		<li>同じ品目を続けて書くと、表では品目の欄が1つにまとまります</li>
		<li>サイズ・種別が無いときは <code>―</code>、または <code>品目 | 料金</code> の2つだけでも構いません</li>
		<li>行を増やす・減らす・並べ替えるのも自由です。空にして保存すると最初の内容に戻ります</li>
	</ul>
	<p style="color:#777">例：<code>冷蔵庫 | 業務用 | 30,000円（応相談）</code></p>
	<?php
	foreach ( $tables as $caption => $rows ) {
		$id = 'naniwa-price-' . md5( $caption );
		printf(
			'<p style="margin:18px 0 4px"><label for="%1$s"><strong>%2$s</strong></label></p>'
			. '<textarea id="%1$s" name="naniwa_price[%3$s]" rows="%4$d" style="width:100%%;font-family:monospace">%5$s</textarea>',
			esc_attr( $id ),
			esc_html( $caption ),
			esc_attr( $caption ),
			max( 4, count( $rows ) + 2 ),
			esc_textarea( naniwa_price_to_text( $rows ) )
		);
	}
}

/**
 * 料金表を保存する。初期値と同じ表は保存しない（テーマ更新時に初期値が直れば追従させるため）。
 *
 * @param int $post_id 投稿ID.
 */
function naniwa_price_save( $post_id ) {
	if ( ! isset( $_POST['naniwa_price_nonce'] ) ||
		! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['naniwa_price_nonce'] ) ), 'naniwa_price_tables' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) || (int) $post_id !== (int) naniwa_page_id( 'disused' ) ) {
		return;
	}

	$posted   = isset( $_POST['naniwa_price'] ) && is_array( $_POST['naniwa_price'] ) ? wp_unslash( $_POST['naniwa_price'] ) : array();
	$defaults = function_exists( 'naniwa_price_default_tables' ) ? naniwa_price_default_tables() : array();
	$save     = array();

	foreach ( $defaults as $caption => $default_rows ) {
		if ( ! isset( $posted[ $caption ] ) ) {
			continue;
		}
		$rows = naniwa_price_parse( sanitize_textarea_field( $posted[ $caption ] ) );

		// 空、または初期値と同じなら保存しない（＝初期値を使う）
		if ( ! $rows || $rows === $default_rows ) {
			continue;
		}
		$save[ $caption ] = naniwa_price_to_text( $rows );
	}

	if ( $save ) {
		update_post_meta( $post_id, NANIWA_PRICE_META, $save );
	} else {
		delete_post_meta( $post_id, NANIWA_PRICE_META );
	}
}
add_action( 'save_post_page', 'naniwa_price_save' );
