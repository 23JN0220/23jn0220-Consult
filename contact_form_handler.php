<?php
// contact_form_handler.php

// エラーメッセージ表示用
error_reporting(E_ALL);
ini_set('display_errors', 1);

// POSTリクエストがある場合のみ処理を実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力データを取得
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : '';

    // 必須項目チェック
    if (empty($name) || empty($email) || empty($message)) {
        echo "全ての項目を入力してください。";
        exit;
    }

    // CSVファイルのパス
    $csvFile = 'contact_messages.csv';

    // CSVファイルに書き込むデータ
    $data = [
        date('Y-m-d H:i:s'), // タイムスタンプ
        $name,
        $email,
        $message
    ];

    // CSVファイルに書き込み
    try {
        $file = fopen($csvFile, 'a');
        if ($file === false) {
            throw new Exception('CSVファイルを開けませんでした。');
        }
        fputcsv($file, $data);
        fclose($file);
        echo "お問い合わせ内容が送信されました。";
    } catch (Exception $e) {
        echo "エラー: " . $e->getMessage();
    }
} else {
    echo "不正なリクエストです。";
}
?>
