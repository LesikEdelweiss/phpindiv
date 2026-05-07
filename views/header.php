<!DOCTYPE html>
<html>
<head>
    <title>Simple Blog</title>
</head>
<body>

<h2>Simple Blog</h2>

<nav>
    <a href="index.php?route=home">Главная</a>

    <?php if (isset($_SESSION['user'])): ?>
        <a href="index.php?route=create_post">Создать пост</a>

        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <a href="index.php?route=admin">Админка</a>
        <?php endif; ?>

        <a href="index.php?route=logout">Выйти</a>
    <?php else: ?>
        <a href="index.php?route=login">Вход</a>
        <a href="index.php?route=register">Регистрация</a>
    <?php endif; ?>
</nav>

<hr>