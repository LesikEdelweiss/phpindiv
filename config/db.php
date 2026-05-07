<?php
// config/db.php

$host = 'db';
$dbname = 'blog';
$username = 'bloguser';
$password = 'blogpass';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Включаем режим ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получение данных в виде ассоциативного массива
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}