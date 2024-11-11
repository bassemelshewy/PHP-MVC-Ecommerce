<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/BlogController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $blogObj = new \controllers\BlogController();

    $blog = $blogObj->find($id);

    if (!$blog) {
        die('Blog not found');
    }

    $blog = $blogObj->delete($id);

    header("Location: view_blogs.php");
} else {
    die('Invalid request');
}
