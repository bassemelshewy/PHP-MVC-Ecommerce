<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/SocialController.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$social = (new SocialController())->find($id);

if (!$social) {
    die("Social Platform ID does not exist");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $url = $_POST['url'];
    $icon = $_FILES['icon'];

    $social = (new SocialController())->update($id, $name, $url, $icon);

    if ($social) {
        header("Location: view_socials.php");
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
                            <h3 class="box-title">Edit Social platform</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body wizard-content">
                            <form class="form" method="POST" action="" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="form-label">Platform name:</label>
                                        <input type="text" class="form-control"
                                            placeholder="Platform name" name="name" required minlength="3" value="<?php echo htmlspecialchars($social['name']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">URL:</label>
                                        <textarea class="form-control" name="url" id="url" placeholder="Platform url"><?php echo htmlspecialchars($social['url']) ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <?php if ($social['icon']): ?>
                                            <img src="/../../assets/images/uploads/socialIcons/<?php echo htmlspecialchars($social['icon']); ?>" alt="Platform icon" width="150" class="rounded border shadow-sm">
                                        <?php else: ?>
                                            <span class="text-muted">No icon found</span>
                                        <?php endif; ?>
                                        <div class="mt-20">
                                            <label class="form-label mb-1">Icon:</label>
                                            <input type="file" name="icon" class="form-control">
                                        </div>
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

</body>

</html>