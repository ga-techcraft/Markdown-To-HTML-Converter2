<?php
header("Content-Type: application/json");

// Pythonインタプリタとスクリプトのパス
$pythonPath = __DIR__ . "/venv/bin/python3";
$scriptPath = __DIR__. "/markdown_converter.py";  

// **ダウンロードリクエストの処理**
if (isset($_GET["download"]) && isset($_GET["markdown"])) {
  $markdownText = $_GET["markdown"];

  // Markdownデータを一時ファイルに保存
  // sys_get_temp_dir()はシステムの一時ディレクトリのパスを返す。Unix系は/tmp。tempnam()は第一引数のディレクトリに第二引数の接頭語がついたファイル名を生成する。
  $tmpFile = tempnam(sys_get_temp_dir(), "md_") . ".md";
  file_put_contents($tmpFile, $markdownText);

  // PHPのshell_exec()は標準出力のみ取得するため標準エラー出力も取得できるようにするために2(標準エラー出力)を1(標準出力)にリダイレクトさせる。
  $command = escapeshellcmd("$pythonPath $scriptPath " . escapeshellarg($tmpFile) . " 2>&1");
  $output = shell_exec($command);

  // 一時ファイルを削除
  unlink($tmpFile);

  if (!$output) {
      echo json_encode(["error" => "Conversion failed"]);
      exit;
  }

  // ダウンロード用のヘッダを設定
  header('Content-Type: text/html');
  header('Content-Disposition: attachment; filename="converted.html"');
  echo $output;
  exit;
}

// 受信データを取得
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["markdown"])) {
    echo json_encode(["error" => "Markdown text is required"]);
    exit;
}

// Markdownデータを一時ファイルに保存
$tmpFile = tempnam(sys_get_temp_dir(), "md_") . ".md";
file_put_contents($tmpFile, $data["markdown"]);

// Pythonスクリプトを実行し、一時ファイルのパスを渡す
$command = escapeshellcmd("$pythonPath $scriptPath " . escapeshellarg($tmpFile) . " 2>&1");
$output = shell_exec($command);

// 一時ファイルを削除
unlink($tmpFile);

// 結果を返す
if ($output) {
    echo json_encode(["html" => $output]);
} else {
    echo json_encode(["error" => "Conversion failed"]);
}
exit;
