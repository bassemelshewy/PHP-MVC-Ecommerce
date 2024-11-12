<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/UserController.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$user = (new UserController())->find($id);
// var_dump($user);
// echo $user["name"];
// return 0;
if (!$user) {
    die("user ID does not exist");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    $role = $_POST['role'];

    // var_dump($password, $password_confirmation);
    // return 0;
    if ($password !== $password_confirmation) {
        die('Passwords do not match.');
    }

    $userUpdated = (new UserController())->update($id, $name, $email, $role, $password);

    if ($userUpdated) {
        header("Location: view_users.php");
        exit();
    } else {
        die("Something went wrong! Please try again.");
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Commerce</title>

    <?php include __DIR__ . '/../includes/style.php'; ?>


</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>

        <?php include __DIR__ . '/../includes/header.php'; ?>
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="container-full">
                <section class="content">
                    <div class="box">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h3 class="box-title">Edit User</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body wizard-content">
                            <form class="form" method="POST" action="" onsubmit="return validation()">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="form-label">Name:</label>
                                        <input type="text" class="form-control"
                                            placeholder="User name" name="name" required minlength="3" value="<?php echo htmlspecialchars($user["name"]) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email:</label>
                                        <input type="email" class="form-control ps-15 bg-transparent" placeholder="Email"
                                            name="email" required value="<?php echo htmlspecialchars($user["email"]) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Role:</label>
                                        <select name="role" class="form-control" required>
                                            <option value="">Select role</option>
                                            <option value="admin"
                                                <?php if (htmlspecialchars($user["role"]) == "admin") : ?> selected <?php endif; ?>>
                                                Admin
                                            </option>
                                            <option value="user"
                                                <?php if (htmlspecialchars($user["role"]) == "user") : ?> selected <?php endif; ?>>
                                                User
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Password:</label>
                                        <input type="password" class="form-control ps-15 bg-transparent" placeholder="Password"
                                            name="password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Password conformation:</label>
                                        <input type="password" class="form-control ps-15 bg-transparent" placeholder="Retype Password"
                                            name="password_confirmation">
                                    </div>


                                </div>
                                <div class="box-footer">
                                    <a href="javascript:history.back()" class="btn btn-warning me-1">
                                        <i class="ti-trash"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-save-alt"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </section>
            </div>
        </div>
    </div>


    <?php include __DIR__ . '/../includes/js.php'; ?>
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