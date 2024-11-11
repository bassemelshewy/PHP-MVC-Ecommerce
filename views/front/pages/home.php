<?php
session_start();

require_once __DIR__ . '/../../../controllers/front/CategoryController.php';
require_once __DIR__ . '/../../../controllers/front/ProductController.php';
require_once __DIR__ . '/../../../controllers/front/BlogController.php';

$frontCategoryController = new \controllers\front\CategoryController();
$frontProductController = new \controllers\front\ProductController();
$frontBlogController = new \controllers\front\BlogController();

$limitCategories = $frontCategoryController->viewLimit();

$justArrivedProducts = $frontProductController->getJustArrived();

$limitBlogs = $frontBlogController->viewLimit();

$bestSellingProducts = $frontProductController->getBestSelling();

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

                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Categories</h2>

                        <div class="d-flex align-items-center">
                            <a href="categories.php" class="btn-link text-decoration-none">View All Categories →</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($limitCategories as $category): ?>
                                <a href="products.php?category_id=<?php echo $category['id'] ?>" class="nav-link category-item swiper-slide">
                                    <h3 class="category-title"><?php echo htmlspecialchars($category['name']); ?></h3>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex justify-content-between">

                        <h2 class="section-title">Just arrived</h2>

                        <div class="d-flex align-items-center">
                            <a href="categories.php" class="btn-link text-decoration-none">View All Categories →</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                                <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="products-carousel swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($justArrivedProducts as $product): ?>
                                <div class="product-item swiper-slide" style="flex: 0 0 20%; max-width: 20%;">
                                    <figure>
                                        <a href="single_product.php?product_id=<?php echo $product['id'] ?>" title="Product Title">
                                            <img src="/../../../assets/images/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" class="tab-image" alt="product image">
                                        </a>
                                    </figure>
                                    <h3><?php echo htmlspecialchars($product['name']) ?></h3>
                                    <span class="qty"><?php echo htmlspecialchars($product['category_name']) ?></span>
                                    <span class="price">$<?php echo htmlspecialchars($product['price']) ?></span>
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

                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>

    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between my-5">

                        <h2 class="section-title">Best selling products</h2>

                        <div class="d-flex align-items-center">
                            <a href="categories.php" class="btn-link text-decoration-none">View All Categories →</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                                <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="products-carousel swiper">
                        <div class="swiper-wrapper">

                            <?php foreach ($bestSellingProducts as $product) : ?>
                                <div class="product-item swiper-slide" style="flex: 0 0 20%; max-width: 20%;">
                                    <figure>
                                        <a href="single_product.php?product_id=<?php echo $product['id'] ?>" title="Product Title">
                                            <img src="/../../../assets/images/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" class="tab-image">
                                        </a>
                                    </figure>
                                    <h3><?php echo htmlspecialchars($product['name']) ?></h3>
                                    <span class="qty"><?php echo htmlspecialchars($product['category_name']) ?></span>
                                    <br>
                                    <span>Number of selling: <?php echo htmlspecialchars($product['count_selling']) ?></span>
                                    <span class="price">$<?php echo htmlspecialchars($product['price']) ?></span>
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
                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>


    <section id="latest-blog" class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="section-header d-flex align-items-center justify-content-between my-5">
                    <h2 class="section-title">Our Recent Blog</h2>
                    <div class="btn-wrap align-right">
                        <a href="blogs.php" class="d-flex align-items-center nav-link">Read All Blogs <svg width="24" height="24">
                                <use xlink:href="#arrow-right"></use>
                            </svg></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($limitBlogs as $blog) : ?>
                    <div class="col-md-3">
                        <article class="post-item card border-0 shadow-sm p-3">
                            <div class="image-holder zoom-effect">
                                <a href="single_blog.php?blog_id=<?php echo $blog['id'] ?>">
                                    <img src="/../../../assets/images/uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" alt="post image" class="card-img-top">
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                                    <div class="meta-date"><svg width="16" height="16">
                                            <use xlink:href="#calendar"></use>
                                        </svg><?php $createdAt = $blog['created_at'];
                                                echo date('Y-m-d', strtotime($createdAt));
                                                ?>
                                    </div>
                                    <div class="meta-categories"><svg width="16" height="16">
                                            <use xlink:href="#category"></use>
                                        </svg><?php echo htmlspecialchars($blog['category_name']); ?></div>
                                </div>
                                <div class="post-header">
                                    <h3 class="post-title">
                                        <a href="single_blog.php?blog_id=<?php echo $blog['id'] ?>" class="text-decoration-none"><?php echo htmlspecialchars($blog['title']); ?></a>
                                    </h3>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
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