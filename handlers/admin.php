<?php

// ==========================
// ПАНЕЛЬ АДМИНА (ОБЗОР)
// ==========================
function adminPanel($pdo)
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo "Нет доступа";
        return;
    }

    // пользователи
    $users = $pdo->query("SELECT id, username, email, role, created_at FROM users")->fetchAll();

    // посты
    $posts = $pdo->query("
        SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.author_id = users.id
        ORDER BY posts.created_at DESC
    ")->fetchAll();

    require '../views/admin.php';
}


// ==========================
// УДАЛЕНИЕ ПОЛЬЗОВАТЕЛЯ
// ==========================
function deleteUser($pdo)
{
    if ($_SESSION['user']['role'] !== 'admin') {
        echo "Нет доступа";
        return;
    }

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "Ошибка";
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?route=admin");
    exit;
}


// ==========================
// УДАЛЕНИЕ ПОСТА
// ==========================
function deletePost($pdo)
{
    if ($_SESSION['user']['role'] !== 'admin') {
        echo "Нет доступа";
        return;
    }

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "Ошибка";
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?route=admin");
    exit;
}


// ==========================
// СОЗДАНИЕ АДМИНА (ДОП. ФУНКЦИЯ)
// ==========================
function createAdmin($pdo)
{
    if ($_SESSION['user']['role'] !== 'admin') {
        echo "Нет доступа";
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!$username || !$email || !$password) {
            echo "Заполните все поля";
            return;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password_hash, role)
            VALUES (?, ?, ?, 'admin')
        ");

        $stmt->execute([$username, $email, $hash]);

        echo "Админ создан";
    }
}