<?php

// ==========================
// РЕГИСТРАЦИЯ
// ==========================
function handleRegister($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Простая валидация
        if (!$username || !$email || !$password) {
            echo "Все поля обязательны";
            return;
        }

        // Проверка, существует ли пользователь
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            echo "Пользователь уже существует";
            return;
        }

        // Хеширование пароля
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Создание пользователя
        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password_hash, role)
            VALUES (?, ?, ?, 'user')
        ");

        $stmt->execute([$username, $email, $passwordHash]);

        echo "Регистрация успешна. Теперь войдите.";
    }

    // форма
    require '../views/register.php';
}


// ==========================
// ЛОГИН
// ==========================
function handleLogin($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            echo "Неверный email или пароль";
            return;
        }

        // Сохраняем в сессию
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];

        echo "<script>
                window.location.href = 'index.php?route=home';
              </script>";
        exit;
    }

    require '../views/login.php';
}


// ==========================
// ВЫХОД
// ==========================
function logout()
{
    unset($_SESSION['user']);
    session_destroy();
}


// ==========================
// ПРОВЕРКА АДМИНА
// ==========================
function isAdmin()
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}


// ==========================
// ПРОВЕРКА АВТОРИЗАЦИИ
// ==========================
function isAuth()
{
    return isset($_SESSION['user']);
}