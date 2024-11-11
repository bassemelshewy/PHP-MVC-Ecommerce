<?php
session_start();

require_once __DIR__ . '/../../../controllers/BlogController.php';
$adminBlogController = new \controllers\BlogController;
$blogs = $adminBlogController->index();

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

    <section id="latest-blog" class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title fw-bold display-6">
                        Our Blogs
                    </h2>
                    <hr class="w-25 mx-auto" style="border-top: 3px solid #007bff;">
                </div>
            </div>
            <div class="row">
                <?php foreach ($blogs as $blog) : ?>
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