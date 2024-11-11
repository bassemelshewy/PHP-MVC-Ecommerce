<?php 
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'user') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

$userId = $_SESSION['userId'];

if(empty($cart)){
    die("Your cart is empty");
}

require_once __DIR__ . '/../../../controllers/front/OrderController.php';

$orderController = new \controllers\front\OrderController();

$orderId = $orderController->checkOut($userId, $cart);

if(!$orderId){
    die("Field to insert this order");
}

header("Location: home.php");
exit();