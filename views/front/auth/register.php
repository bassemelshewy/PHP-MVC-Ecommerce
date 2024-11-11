<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: /views/dashboard/home.php');
        exit();
    } else {
        header('Location: /views/front/pages/home.php');
        exit();
    }
}
include __DIR__ . '/../../../controllers/UserController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    // var_dump($email);
    // return 0;

    if (empty($email)) {
        die('Email is not set or empty.');
    }

    if ($password !== $password_confirmation) {
        die('Passwords do not match.');
    }
    $userController = new UserController();
    $user = $userController->find($email, 'email');

    if ($user) {
        die('User already exists');
    }

    if ($userController->register($name, $email, $password)) {
        header('Location: login.php');
    } else {
        die('User registration failed');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Commerce</title>
    <!-- Vendors Style-->
    <link rel="stylesheet" href="/../../../assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="/../../../assets/css/style.css">
    <link rel="stylesheet" href="/../../../assets/css/skin_color.css">


</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(/../../../assets/images/auth-bg/bg-2.jpg)">

    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">
            <div class="col-12">
                <div class="row justify-content-center g-0">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="bg-white rounded10 shadow-lg">
                            <div class="content-top-agile p-20 pb-0">
                                <h2 class="text-primary">Get started with Us</h2>
                                <p class="mb-0">Register a new membership</p>
                            </div>
                            <div class="p-40">
                                <form action="" method="POST" onsubmit="return validation()">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                            <input type="text" class="form-control ps-15 bg-transparent "
                                                placeholder="Full Name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="ti-email"></i></span>
                                            <input type="email" class="form-control ps-15 bg-transparent" placeholder="Email"
                                                name="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                            <input type="password" class="form-control ps-15 bg-transparent" placeholder="Password"
                                                name="password" minlength="6" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                            <input type="password" class="form-control ps-15 bg-transparent"
                                                placeholder="Retype Password" name="password_confirmation" minlength="6" required>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-info margin-top-10">SIGN IN</button>
                                    </div>
                                </form>
                                <div class="text-center">
                                    <p class="mt-15 mb-0">Already have an account?<a href="login.php"
                                            class="text-danger ms-5"> SIGN IN</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Vendor JS -->
    <script src="/../../../assets/js/vendors.min.js"></script>
    <script src="/../../../assets/js/pages/chat-popup.js"></script>
    <script src="/../../../assets/icons/feather-icons/feather.min.js"></script>
    <script>
        function validation() {
            const password = document.querySelector('input[name="password"]').value;
            const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;

            if (password !== passwordConfirmation) {
                alert("passwords do not match");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>