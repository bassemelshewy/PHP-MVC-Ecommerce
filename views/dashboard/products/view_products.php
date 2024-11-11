<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}
require_once __DIR__ . '/../../../controllers/ProductController.php';

$products = (new \controllers\ProductController())->index();

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
                    <div class="col-12">
                        <div class="box">
                            <div class="card-header pb-0 d-flex justify-content-between">
                                <h3 class="box-title">Products</h3>
                                <a href="add_product.php" class="btn btn-info btn-sm">
                                    Add Product
                                </a>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>name</th>
                                                <th>description</th>
                                                <th>category name</th>
                                                <th>price</th>
                                                <th>Number of selling</th>
                                                <th>image</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $index = 1 ?>
                                            <?php foreach ($products as $product) : ?>
                                                <tr>
                                                    <th><?php echo $index++; ?></th>
                                                    <th><?php echo htmlspecialchars($product['name']); ?></th>
                                                    <th>
                                                        <?php if ($product['description']): ?>
                                                            <?php echo htmlspecialchars($product['description']); ?></th>
                                                <?php else: ?>
                                                    No description found
                                                <?php endif; ?>
                                                <th><?php echo htmlspecialchars($product['category_name']); ?></th>
                                                <th><?php echo htmlspecialchars($product['price']); ?></th>
                                                <th><?php echo htmlspecialchars($product['count_selling']); ?></th>
                                                <th>
                                                    <?php if ($product['image']): ?>
                                                        <img src="/../../../assets/images/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Product image" width="50">
                                                    <?php else: ?>
                                                        No image found
                                                    <?php endif; ?>
                                                </th>

                                                <th>
                                                    <div class="dropdown">
                                                        <a class="cursor-pointer" id="dropdownTable" role="button" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v text-secondary" aria-hidden="true"></i>
                                                        </a>
                                                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable" data-popper-placement="top-start">
                                                            <li><a class="dropdown-item border-radius-md text-warning" href="edit_product.php?id=<?php echo $product['id'] ?>">Edit</a></li>
                                                            <li>
                                                                <form method="POST" action="delete_product.php?id=<?php echo $product['id'] ?>"
                                                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                                                                        <input type="submit" class="dropdown-item text-danger border-radius-md" value="Delete">
                                                                    </div>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </th>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>name</th>
                                                <th>description</th>
                                                <th>category name</th>
                                                <th>price</th>
                                                <th>Number of selling</th>
                                                <th>image</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
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