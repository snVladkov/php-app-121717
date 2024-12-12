<?php

require_once('../functions.php');
require_once('../db.php');

if (!is_admin()) {
    $_SESSION['flash']['message']['type'] = 'warning';
    $_SESSION['flash']['message']['text'] = "Нямате достъп до тази страница!";
    header('Location: ../index.php?page=home');
    exit;
}

$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';

if (mb_strlen($title) <= 0 || mb_strlen($price) <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля попълнете всички полета!";

    header('Location: ../index.php?page=add_product');
    exit;
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля качете снимка!";

    header('Location: ../index.php?page=add_product');
    exit;
}

$new_file_name = time() . '_' . $_FILES['image']['name'];
$upload_dir = '../uploads/';

// проверяваме дали директорията съществува
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_file_name)) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Възникна грешка при качването на снимката!";

    header('Location: ../index.php?page=add_product');
    exit;
}

$query = "INSERT INTO products (title, price, image) VALUES (:title, :price, :image)";
$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':image' => $new_file_name
];

if ($stmt->execute($params)) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Продуктът беше добавен успешно!";

    header('Location: ../index.php?page=products');
    exit;
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Възникна грешка при добавянето на продукта!";

    header('Location: ../index.php?page=add_product');
    exit;
}

?>