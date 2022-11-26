<?php

require_once __DIR__ . '/../db.php';

$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$age = (int)$_POST['age'];

if (!$firstName || !$lastName || !$age) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Все поля обязательны для заполнения'
    ]);
    http_response_code(400);
    return;
}

if ($age < 1 || $age > 120) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Некорректный возраст'
    ]);
    http_response_code(400);
    return;
}

try {
    $sql = "INSERT INTO users (firstName, lastName, age) VALUES (?,?,?)";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $age]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Данные сохранены'
    ]);

} catch (Exception $exception) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка сохранения в БД',
    ]);
}