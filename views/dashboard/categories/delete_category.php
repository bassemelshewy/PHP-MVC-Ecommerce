<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/CategoryController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $categoryObj = new \controllers\CategoryController();

    $category = $categoryObj->find($id);

    if (!$category) {
        die('Category not found');
    }

    $category = $categoryObj->delete($id);

    header("Location: view_categories.php");
} else {
    die('Invalid request');
}
