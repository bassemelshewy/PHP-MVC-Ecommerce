<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/OrderController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $orderObj = new \controllers\OrderController();

    $order = $orderObj->find($id);

    if (!$order) {
        die('Order not found');
    }

    $order = $orderObj->delete($id);

    header("Location: view_orders.php");
} else {
    die('Invalid request');
}
