<?php

require_once('../db.php');

$response = [
    'success' => true,
    'data' => [],
    'error' => ''
];

$product_id = intval($_POST['product_id'] ?? 0);

if ($product_id <= 0) {
    $response['success'] = false;
    $response['error'] = 'Невалиден продукт.';
} else {
    $user_id = $_SESSION['user_id'];

    $query = "DELETE FROM favorite_products_users WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $params = [
        ':user_id' => $user_id,
        ':product_id' => $product_id
    ];

    if (!$stmt->execute($params)) {
        $response['success'] = false;
        $response['error'] = 'Грешка при премахване от любими.';
    }
}

echo json_encode($response);
exit;

?>