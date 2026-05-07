<?php

// ==========================
// ДОБАВЛЕНИЕ КОММЕНТАРИЯ
// ==========================
function addComment($pdo)
{
    if (!isset($_SESSION['user'])) {
        echo "Требуется авторизация";
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $postId = $_POST['post_id'] ?? null;
        $content = trim($_POST['content']);

        if (!$postId || !$content) {
            echo "Комментарий не может быть пустым";
            return;
        }

        // защита от слишком длинного текста (простая валидация)
        if (strlen($content) > 1000) {
            echo "Комментарий слишком длинный";
            return;
        }

        $stmt = $pdo->prepare("
            INSERT INTO comments (post_id, user_id, content)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $postId,
            $_SESSION['user']['id'],
            $content
        ]);

        // возврат обратно на пост
        header("Location: index.php?route=post&id=" . $postId);
        exit;
    }
}


// ==========================
// УДАЛЕНИЕ КОММЕНТАРИЯ (ADMIN)
// ==========================
function deleteComment($pdo)
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        echo "Нет доступа";
        return;
    }

    $id = $_GET['id'] ?? null;
    $postId = $_GET['post_id'] ?? null;

    if (!$id || !$postId) {
        echo "Ошибка";
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?route=post&id=" . $postId);
    exit;
}