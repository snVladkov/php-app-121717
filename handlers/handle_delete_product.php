<?php

require_once('../functions.php');
require_once('../db.php');

if (!is_admin()) {
    $_SESSION['flash']['message']['type'] = 'warning';
    $_SESSION['flash']['message']['text'] = "Нямате достъп до тази страница!";
    header('Location: ../index.php?page=home');
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Невалиден идентификатор на продукт!";

    header('Location: ../index.php?page=products');
    exit;
}

$query = "DELETE FROM products WHERE id = :id";
$stmt = $pdo->prepare($query);
if ($stmt->execute([':id' => $id])) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Продуктът беше изтрит успешно!";
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Възникна грешка при изтриването на продукта!";
}

header('Location: ../index.php?page=products');
exit;

?>