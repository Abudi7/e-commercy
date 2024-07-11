<?php
require '../../../Class/Products.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = new Products();

    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = (float)$_POST['price'];
    $image = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = basename($_FILES['image']['name']);
        $target = "image/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    if (isset($_POST['create'])) {
        $product->create($name, $description, $price, $image);
    } elseif (isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $product->update($id, $name, $description, $price, $image);
    }

    header('Location: index.php');
}
?>
