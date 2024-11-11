<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/SocialController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $socialObj = new SocialController();

    $social = $socialObj->find($id);

    if (!$social) {
        die('Platform URL not found');
    }

    $social = $socialObj->delete($id);

    header("Location: view_socials.php");
} else {
    die('Invalid request');
}
