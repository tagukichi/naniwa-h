#!/usr/bin/env python3
"""WordPress テーマビルダー

静的サイト（src/pages, src/partials, static/assets）を元に
WordPress のクラシックテーマ一式を wp-theme/naniwa-express/ に生成し、
配布用の ZIP まで作成する。

  python3 tools/build_theme.py

固定ページのテンプレートは page-{slug}.php として出力するため、
WordPress 側で同じスラッグの固定ページを作れば自動的に割り当たる。
"""
import html
import pathlib
import re
import shutil
import zipfile

ROOT = pathlib.Path(__file__).resolve().parent.parent
SRC = ROOT / "src"
STATIC = ROOT / "static"
THEME_SRC = ROOT / "tools" / "theme"
OUT = ROOT / "wp-theme" / "naniwa-express"
ZIP_PATH = ROOT / "wp-theme" / "naniwa-express.zip"

# 静的ファイル名 → 固定ページのスラッグ
PAGE_SLUGS = {
    "single": "single",
    "family": "family",
    "couple": "couple",
    "now": "now",
    "office": "office",
    "disused": "disused",
    "flow": "flow",
    "packing": "packing",
    "others": "others",
    "faq": "faq",
    "checklist": "checklist",
    "company": "company",
    "kiyaku": "kiyaku",
    "recruit": "recruit",
    "estimate-step1": "estimate-step1",
    "estimate-step2": "estimate-step2",
    "estimate-step3": "estimate-step3",
    "estimate-step4": "estimate-step4",
    "estimate-step5": "estimate-step5",
    "estimate-step6-1": "estimate-step6-1",
    "estimate-step6-2": "estimate-step6-2",
    "estimate-step6-3": "estimate-step6-3",
    "estimate-step7": "estimate-step7",
    "estimate-confirm": "estimate-confirm",
    "estimate-thanks": "estimate-thanks",
}

# 静的サイトにしか無い（テーマ側では動的テンプレートが担当する）ページ
DYNAMIC_PAGES = {"index", "blog", "blog-single", "voice", "voice-single"}

# リンク先の特別扱い
SPECIAL_LINKS = {
    "index.html": "<?php echo esc_url( home_url( '/' ) ); ?>",
    "voice.html": "<?php echo esc_url( get_post_type_archive_link( 'voice' ) ); ?>",
    "voice-single.html": "<?php echo esc_url( get_post_type_archive_link( 'voice' ) ); ?>",
    "blog.html": "<?php echo esc_url( naniwa_blog_url() ); ?>",
    "blog-single.html": "<?php echo esc_url( naniwa_blog_url() ); ?>",
}


def convert_links(text):
    """静的サイトの相対リンク・アセットパスを WordPress 用に書き換える。"""

    def asset(match):
        attr, path = match.group(1), match.group(2)
        return f"{attr}=\"<?php echo esc_url( get_theme_file_uri( '/assets/{path}' ) ); ?>\""

    text = re.sub(r'(src|href)="assets/([^"]+)"', asset, text)

    def link(match):
        attr, target = match.group(1), match.group(2)
        if target in SPECIAL_LINKS:
            return f'{attr}="{SPECIAL_LINKS[target]}"'
        slug = target[:-5]
        return f"{attr}=\"<?php echo esc_url( naniwa_page_url( '{slug}' ) ); ?>\""

    text = re.sub(r'(href|action)="([a-z0-9\-]+\.html)"', link, text)
    return text


def page_url(slug):
    """固定ページのURLを出力する PHP 断片を返す。"""
    return f"<?php echo esc_url( naniwa_page_url( '{slug}' ) ); ?>"


def parse_meta(text):
    """先頭コメントからメタ情報を取り出し、本文と分離して返す。"""
    meta = {}
    m = re.match(r"\s*<!--(.*?)-->\s*", text, re.S)
    if m:
        for line in m.group(1).strip().splitlines():
            if ":" in line:
                k, v = line.split(":", 1)
                meta[k.strip()] = v.strip()
        text = text[m.end():]
    return meta, text


def build_header():
    partial = convert_links((SRC / "partials" / "header.html").read_text(encoding="utf-8"))
    return f"""<?php
/**
 * 共通ヘッダー
 *
 * @package naniwa
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

{partial}
<main>
"""


def build_footer():
    partial = convert_links((SRC / "partials" / "footer.html").read_text(encoding="utf-8"))
    return f"""<?php
/**
 * 共通フッター
 *
 * @package naniwa
 */

?>
</main>
{partial}
<?php wp_footer(); ?>
</body>
</html>
"""


