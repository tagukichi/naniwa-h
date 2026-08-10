#!/usr/bin/env python3
"""静的サイトビルダー

src/pages/*.html（本文のみ）に共通のヘッダー・フッターを差し込んで
static/*.html を生成する。

各ページ先頭の HTML コメントでメタ情報を指定する:

    <!--
    title: ページタイトル
    description: メタディスクリプション
    -->
"""
import re
import pathlib

ROOT = pathlib.Path(__file__).resolve().parent.parent
SRC = ROOT / "src"
OUT = ROOT / "static"

SHELL = """<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{title}</title>
<meta name="description" content="{description}">
<link rel="stylesheet" href="css/style.css">
</head>
<body{body_attr}>

{header}
<main>
{body}
</main>
{footer}
<script src="js/main.js"></script>
</body>
</html>
"""


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


def build():
    header = (SRC / "partials" / "header.html").read_text(encoding="utf-8")
    footer = (SRC / "partials" / "footer.html").read_text(encoding="utf-8")

    pages = sorted((SRC / "pages").glob("*.html"))
    for page in pages:
        meta, body = parse_meta(page.read_text(encoding="utf-8"))
        body_class = meta.get("body_class", "")
        html = SHELL.format(
            title=meta.get("title", "なにわ引越センター"),
            description=meta.get("description", ""),
            body_attr=f' class="{body_class}"' if body_class else "",
            header=header,
            body=body.rstrip(),
            footer=footer,
        )
        (OUT / page.name).write_text(html, encoding="utf-8")
        print(f"  built  static/{page.name}")

    print(f"\n{len(pages)} pages built.")


if __name__ == "__main__":
    build()
