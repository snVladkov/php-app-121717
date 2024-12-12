<?php

    // страница продукти
    $products = [];


    // заявка към базата данни
    $query = "SELECT * FROM products WHERE title LIKE :search";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':search' => "%$search%"]);

    while ($row = $stmt->fetch()) {
        $fav_query = "SELECT id FROM favorite_products_users WHERE user_id = :user_id AND product_id = :product_id";
        $fav_stmt = $pdo->prepare($fav_query);
        $fav_params = [
            ':user_id' => $_SESSION['user_id'] ?? 0,
            ':product_id' => $row['id']
        ];
        $fav_stmt->execute($fav_params);
        $row['is_favorite'] = $fav_stmt->fetch() ? '1' : '0';

        $products[] = $row;
    }

?>

<div class="row">
    <form class="mb-4" method="GET">
        <div class="input-group">
            <input type="hidden" name="page" value="products">
            <input type="text" class="form-control" placeholder="Търси продукт" name="search" value="<?php echo $search ?>">
            <button class="btn btn-primary" type="submit">Търсене</button>
        </div>
    </form>
</div>
<div class="row">
    <?php
        if (isset($_COOKIE['last_search'])) {
            echo '<h5>Последно търсене: ' . $_COOKIE['last_search'] . '</h5>';
        }
    ?>
</div>
<div class="d-flex flex-wrap justify-content-between">

    <?php

        if (count($products) === 0) {
            echo '<h1>Няма намерени продукти</h1>';
        } else {
            foreach ($products as $product) {
                $fav_btn = $edit_delete = '';
                if (isset($_SESSION['user_name'])) {
                    if ($product['is_favorite'] == '1') {
                        $fav_btn = '
                            <div class="card-footer text-center">
                                <button type="button" class="btn btn-sm btn-danger remove-product" data-product="' . $product['id'] . '">Премахни от любими</button>
                            </div>
                        ';
                    } else {
                        $fav_btn = '
                            <div class="card-footer text-center">
                                <button type="button" class="btn btn-sm btn-primary add-product" data-product="' . $product['id'] . '">Добави в любими</button>
                            </div>
                        ';
                    }
                }

                if (is_admin()) {
                    $edit_delete = '
                        <div class="card-header d-flex flex-row justify-content-between">
                            <a class="btn btn-sm btn-warning" href="?page=edit_product&id=' . $product['id'] . '">Редактирай</a>
                            <form method="POST" action="./handlers/handle_delete_product.php">
                                <input type="hidden" name="id" value="' . $product['id'] . '">
                                <button type="submit" class="btn btn-sm btn-danger">Изтрий</button>
                            </form>
                        </div>
                    ';
                }

                echo '
                    <div class="card mb-4" style="width: 18rem;">
                        ' . $edit_delete . '
                        <img src="uploads/' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($product['title']) . '</h5>
                            <p class="card-text">' . htmlspecialchars($product['price']) . '</p>
                        </div>
                        ' . $fav_btn . '
                    </div>
                ';
            }
        }

    ?>
</div>