import sys
import markdown

# コマンドライン引数からMarkdownファイルのパスを取得
if len(sys.argv) < 2:
    print("Error: No input file provided", file=sys.stderr)
    sys.exit(1)

input_file = sys.argv[1]

# Markdownファイルを読み込む
try:
    with open(input_file, "r", encoding="utf-8") as f:
        markdown_text = f.read()
except Exception as e:
    print(f"Error reading file: {e}", file=sys.stderr)
    sys.exit(1)

# MarkdownをHTMLに変換
html = markdown.markdown(markdown_text)

# HTMLを標準出力に出力
print(html)
