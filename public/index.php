<?php
session_start();

// Подключаем БД
require_once '../config/db.php';

// Подключаем обработчики (пока все сразу для простоты)
require_once '../handlers/auth.php';
require_once '../handlers/posts.php';
require_once '../handlers/comments.php';
require_once '../handlers/admin.php';

// Определяем маршрут
$route = $_GET['route'] ?? 'home';

// Простая маршрутизация
switch ($route) {

    // Главная (публичные посты)
    case 'home':
        require '../views/header.php';
        showHome($pdo);
        require '../views/footer.php';
        break;

    // Один пост
    case 'post':
        require '../views/header.php';
        showPost($pdo);
        require '../views/footer.php';
        break;

    // Регистрация
    case 'register':
        require '../views/header.php';
        handleRegister($pdo);
        require '../views/footer.php';
        break;

    // Логин
    case 'login':
        require '../views/header.php';
        handleLogin($pdo);
        require '../views/footer.php';
        break;

    // Выход
    case 'logout':
        logout();
        header("Location: index.php");
        break;

    // Создание поста (только админ)
    case 'create_post':
        require '../views/header.php';
        createPost($pdo);
        require '../views/footer.php';
        break;
	
    case 'add_comment':
        addComment($pdo);
        break;

    // Админка
    case 'admin':
        require '../views/header.php';
        adminPanel($pdo);
        require '../views/footer.php';
        break;
    case 'admin':
        adminPanel($pdo);
    	break;

    case 'delete_user':
    	 deleteUser($pdo);
	 break;

    case 'delete_post':
        deletePost($pdo);
        break;

    case 'create_admin':
        createAdmin($pdo);
        break;

    default:
        echo "404 - Страница не найдена";
        break;
}