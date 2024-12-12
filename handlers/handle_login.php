<?php

require_once('../functions.php');
require_once('../db.php');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$login_error = false;

if (empty($email) || empty($password)) {
    $login_error = true;
} else {
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        $login_error = true;
    } else {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_name'] = $user['names'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'] == 2;

            setcookie('user_email', $user['email'], time() + 3600, '/', 'localhost', false, true);
        } else {
            $login_error = true;
        }
    }
}

if ($login_error) {
    header('Location: ../index.php?page=login&error');
    exit;
}

if (isset($_SESSION['user_name'])) {
    header('Location: ../index.php');
    exit;
} else {
    header('Location: ../index.php?page=login&error');
    exit;
}