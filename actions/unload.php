<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db.php';

$googleAccountKeyFilePath = __DIR__ . '/../spread-access.json';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);

try {
    $client = new Google_Client();

    $client->useApplicationDefaultCredentials();
    $client->addScope('https://www.googleapis.com/auth/spreadsheets');

    $service = new Google_Service_Sheets($client);

    $spreadsheetId = '1ct3ViV3QqX1iMZqtc-s-iTGBquN4Oi373JjLXdKO5Zs';

    $users = $pdo->query("SELECT * FROM users WHERE age > 18")->fetchAll(PDO::FETCH_NUM);

    $body = new Google_Service_Sheets_ValueRange(['values' => $users]);
    $options = array( 'valueInputOption' => 'RAW' );

    $service->spreadsheets_values->update($spreadsheetId, 'Лист1', $body, $options );

    echo json_encode([
        'status' => 'success',
        'message' => 'Данные выгружены'
    ]);
} catch (Exception $exception) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'При выгрузке произошла ошибка'
    ]);
}

