<?php

// ==========================
// ПУБЛИЧНАЯ СТРАНИЦА (СПИСОК ПОСТОВ)
// ==========================
function showHome($pdo)
{
    $stmt = $pdo->query("
        SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.author_id = users.id 
        ORDER BY posts.created_at DESC
    ");

    $posts = $stmt->fetchAll();

    require '../views/home.php';
}


// ==========================
// ОДИН ПОСТ + КОММЕНТАРИИ
// ==========================
function showPost($pdo)
{
    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "Пост не найден";
        return;
    }

    // сам пост
    $stmt = $pdo->prepare("
        SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.author_id = users.id 
        WHERE posts.id = ?
    ");
    $stmt->execute([$id]);
    $post = $stmt->fetch();

    if (!$post) {
        echo "Пост не найден";
        return;
    }

    // комментарии
    $stmt = $pdo->prepare("
        SELECT comments.*, users.username
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE post_id = ?
        ORDER BY comments.created_at ASC
    ");
    $stmt->execute([$id]);
    $comments = $stmt->fetchAll();

    require '../views/post.php';
}


// ==========================
// СОЗДАНИЕ ПОСТА (ТОЛЬКО ADMIN)
// ==========================
function createPost($pdo)
{
    if (!isset($_SESSION['user'])) {
        echo "Требуется авторизация";
        return;
    }

    if ($_SESSION['user']['role'] !== 'admin') {
        echo "Нет доступа";
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $title = trim($_POST['title']);
        $content = trim($_POST['content']);

        if (!$title || !$content) {
            echo "Заполните все поля";
            return;
        }

        $stmt = $pdo->prepare("
            INSERT INTO posts (title, content_markdown, author_id)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $title,
            $content,
            $_SESSION['user']['id']
        ]);

        echo "Пост создан";
    }

    require '../views/create_post.php';
}


// ==========================
// ПОИСК ПОСТОВ (для формы поиска)
// ==========================
function searchPosts($pdo)
{
    $q = $_GET['q'] ?? '';

    $stmt = $pdo->prepare("
        SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.author_id = users.id
        WHERE posts.title LIKE ?
        ORDER BY posts.created_at DESC
    ");

    $stmt->execute(["%$q%"]);
    $posts = $stmt->fetchAll();

    require '../views/home.php';
}