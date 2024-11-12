<?php
require_once __DIR__ . '/../../../controllers/SocialController.php';

$socials = (new SocialController())->index();


?>

<footer class="py-5">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">
                    <h2>E-Commerce</h2>
                    <div class="social-links mt-5">
                        <ul class="d-flex list-unstyled gap-2">
                            <?php foreach ($socials as $social) : ?>
                                <li>
                                    <a href="<?php echo htmlspecialchars($social['url']) ?>" class="btn btn-outline-light">
                                        <img src="/../../../assets/images/uploads/socialIcons/<?php echo htmlspecialchars($social['icon']) ?>" alt="<?php echo htmlspecialchars($social['name']) ?> Icon" width="16" height="16">
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Ultras</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item">
                            <a href="/views/front/pages/staticPage.php?slug=about-us" class="nav-link">About us</a>
                        </li>
                        <li class="menu-item">
                            <a href="/views/front/pages/staticPage.php?slug=conditions" class="nav-link">Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Customer Service</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item">
                            <a href="/views/front/pages/contactUs.php" class="nav-link">Contact Us</a>
                        </li>
                        <li class="menu-item">
                            <a href="/views/front/pages/staticPage.php?slug=privacy-policy" class="nav-link">Privacy Policy</a>
                        </li>
                        <li class="menu-item">
                            <a href="/views/front/pages/staticPage.php?slug=delivery-information" class="nav-link">Delivery Information</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="footer-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 copyright">
                <p>© 2023 Foodmart. All rights reserved.</p>
            </div>
            <div class="col-md-6 credit-link text-start text-md-end">
                <p>Free HTML Template by <a href="https://templatesjungle.com/">TemplatesJungle</a> Distributed by <a
                        href="https://themewagon">ThemeWagon</a></p>
            </div>
        </div>
    </div>
</div>