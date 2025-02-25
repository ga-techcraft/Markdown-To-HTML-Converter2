<?php
header("Content-Type: application/json");

// **ダウンロードリクエストの処理**
if (isset($_GET["download"]) && isset($_GET["markdown"])) {
  $markdownText = $_GET["markdown"];

  // Markdownデータを一時ファイルに保存
  $tmpFile = tempnam(sys_get_temp_dir(), "md_") . ".md";
  file_put_contents($tmpFile, $markdownText);

  // Pythonスクリプトの実行
  $pythonPath = "python3";  // `which python3` で確認
  $scriptPath = __DIR__ . "/markdown_converter.py"; // `convert.php` と同じフォルダにある

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

// Pythonスクリプトの実行パスを指定
$pythonPath = "python3";  // `which python3` で確認
$scriptPath = "markdown_converter.py";  // `convert.php` と同じフォルダなら `__DIR__ . "/markdown_converter.py"`
// $pythonPath = "/usr/bin/python3";  // `which python3` で確認
// $scriptPath = "/var/www/html/markdown_converter.py";  // `convert.php` と同じフォルダなら `__DIR__ . "/markdown_converter.py"`

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
