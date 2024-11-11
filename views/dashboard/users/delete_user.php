<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/UserController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $userObj = new UserController();

    $user = $userObj->find($id);

    if (!$user) {
        die('User not found');
    }

    $user = $userObj->delete($id);

    header("Location: view_users.php");
} else {
    die('Invalid request');
}
