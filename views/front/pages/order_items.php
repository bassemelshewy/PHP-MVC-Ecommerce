<?php
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'user') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/OrderController.php';
require_once __DIR__ . '/../../../controllers/front/OrderItemsController.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;

// die(var_dump($order_id));

if($order_id){
    $order = (new \controllers\OrderController())->find($order_id);
    // die(var_dump($order));
    if(!$order){
        die("Order not found");
    }
}

$orderItems = (new \controllers\front\OrderItemsController())->viewOrderItems($order_id);

// die(var_dump($orderItems));
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
                            Order Items
                        </h2>
                        <hr class="w-25 mx-auto" style="border-top: 3px solid #007bff;">
                    </div>

                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($orderItems as $orderItem): ?>
                                <div class="product-item swiper-slide" style="flex: 0 0 20%; max-width: 20%;">
                                    <figure class="mb-3">
                                        <a href="single_product.php?product_id=<?php echo $orderItem['product_id'] ?>" title="<?php echo htmlspecialchars($orderItem['product_name']); ?>">
                                            <img src="/../../../assets/images/uploads/products/<?php echo htmlspecialchars($orderItem['product_image']); ?>" class="tab-image img-fluid" alt="<?php echo htmlspecialchars($orderItem['product_name']); ?>" style="max-height: 200px; object-fit: cover; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                                        </a>
                                    </figure>
                                    <h3 class="mt-2 fw-bold"><?php echo htmlspecialchars($orderItem['product_name']); ?></h3>
                                    <span class="qty text-muted d-block">Category name: <?php echo htmlspecialchars($orderItem['category_name']); ?></span>
                                    <span class="price fw-bold text-success d-block mb-3">$<?php echo htmlspecialchars($orderItem['price']); ?></span>
                                </div>
                            <?php endforeach; ?>
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