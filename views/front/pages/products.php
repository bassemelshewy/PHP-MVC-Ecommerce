<?php
session_start();

require_once __DIR__ . '/../../../controllers/front/ProductController.php';
require_once __DIR__ . '/../../../controllers/CategoryController.php';

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : null;

if(empty($category_id) && empty($search)){
    die('You must specify a category or a search');
}

if ($category_id) {
    $category = (new \controllers\CategoryController())->find($category_id);
    if (!$category) {
        die("Category not found");
    }
}
$products = (new \controllers\front\ProductController())->viewAll($category_id, $search);

// die(var_dump($products));
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
            <div class="section-header text-center mb-5">
                <h2 class="section-title fw-bold display-6">
                    Products
                </h2>
                <hr class="w-25 mx-auto" style="border-top: 3px solid #007bff;">
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="products-carousel swiper">
                        <div class="swiper-wrapper d-flex">
                            <?php if($products) : ?>
                            <?php foreach ($products as $product): ?>
                                <div class="product-item swiper-slide" style="flex: 0 0 20%; max-width: 20%;">
                                    <figure class="mb-3">
                                        <a href="single_product.php?product_id=<?php echo $product['id'] ?>" title="<?php echo htmlspecialchars($product['name']); ?>">
                                            <img src="/../../../assets/images/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" class="tab-image img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-height: 200px; object-fit: cover; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                                        </a>
                                    </figure>
                                    <h3 class="mt-2 fw-bold"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <span class="qty text-muted d-block"><?php echo htmlspecialchars($product['category_name']); ?></span>
                                    <span class="price fw-bold text-success d-block mb-3">$<?php echo htmlspecialchars($product['price']); ?></span>
                                    <form action="add_to_cart.php" method="POST">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="input-group product-qty">
                                                <span class="input-group-btn">
                                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                                        <svg width="16" height="16">
                                                            <use xlink:href="#minus"></use>
                                                        </svg>
                                                    </button>
                                                </span>
                                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                                <input type="number" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                                                <span class="input-group-btn">
                                                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                                        <svg width="16" height="16">
                                                            <use xlink:href="#plus"></use>
                                                        </svg>
                                                    </button>
                                                </span>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                </div>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <div class="container text-center">
                            <h2>No Products Available.</h2>
                        </div>
                    <?php endif; ?>

                    </div>
                </div>
                <!-- / products-carousel -->
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