<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}
include __DIR__ . '/../../../controllers/CategoryController.php';
include __DIR__ . '/../../../controllers/BlogController.php';

$categories = (new \controllers\CategoryController())->index();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image'];

    $blog = (new \controllers\BlogController())->create($title, $content, $category_id, $image);

    if ($blog) {
        header("Location: view_blogs.php");
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

    <!-- Vendors Style-->
    <link rel="stylesheet" href="/../../../assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="/../../../assets/css/style.css">
    <link rel="stylesheet" href="/../../../assets/css/skin_color.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">


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
                            <h3 class="box-title">New Blog</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body wizard-content">
                            <form class="form" method="POST" action="" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="form-label">Blog title:</label>
                                        <input type="text" class="form-control"
                                            placeholder="Blog title" name="title" required minlength="3">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Content:</label>
                                        <textarea class="form-control" name="content" id="content" placeholder="Blog content" required minlength="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Category:</label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Image:</label>
                                        <input type="file" name="image" class="form-control">
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
            </div>
        </div>
    </div>


    <!-- Vendor JS -->
    <script src="/../../../assets/js/vendors.min.js"></script>
    <script src="/../../../assets/js/pages/chat-popup.js"></script>
    <script src="/../../../assets/icons/feather-icons/feather.min.js"></script>
    <script src="/../../../assets/vendor_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js">
    </script>
    <script src="/../../../assets/vendor_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js">
    </script>
    <script src="/../../../assets/vendor_components/jquery-steps-master/build/jquery.steps.js"></script>
    <script src="/../../../assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.min.js">
    </script>
    <script src="/../../../assets/vendor_components/select2/dist/js/select2.full.js"></script>
    <script src="/../../../assets/vendor_components/sweetalert/sweetalert.min.js"></script>
    <!-- EduAdmin App -->
    <script src="/../../../assets/js/template.js"></script>
    <script src="/../../../assets/vendor_components/chart.js-master/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <script src="/../../../assets/js/pages/steps.js"></script>
    <script src="/../../../assets/js/pages/advanced-form-element.js"></script>
    <script src="/../../../assets/js/pages/validation.js"></script>
    <script src="/../../../assets/js/pages/form-validation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/../../../assets/vendor_components/datatable/datatables.min.js"></script>
    <script src="/../../../assets/js/pages/data-table.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

</body>

</html>