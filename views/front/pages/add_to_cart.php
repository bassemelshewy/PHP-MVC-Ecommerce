<?php

$productId = $_POST['product_id'];
$quantity = $_POST['quantity'];

$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
$found = false;

foreach ($cart as &$item) {
    if ($item['product_id'] == $productId) {
        $item['quantity'] += $quantity;
        $found = true;
        break;
    }
}

if (!$found) {
    $cart[] = ['product_id' => $productId, 'quantity' => $quantity];
}

setcookie('cart', json_encode($cart), time() + 3600);

header("Location: view_cart.php");
exit();
