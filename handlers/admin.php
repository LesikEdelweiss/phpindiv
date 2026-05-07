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

function makeAdmin($pdo)
{
    if ($_SESSION['user']['role'] !== 'admin') {
        echo "Доступ запрещён";
        return;
    }

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "ID не указан";
        return;
    }

    $stmt = $pdo->prepare("
        UPDATE users
        SET role = 'admin'
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    echo "<script>
        window.location.href='index.php?route=admin';
    </script>";
}

function makeUser($pdo)
{
    if ($_SESSION['user']['role'] !== 'admin') {
        echo "Доступ запрещён";
        return;
    }

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "ID не указан";
        return;
    }

    $stmt = $pdo->prepare("
        UPDATE users
        SET role = 'user'
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    echo "<script>
        window.location.href='index.php?route=admin';
    </script>";
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