def php_header(comment, template_name=None):
    name = f" * Template Name: {template_name}\n *\n" if template_name else ""
    return f"""<?php
/**
 * {comment}
 *
{name} * @package naniwa
 */

get_header();
?>
"""


def build_page_templates():
    """固定ページのテンプレートを生成する。"""
    written = []
    for page in sorted((SRC / "pages").glob("*.html")):
        stem = page.stem
        if stem in DYNAMIC_PAGES:
            continue
        slug = PAGE_SLUGS.get(stem)
        if slug is None:
            print(f"  skip   {stem}.html（スラッグ未定義）")
            continue

        meta, body = parse_meta(page.read_text(encoding="utf-8"))
        title = meta.get("title", "").split("｜")[0]
        body = convert_links(body).rstrip()

        if stem == "recruit":
            body = inject_recruit_form(body)
        elif stem == "estimate-confirm":
            body = build_confirm_body(body)
        elif stem.startswith("estimate-step"):
            body = estimate_form(body, stem)

        content = php_header(f"固定ページ：{title}（スラッグ: {slug}）", title)
        content += "\n" + body + "\n\n<?php\nget_footer();\n"
        (OUT / f"page-{slug}.php").write_text(content, encoding="utf-8")
        written.append((slug, title))
    return written


def inject_recruit_form(body):
    """求人ページのダミーフォームを Contact Form 7 に差し替えられるようにする。"""
    start = body.find('<form class="form-card"')
    if start == -1:
        return body
    end = body.find("</form>", start)
    if end == -1:
        return body
    end += len("</form>")
    static_form = body[start:end]

    replacement = (
        "<?php\n"
        "\t\t$naniwa_form = get_theme_mod( 'naniwa_recruit_form', '' );\n"
        "\t\tif ( $naniwa_form ) :\n"
        "\t\t\t// カスタマイザーで設定された Contact Form 7 等のショートコードを出力する。\n"
        "\t\t\techo '<div class=\"form-card form-card-plugin\">' . do_shortcode( $naniwa_form ) . '</div>';\n"
        "\t\telse :\n"
        "\t\t\t?>\n"
        "\t\t\t" + static_form.replace("\n", "\n\t\t\t") + "\n"
        "\t\t\t<?php\n"
        "\t\tendif;\n"
        "\t\t?>"
    )
    return body[:start] + replacement + body[end:]



# ---------------------------------------------------------------------------
# web見積フォーム
# ---------------------------------------------------------------------------

ESTIMATE_STEPS = [
    ("estimate-step1", "お客様情報"),
    ("estimate-step2", "引越プラン"),
    ("estimate-step3", "現在のお住まい"),
    ("estimate-step4", "引越先"),
    ("estimate-step5", "道路状況"),
    ("estimate-step6-1", "お荷物"),
    ("estimate-step6-2", "お荷物（2ページ目）"),
    ("estimate-step6-3", "お荷物（3ページ目）"),
    ("estimate-step7", "オプション"),
]


def strip_tags(fragment):
    text = html.unescape(re.sub(r"<[^>]+>", " ", fragment))
    return re.sub(r"\s+", " ", text).strip()


def extract_fields(stem):
    """1ステップ分の (name, ラベル) を本文の並び順で取り出す。"""
    source = (SRC / "pages" / f"{stem}.html").read_text(encoding="utf-8")
    fields = []

    for chunk in source.split('<div class="form-row">')[1:]:
        chunk = chunk.split("</form>")[0]

        main = re.search(r'class="label"[^>]*>(.*?)(?=<div|</div)', chunk, re.S)
        if not main:
            continue
        main_label = re.sub(r"\s*(必須|任意)$", "", strip_tags(main.group(1))).strip()

        # 1つの行に複数の入力欄がある場合だけ、直前の小見出しを添えて区別する。
        row_fields = []
        sub_label = ""
        for m in re.finditer(
            r'<p class="h-sub"[^>]*>(?P<sub>.*?)</p>'
            r'|<label for="[^"]*"[^>]*>(?P<sub2>[^<]*)</label>'
            r'|name="(?P<name>[^"\[]+)(\[\])?"',
            chunk,
            re.S,
        ):
            if m.group("sub") is not None:
                sub_label = strip_tags(m.group("sub"))
            elif m.group("sub2") is not None:
                sub_label = strip_tags(m.group("sub2"))
            else:
                name = m.group("name")
                if any(name == f[0] for f in fields) or any(name == f[0] for f in row_fields):
                    continue
                row_fields.append((name, sub_label))
                sub_label = ""

        for name, sub in row_fields:
            if len(row_fields) > 1 and sub:
                fields.append((name, f"{main_label}（{sub}）"))
            else:
                fields.append((name, main_label))

    return fields


