<?php
session_start();
require_once __DIR__ . '/../../../controllers/BlogController.php';

$blog_id = $_GET['blog_id'];

$blog = (new \controllers\BlogController())->find($blog_id);

if(!$blog){
    die("Blog not found");
}
// die(var_dump($blog));
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

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-image">
                        <img src="/../../../assets/images/uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>"
                            class="img-fluid"
                            alt="<?php echo htmlspecialchars($blog['title']); ?>"
                            style="width: 100%; height: auto;">
                    </div>
                </div>
                <div class="col-md-6"> <!-- Right column for blog details -->
                    <div class="blog-post-details p-4 bg-light rounded shadow-sm">
                        <h2 class="blog-title display-4 mb-3 text-success"><?php echo htmlspecialchars($blog['title']); ?></h2>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="badge bg-secondary fs-5 fw-bold"><?php echo htmlspecialchars($blog['category_name']); ?></span>
                            <span>By <?php echo htmlspecialchars($blog['user_name']); ?> on <?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                        </div>
                        <p class="blog-description"><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
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