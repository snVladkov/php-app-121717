<?php

require_once('../functions.php');
require_once('../db.php');

$error = '';
foreach ($_POST as $key => $value) {
    if (empty($value)) {
        $error = 'Моля попълнете всички полета!';
        break;
    }
}

if (mb_strlen($error) > 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = $error;
    $_SESSION['flash']['data'] = $_POST;
    header('Location: ../index.php?page=register');
    exit;
} else {
    $names = $_POST['names'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $repeat_password = $_POST['repeat_password'] ?? '';
    $is_admin = intval($_POST['is_admin'] ?? 0);

    // Проверка дали има потребител с такъв email
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $error = 'Възникна грешка при регистрацията!';
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = $error;
        $_SESSION['flash']['data'] = $_POST;
        header('Location: ../index.php?page=register');
        exit;
    }

    if (!in_array($is_admin, [1,2])) {
        $error = 'Грешен тип потребител!';
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = $error;
        $_SESSION['flash']['data'] = $_POST;
        header('Location: ../index.php?page=register');
        exit;
    }

    if ($password != $repeat_password) {
        $error = 'Паролите не съвпадат!';
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = $error;
        $_SESSION['flash']['data'] = $_POST;
        header('Location: ../index.php?page=register');
        exit;
    } else {
        $hash = password_hash($password, PASSWORD_ARGON2I);

        $query = "INSERT INTO users (names, email, `password`, is_admin) VALUES (:names, :email, :hash, :is_admin)";
        $stmt = $pdo->prepare($query);
        $params = [
            ':names' => $names,
            ':email' => $email,
            ':hash' => $hash,
            ':is_admin' => $is_admin
        ];

        if ($stmt->execute($params)) {
            $_SESSION['flash']['message']['type'] = 'success';
            $_SESSION['flash']['message']['text'] = "Успешна регистрация!";
            header('Location: ../index.php?page=login');
            exit;
        } else {
            $error = 'Възникна грешка при регистрацията!';
            $_SESSION['flash']['message']['type'] = 'danger';
            $_SESSION['flash']['message']['text'] = $error;
            $_SESSION['flash']['data'] = $_POST;
            header('Location: ../index.php?page=register');
            exit;
        }
    }
}

?>