def build_estimate_fields_php():
    """ステップとフィールドの対応表を PHP として書き出す。"""
    blocks = []
    for stem, title in ESTIMATE_STEPS:
        rows = "".join(
            f"\t\t\t\t\t'{name}' => '{label}',\n" for name, label in extract_fields(stem)
        )
        blocks.append(
            f"\t\t'{stem}' => array(\n"
            f"\t\t\t'title'  => '{title}',\n"
            f"\t\t\t'fields' => array(\n{rows}\t\t\t),\n"
            f"\t\t),\n"
        )

    php = (
        "<?php\n"
        "/**\n"
        " * web見積フォームのステップと入力項目の対応表\n"
        " *\n"
        " * このファイルは tools/build_theme.py が静的HTMLから自動生成する。\n"
        " * 直接編集せず、src/pages/estimate-*.html を直してから再生成すること。\n"
        " *\n"
        " * @package naniwa\n"
        " */\n\n"
        "defined( 'ABSPATH' ) || exit;\n\n"
        "/**\n"
        " * ステップ定義を返す。\n"
        " *\n"
        " * @return array<string, array{title:string, fields:array<string, string>}>\n"
        " */\n"
        "function naniwa_estimate_steps() {\n"
        "\treturn array(\n" + "".join(blocks) + "\t);\n"
        "}\n"
    )
    (OUT / "inc" / "estimate-fields.php").write_text(php, encoding="utf-8")


def prefill(body):
    """入力欄に、引き継いだ値を復元する PHP を差し込む。"""

    # 荷物の個数
    body = re.sub(
        r'(<input type="number" name="item\[(?P<label>[^\]]+)\]")\s+value="0"',
        lambda m: f'{m.group(1)} value="<?php echo esc_attr( naniwa_estimate_item( \'{m.group("label")}\' ) ); ?>"',
        body,
    )

    # テキスト系。既存の value 属性があれば置き換える。
    def text_input(m):
        tag = m.group(0)
        name = m.group("name")
        default = "0" if 'type="number"' in tag else ""
        php = f'value="<?php echo esc_attr( naniwa_estimate_value( \'{name}\', \'{default}\' ) ); ?>"'
        if re.search(r'\svalue="[^"]*"', tag):
            return re.sub(r'\svalue="[^"]*"', " " + php, tag, count=1)
        return tag[:-1].rstrip() + " " + php + ">"

    body = re.sub(
        r'<input type="(?:text|tel|email|number|date)"[^>]*\sname="(?P<name>[^"\[]+)"[^>]*>',
        text_input,
        body,
    )

    # ラジオ
    body = re.sub(
        r'(<input type="radio" name="(?P<name>[^"]+)" value="(?P<value>[^"]*)")',
        lambda m: f'{m.group(1)}<?php checked( naniwa_estimate_value( \'{m.group("name")}\' ), \'{m.group("value")}\' ); ?>',
        body,
    )

    # チェックボックス
    body = re.sub(
        r'(<input type="checkbox" name="(?P<name>[^"\[]+)(?:\[\])?" value="(?P<value>[^"]*)")',
        lambda m: f'{m.group(1)}<?php checked( in_array( \'{m.group("value")}\', naniwa_estimate_raw( \'{m.group("name")}\' ), true ) ); ?>',
        body,
    )

    # セレクト
    def select_block(m):
        name = m.group("name")
        inner = re.sub(
            r'(<option value="(?P<value>[^"]*)")',
            lambda o: f'{o.group(1)}<?php selected( naniwa_estimate_value( \'{name}\' ), \'{o.group("value")}\' ); ?>',
            m.group("inner"),
        )
        # value 属性が無い <option>北海道</option> はテキストがそのまま値になる。
        inner = re.sub(
            r'<option>(?P<text>[^<]*)</option>',
            lambda o: f'<option<?php selected( naniwa_estimate_value( \'{name}\' ), \'{o.group("text")}\' ); ?>>{o.group("text")}</option>',
            inner,
        )
        return m.group("open") + inner + "</select>"

    body = re.sub(
        r'(?P<open><select[^>]*\sname="(?P<name>[^"\[]+)"[^>]*>)(?P<inner>.*?)</select>',
        select_block,
        body,
        flags=re.S,
    )

    # テキストエリア
    body = re.sub(
        r'(?P<open><textarea[^>]*\sname="(?P<name>[^"\[]+)"[^>]*>)\s*(?P<inner>.*?)</textarea>',
        lambda m: f'{m.group("open")}<?php echo esc_textarea( naniwa_estimate_value( \'{m.group("name")}\' ) ); ?></textarea>',
        body,
        flags=re.S,
    )

    return body


