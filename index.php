<?php
session_start();

if (isset($_SESSION['userId']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: /views/dashboard/home.php');
    } else {
        header('Location: /views/front/pages/home.php');
    }
    exit();
} else {
    header('Location: /views/front/pages/home.php');
    exit();
}
