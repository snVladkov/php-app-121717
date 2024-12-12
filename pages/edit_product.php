<?php
    // добавяне/редакция на продукт

    $id = intval($_GET['id'] ?? 0);
    $query = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch();

    // debug($product);
?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_edit_product.php" enctype="multipart/form-data">
    <h3 class="text-center">Редактирай продукт</h3>
    <div class="mb-3">
        <label for="title" class="form-label">Заглавие:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo $product['title'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Цена:</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $product['price'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Изображение:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <div class="mb-3">
        <img class="img-fluid" src="uploads/<?php echo $product['image'] ?>" alt="<?php echo $product['title'] ?>">
    </div>
    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
    <button type="submit" class="btn btn-success mx-auto">Редактирай</button>
</form>