def estimate_form(body, stem):
    """ステップのフォームを POST 化し、値の引き継ぎと送信ボタンを組み込む。"""
    names = sorted({m.group(1) for m in re.finditer(r'name="([^"\[]+)(?:\[[^"]*\])?"', body)})
    exclude = ", ".join(f"'{n}'" for n in names)

    body = body.replace('method="get"', 'method="post"')

    carry = (
        "\n<?php\n"
        "// このステップより前の入力内容を hidden で持ち回る。\n"
        f"naniwa_estimate_carry_over( array( {exclude} ) );\n"
        "?>"
    )
    # action 属性に PHP を埋め込んだ後だと <form> のタグ終端を正規表現で取れないため、
    # hidden は form-inner の先頭に差し込む（input[type=hidden] はレイアウトに影響しない）。
    body = re.sub(r'(<div class="form-inner">)', lambda m: m.group(1) + carry, body, count=1)

    # 「次へ」「戻る」がリンクのままだと入力が送信されないため submit に変える。
    body = re.sub(
        r'<a class="btn btn-back" href="(?P<url>[^"]*)"[^>]*>(?P<text>[^<]*)</a>',
        lambda m: f'<button class="btn btn-back" type="submit" formaction="{m.group("url")}" formnovalidate>{m.group("text")}</button>',
        body,
    )
    body = re.sub(
        r'<a class="btn btn-primary" href="[^"]*"[^>]*>(?P<text>[^<]*)</a>',
        lambda m: f'<button class="btn btn-primary" type="submit">{m.group("text")}</button>',
        body,
    )

    return prefill(body)


def build_confirm_body(body):
    """確認画面を、引き継いだ入力内容から組み立てる形に置き換える。"""
    start = body.find('<form class="form-card"')
    end = body.find("</form>", start)
    if start == -1 or end == -1:
        raise SystemExit("estimate-confirm: form が見つかりません")

    form = (
        '<form class="form-card" method="post" action="'
        + page_url("estimate-confirm")
        + '">\n'
        "<?php\n"
        "wp_nonce_field( 'naniwa_estimate', 'naniwa_estimate_nonce' );\n"
        "// 入力内容をすべて hidden で持ち回ってから送信する。\n"
        "naniwa_estimate_carry_over();\n"
        "?>\n"
        "      <h2>入力内容の確認</h2>\n"
        '      <div class="form-inner">\n'
        '        <p style="margin-bottom:22px;">下記の内容で送信します。修正が必要な場合は、各項目の「修正する」からお戻りください。</p>\n'
        "\n"
        "<?php\n"
        "$naniwa_printed = false;\n"
        "foreach ( naniwa_estimate_steps() as $naniwa_slug => $naniwa_step ) :\n"
        "\t$naniwa_rows = array();\n"
        "\tforeach ( $naniwa_step['fields'] as $naniwa_key => $naniwa_label ) {\n"
        "\t\t$naniwa_val = naniwa_estimate_value( $naniwa_key );\n"
        "\t\tif ( '' !== $naniwa_val && '0' !== $naniwa_val ) {\n"
        "\t\t\t$naniwa_rows[ $naniwa_label ] = $naniwa_val;\n"
        "\t\t}\n"
        "\t}\n"
        "\t// 荷物はステップが3つに分かれているが、確認画面では1つにまとめる。\n"
        "\tif ( 'estimate-step6-1' === $naniwa_slug ) {\n"
        "\t\tforeach ( naniwa_estimate_items() as $naniwa_label => $naniwa_count ) {\n"
        "\t\t\t$naniwa_rows[ $naniwa_label ] = $naniwa_count . '個';\n"
        "\t\t}\n"
        "\t}\n"
        "\tif ( ! $naniwa_rows ) {\n"
        "\t\tcontinue;\n"
        "\t}\n"
        "\t$naniwa_printed = true;\n"
        "\t?>\n"
        '\t\t<h3 class="h-sub"><?php echo esc_html( $naniwa_step[\'title\'] ); ?>\n'
        '\t\t\t<button type="submit" formaction="<?php echo esc_url( naniwa_page_url( $naniwa_slug ) ); ?>" formnovalidate class="confirm-edit">修正する</button>\n'
        "\t\t</h3>\n"
        '\t\t<table class="confirm-table" style="margin-bottom:30px;">\n'
        "\t\t\t<tbody>\n"
        "\t\t\t\t<?php foreach ( $naniwa_rows as $naniwa_label => $naniwa_val ) : ?>\n"
        "\t\t\t\t\t<tr><th><?php echo esc_html( $naniwa_label ); ?></th><td><?php echo esc_html( $naniwa_val ); ?></td></tr>\n"
        "\t\t\t\t<?php endforeach; ?>\n"
        "\t\t\t</tbody>\n"
        "\t\t</table>\n"
        "\t<?php\n"
        "endforeach;\n"
        "\n"
        "if ( ! $naniwa_printed ) :\n"
        "\t?>\n"
        '\t<div class="notice-box">\n'
        "\t\t<p>入力内容が引き継がれていません。お手数ですが\n"
        '\t\t\t<a href="' + page_url("estimate-step1") + '">STEP1</a> からやり直してください。</p>\n'
        "\t</div>\n"
        "\t<?php\n"
        "endif;\n"
        "?>\n"
        "      </div>\n"
        '      <div class="form-actions">\n'
        '        <button class="btn btn-back" type="submit" formaction="' + page_url("estimate-step7") + '" formnovalidate>←　戻る</button>\n'
        '        <button class="btn btn-primary" type="submit" name="naniwa_estimate_submit" value="1">この内容で送信する</button>\n'
        "      </div>\n"
        "    </form>"
    )

    return body[:start] + form + body[end + len("</form>"):]


