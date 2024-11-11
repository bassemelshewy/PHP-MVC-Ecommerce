<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/StaticPagesController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $staticPageObj = new StaticPagesController();

    $staticPage = $staticPageObj->find($id);

    if (!$staticPage) {
        die('This page not found');
    }

    $staticPage = $staticPageObj->delete($id);

    header("Location: view_pages.php");
} else {
    die('Invalid request');
}
