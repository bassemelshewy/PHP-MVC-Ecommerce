<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}
require_once __DIR__ . '/../../../controllers/StaticPagesController.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$page = (new StaticPagesController())->find($id);

if (!$page) {
    die('Page not found');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $content = $_POST['content'];

    $page = (new StaticPagesController())->update($id, $name, $slug,  $content);

    if ($page) {
        header("Location: view_pages.php?");
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
                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h3 class="box-title">Edit Page</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body wizard-content">
                            <form class="form" method="POST" action="">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="form-label">Page name:</label>
                                        <input type="text" class="form-control"
                                            placeholder="Page name" name="name" required minlength="3"
                                            value="<?php echo htmlspecialchars($page['name']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Slug:</label>
                                        <input type="text" class="form-control"
                                            placeholder="Page slug" name="slug" required minlength="3"
                                            value="<?php echo htmlspecialchars($page['slug']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Content:</label>
                                        <textarea class="form-control" name="content" id="content" placeholder="Page content"><?php echo htmlspecialchars($page['content']) ?></textarea>
                                    </div>
                                </div>
                                <!-- /.box-body -->
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
                <!-- /.content -->
            </div>
        </div>
    </div>


    <?php include __DIR__ . '/../includes/js.php'; ?>

</body>

</html>