def build_pages_php(slug_titles):
    """テーマの初期設定画面が使う「必要な固定ページ」一覧を書き出す。"""
    rows = "".join(
        f"\t\t'{slug}' => '{title}',\n" for slug, title in slug_titles
    )
    php = (
        "<?php\n"
        "/**\n"
        " * このテーマが必要とする固定ページの一覧\n"
        " *\n"
        " * tools/build_theme.py が自動生成する。直接編集しないこと。\n"
        " *\n"
        " * @package naniwa\n"
        " */\n\n"
        "defined( 'ABSPATH' ) || exit;\n\n"
        "/**\n"
        " * スラッグ => ページ名。\n"
        " *\n"
        " * @return array<string, string>\n"
        " */\n"
        "function naniwa_required_pages() {\n"
        "\treturn array(\n" + rows + "\t);\n"
        "}\n"
    )
    (OUT / "inc" / "pages.php").write_text(php, encoding="utf-8")


def build_front_page():
    """TOPページ。ブログ・お知らせ・お客様の声はループに差し替える。"""
    meta, body = parse_meta((SRC / "pages" / "index.html").read_text(encoding="utf-8"))
    body = convert_links(body)

    body = replace_inner(body, "voice-grid", VOICE_LOOP)
    body = replace_inner(body, "news-list", NEWS_LOOP)
    body = replace_inner(body, "blog-grid", BLOG_LOOP)

    content = php_header("フロントページ（TOP）")
    content += "\n" + body.rstrip() + "\n\n<?php\nget_footer();\n"
    (OUT / "front-page.php").write_text(content, encoding="utf-8")


def replace_inner(text, class_name, replacement):
    """<div class="X"> ... </div> の中身をまるごと差し替える。"""
    opening = re.search(rf'<(div|ul) class="{class_name}">', text)
    if not opening:
        raise SystemExit(f"front-page: .{class_name} が見つかりません")
    tag = opening.group(1)
    start = opening.end()

    # 同じタグ名のネストを数えながら閉じタグを探す。
    depth = 1
    pos = start
    while depth:
        m = re.search(rf"</?{tag}[\s>]", text[pos:])
        if not m:
            raise SystemExit(f"front-page: .{class_name} の閉じタグが見つかりません")
        pos += m.end()
        depth += -1 if m.group(0).startswith("</") else 1
    end = pos - len(f"</{tag}>") - 1

    return text[:start] + "\n" + replacement + text[end:]


