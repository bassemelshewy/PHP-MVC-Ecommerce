<?php

require_once __DIR__ . '/../../../controllers/StaticPagesController.php';

$staticPagesController = new StaticPagesController();

$slug = $_GET['slug'] ?? '';

if($slug == ''){
    die('Must provide a slug');
}

$staticPage = $staticPagesController->find($slug, 'slug');

if(!$staticPage){
    die('This page with this slug not found');
}

// die($staticPage['name']);
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

    <section class="py-5 overflow-hidden bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title fw-bold display-6">
                        <?php echo htmlspecialchars($staticPage['name']); ?>
                    </h2>
                    <hr class="w-25 mx-auto" style="border-top: 3px solid #007bff;">
                </div>
                
                <div class="info-content bg-white text-dark border rounded shadow-sm p-5">
                    <p class="lead mb-4" style="font-size: 1.25rem; line-height: 1.7;">
                        <?php echo htmlspecialchars($staticPage['content']); ?>
                    </p>
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