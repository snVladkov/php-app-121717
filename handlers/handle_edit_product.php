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
$id = intval($_POST['id'] ?? 0);

if (mb_strlen($title) <= 0 || mb_strlen($price) <= 0 || $id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля попълнете всички полета!";

    header('Location: ../index.php?page=edit_product&id=' . $id);
    exit;
}

$img_uploaded = false;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $new_file_name = time() . '_' . $_FILES['image']['name'];
    $upload_dir = '../uploads/';

    // проверяваме дали директорията съществува
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_file_name)) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Възникна грешка при качването на снимката!";

        header('Location: ../index.php?page=edit_product&id=' . $id);
        exit;
    } else {
        $img_uploaded = true;
    }
}

$query = "";
if ($img_uploaded) {
    $query = "
        UPDATE products
        SET title = :title, price = :price, image = :image
        WHERE id = :id
    ";
} else {
    $query = "
        UPDATE products
        SET title = :title, price = :price
        WHERE id = :id
    ";
}

$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':id' => $id
];
if ($img_uploaded) {
    $params[':image'] = $new_file_name;
}

if ($stmt->execute($params)) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Продуктът беше редактиран успешно!";
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Възникна грешка при редакцията на продукта!";
}

header('Location: ../index.php?page=edit_product&id=' . $id);
exit;

?>