VOICE_LOOP = """\t\t\t<?php
\t\t\t$naniwa_voices = new WP_Query(
\t\t\t\tarray(
\t\t\t\t\t'post_type'           => 'voice',
\t\t\t\t\t'posts_per_page'      => 3,
\t\t\t\t\t'ignore_sticky_posts' => true,
\t\t\t\t)
\t\t\t);
\t\t\twhile ( $naniwa_voices->have_posts() ) :
\t\t\t\t$naniwa_voices->the_post();
\t\t\t\tnaniwa_voice_card( 90 );
\t\t\tendwhile;
\t\t\twp_reset_postdata();
\t\t\t?>
\t\t"""

NEWS_LOOP = """\t\t\t<?php
\t\t\t$naniwa_news = new WP_Query(
\t\t\t\tarray(
\t\t\t\t\t'post_type'           => 'topics',
\t\t\t\t\t'posts_per_page'      => 5,
\t\t\t\t\t'ignore_sticky_posts' => true,
\t\t\t\t)
\t\t\t);
\t\t\twhile ( $naniwa_news->have_posts() ) :
\t\t\t\t$naniwa_news->the_post();
\t\t\t\t?>
\t\t\t\t<li>
\t\t\t\t\t<a href="<?php the_permalink(); ?>">
\t\t\t\t\t\t<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
\t\t\t\t\t\t<?php the_title(); ?>
\t\t\t\t\t</a>
\t\t\t\t</li>
\t\t\t\t<?php
\t\t\tendwhile;
\t\t\twp_reset_postdata();
\t\t\t?>
\t\t"""

BLOG_LOOP = """\t\t\t<?php
\t\t\t$naniwa_posts = new WP_Query(
\t\t\t\tarray(
\t\t\t\t\t'post_type'           => 'post',
\t\t\t\t\t'posts_per_page'      => 4,
\t\t\t\t\t'ignore_sticky_posts' => true,
\t\t\t\t)
\t\t\t);
\t\t\twhile ( $naniwa_posts->have_posts() ) :
\t\t\t\t$naniwa_posts->the_post();
\t\t\t\tnaniwa_blog_card();
\t\t\tendwhile;
\t\t\twp_reset_postdata();
\t\t\t?>
\t\t"""


def copy_assets():
    dest = OUT / "assets"
    if dest.exists():
        shutil.rmtree(dest)
    (dest / "css").mkdir(parents=True)
    (dest / "js").mkdir(parents=True)

    # 静的サイトは css/ と assets/img/ が兄弟だが、テーマでは assets/css/ と
    # assets/img/ が兄弟になる。CSS 内の相対パスを階層のズレに合わせて直す。
    css = (STATIC / "css" / "style.css").read_text(encoding="utf-8")
    css = css.replace('url("../assets/img/', 'url("../img/')
    css = css.replace("url('../assets/img/", "url('../img/")
    css = css.replace("url(../assets/img/", "url(../img/")
    (dest / "css" / "style.css").write_text(css, encoding="utf-8")

    shutil.copy2(STATIC / "js" / "main.js", dest / "js" / "main.js")
    shutil.copytree(STATIC / "assets" / "img", dest / "img")


def copy_theme_src():
    for path in sorted(THEME_SRC.rglob("*")):
        if path.is_dir():
            continue
        rel = path.relative_to(THEME_SRC)
        target = OUT / rel
        target.parent.mkdir(parents=True, exist_ok=True)
        shutil.copy2(path, target)


def make_zip():
    ZIP_PATH.parent.mkdir(parents=True, exist_ok=True)
    if ZIP_PATH.exists():
        ZIP_PATH.unlink()
    with zipfile.ZipFile(ZIP_PATH, "w", zipfile.ZIP_DEFLATED) as zf:
        for path in sorted(OUT.rglob("*")):
            if path.is_file():
                zf.write(path, path.relative_to(OUT.parent))
    return ZIP_PATH.stat().st_size


def build():
    if OUT.exists():
        shutil.rmtree(OUT)
    OUT.mkdir(parents=True)

    copy_theme_src()
    copy_assets()

    (OUT / "header.php").write_text(build_header(), encoding="utf-8")
    (OUT / "footer.php").write_text(build_footer(), encoding="utf-8")

    build_estimate_fields_php()
    build_front_page()
    slugs = build_page_templates()
    build_pages_php(slugs)

    for slug, _title in slugs:
        print(f"  built  page-{slug}.php")
    print(f"  built  front-page.php / header.php / footer.php")

    size = make_zip()
    print(f"\n固定ページテンプレート {len(slugs)} 件")
    print(f"ZIP: {ZIP_PATH.relative_to(ROOT)}（{size / 1024:.0f} KB）")


if __name__ == "__main__":
    build()
