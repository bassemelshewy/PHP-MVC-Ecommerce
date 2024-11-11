<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/ProductController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $productObj = new \controllers\ProductController();
    $product = $productObj->find($id);

    if (!$product) {
        die('Product not found');
    }

    $product = $productObj->delete($id);

    header("Location: view_products.php");
} else {
    die('Invalid request');
}
