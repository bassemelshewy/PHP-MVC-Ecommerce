<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}
require_once __DIR__ . '/../../../controllers/OrderItemsController.php';
require_once __DIR__ . '/../../../controllers/OrderController.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;

// die(var_dump($order_id));

if ($order_id) {
    $order = (new \controllers\OrderController())->find($order_id);
    // die(var_dump($order));
    if (!$order) {
        die("Order not found");
    }
}

$orderItems = (new \controllers\OrderItemsController())->index($order_id);

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
                    <div class="col-12">
                        <div class="box">
                            <div class="card-header pb-0 d-flex justify-content-between">
                                <h3 class="box-title">Orders</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User name</th>
                                                <th>User email</th>
                                                <th>Product Name</th>
                                                <th>Image</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $index = 1 ?>
                                            <?php foreach ($orderItems as $orderItem) : ?>
                                                <tr>
                                                    <th><?php echo $index++; ?></th>
                                                    <th><?php echo htmlspecialchars($orderItem['user_name']); ?></th>
                                                    <th><?php echo htmlspecialchars($orderItem['user_email']); ?></th>
                                                    <th><?php echo htmlspecialchars($orderItem['product_name']); ?></th>
                                                    <th>
                                                        <?php if ($orderItem['product_image']): ?>
                                                            <img src="/../../../assets/images/uploads/products/<?php echo htmlspecialchars($orderItem['product_image']); ?>" alt="Product image" width="50">
                                                        <?php else: ?>
                                                            No image found
                                                        <?php endif; ?>
                                                    </th>
                                                    <th><?php echo htmlspecialchars($orderItem['price']); ?></th>
                                                    <th><?php echo htmlspecialchars($orderItem['quantity']); ?></th>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>User name</th>
                                                <th>User email</th>
                                                <th>Product Name</th>
                                                <th>Image</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
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


    <?php include __DIR__ . '/../includes/js.php'; ?>

</body>

</html>