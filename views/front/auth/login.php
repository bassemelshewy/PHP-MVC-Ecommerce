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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = (new UserController())->login($email, $password);
    if ($user) {
        $_SESSION['userId'] = $user['id'];
        $_SESSION['userName'] = $user['name'];
        $_SESSION['userEmail'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if ($_SESSION['role'] == 'admin') {
            header('Location: /views/dashboard/home.php');
        } else {
            header('Location: /views/front/pages/home.php');
        }

        if (isset($_SESSION['redirect_to'])) {
            $redirectTo = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']);
            header("Location: $redirectTo");
            exit();
        }

        exit();
    } else {
        die('Invalid email or password');
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
                                <h2 class="text-primary">Let's Get Started</h2>
                                <p class="mb-0">Sign in to continue to Website</p>
                            </div>
                            <div class="p-40">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                            <input type="email" class="form-control ps-15 bg-transparent" placeholder="Email"
                                                name="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
                                            <input type="password" class="form-control ps-15 bg-transparent" placeholder="Password"
                                                name="password" minlength="6" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-danger mt-10">SIGN IN</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>
                                <div class="text-center">
                                    <p class="mt-15 mb-0">Don't have an account? <a href="register.php"
                                            class="text-warning ms-5">Sign Up</a></p>
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
</body>

</html>