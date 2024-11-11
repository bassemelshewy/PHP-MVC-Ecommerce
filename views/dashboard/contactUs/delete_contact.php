<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/ContactUsController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $contactUsObj = new ContactUsController();
    $contactUs = $contactUsObj->find($id);

    if (!$contactUs) {
        die('This message not found');
    }

    $contactUs = $contactUsObj->delete($id);

    header("Location: view_contacts.php");
} else {
    die('Invalid request');
}
