<?php
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'user') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/front/OrderController.php';

$user_id = $_SESSION['userId'];

$frontOrderController = new \controllers\front\OrderController();

$orders = $frontOrderController->getUserOrders($user_id);

// die(var_dump($orders));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>E-Commerce</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/../../../assets/front/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="/../../../assets/front/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

</head>

<body>
    <div class="preloader-wrapper">
        <div class="preloader">
        </div>
    </div>


    <?php include __DIR__ . '/../includes/header.php'; ?>

    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header text-center mb-5">
                        <h2 class="section-title fw-bold display-6">
                            Your Orders
                        </h2>
                        <hr class="w-25 mx-auto" style="border-top: 3px solid #007bff;">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            <?php if (!empty($orders)) :?>
                                <?php foreach ($orders as $index => $order): ?>
                                    <div class="category-item swiper-slide bg-light text-dark border rounded pt-5 d-flex flex-column justify-content-between" style="height: 270px;">
                                        <div class="content mb-auto">
                                            <h3 class="category-title h5 mb-3 text-center fw-bold">Order <?php echo $index + 1 ?></h3>
                                            <p class="text-center">Total Price: $<?php echo number_format($order['total_price'], 2); ?></p>
                                            <p class="text-center">Ordered At: <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                                        </div>
                                        
                                        <h3 class="post-title h6 text-center">
                                            <a href="order_items.php?order_id=<?php echo $order['id']; ?>" class="text-decoration-none text-primary fw-semibold" style="color: red;">
                                                View all Items
                                            </a>
                                        </h3>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="container text-center">
                                    <h2>No orders found.</h2>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>


    <script src="/../../../assets/front/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="/../../../assets/front/js/plugins.js"></script>
    <script src="/../../../assets/front/js/script.js"></script>
</body>

</html>