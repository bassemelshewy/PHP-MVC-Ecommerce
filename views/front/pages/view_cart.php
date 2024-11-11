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
                <div class="section-header text-center mb-5">
                    <h2 class="section-title fw-bold display-6">
                        Shipping Cart
                    </h2>
                    <hr class="w-25 mx-auto" style="border-top: 3px solid #007bff;">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="products-carousel swiper">
                        <div class="swiper-wrapper">
                            <?php if(!empty($cart)) :
                                foreach ($cartItems as $item): ?>
                                <div class="product-item swiper-slide" style="flex: 0 0 20%; max-width: 20%;">
                                    <figure>
                                        <a href="single_product.php?product_id=<?php echo htmlspecialchars($item['id']); ?>" title="<?php echo htmlspecialchars($item['name']); ?>">
                                            <img src="/../../../assets/images/uploads/products/<?php echo htmlspecialchars($item['image']); ?>" class="cart-image" alt="product image">
                                        </a>
                                    </figure>
                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <span>Category: <?php echo htmlspecialchars($item['category_name']); ?></span>
                                    <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                                    <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                                    <p>Subtotal: $<?php echo number_format($item['subTotal'], 2); ?></p>

                                    <form action="add_to_cart.php" method="POST">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="input-group product-qty">
                                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                                <input type="number" name="quantity" class="form-control input-number" value="0" min="1" max="100">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Quantity</button>
                                        </div>
                                    </form>

                                    <form action="delete_from_cart.php" method="POST">
                                        <div class="d-flex align-items-center justify-content-between mt-3">
                                            <div class="input-group product-qty">
                                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                            </div>
                                            <button type="submit" class="btn btn-danger" style="background-color: red !important;">Delete from Cart</button>
                                        </div>
                                    </form>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <div class="container text-center">
                            <h2>Your cart is empty.</h2>
                        </div>
                    <?php endif; ?>

                    </div>
                </div>
                <?php if(!empty($cart)) :?>
                    <div class="cart-total">
                        <h4>Total: $<?php echo number_format($total, 2); ?></h4>
                        <a href="checkOut.php" class="btn btn-primary mt-3">Checkout</a>
                    </div>
                <?php endif?>
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