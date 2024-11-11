<?php 

// var_dump($_POST);
if (!isset($_POST['product_id'])) {
    die("Product ID not provided.");
}

$productId = $_POST['product_id'];

$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

if (empty($cart)) {
    header("Location: view_cart.php");
    exit();
}

foreach ($cart as $key => $item) {
    if ($item['product_id'] == $productId) {
        unset($cart[$key]);
        break;
    }
}

$cart = array_values($cart);

setcookie('cart', json_encode($cart), time() + 3600);

header("Location: view_cart.php");
exit();

