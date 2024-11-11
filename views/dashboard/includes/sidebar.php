<?php
$current_page = basename($_SERVER['PHP_SELF']);

$items = [
    'products' => ['view_products.php', 'add_product.php', 'edit_product.php', 'delete_product.php'],
    'categories' => ['view_categories.php', 'add_category.php', 'edit_category.php', 'delete_category.php'],
    'users' => ['view_users.php', 'add_user.php', 'edit_user.php', 'delete_user.php'],
    'orders' => ['view_orders.php', 'add_order.php', 'edit_order.php', 'delete_order.php'],
    'orderItems' => ['view_items.php'],
    'blogs' => ['view_blogs.php', 'add_blog.php', 'edit_blog.php', 'delete_blog.php'],
    'socials' => ['view_socials.php', 'add_social.php', 'edit_social.php', 'delete_social.php'],
    'staticPages' => ['view_pages.php', 'add_page.php', 'edit_page.php', 'delete_page.php'],
    'contacts' => ['view_contacts.php', 'add_contact.php', 'edit_contact.php', 'delete_contact.php'],
];
function isActive($group)
{
    global $current_page, $items;
    if (isset($items[$group])) {
        return in_array($current_page, $items[$group]) ? 'active' : '';
    }
    return '';
}

?>
<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">Categories</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-th-list"><span class="path1"></span><span class="path2"></span></i>
                            <span>Categories</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('categories'); ?>">
                                <a href="/../views/dashboard/categories/view_categories.php">
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Categories List</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header">Products</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-box"><span class="path1"></span><span class="path2"></span></i>
                            <span>Products</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('products'); ?>">
                                <a href="/../views/dashboard/products/view_products.php">
                                    <i class="icon-Commit"><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Products List</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header">Users</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-users"><span class="path1"></span><span class="path2"></span></i>
                            <span>Users</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('users'); ?>">
                                <a href="/../views/dashboard/users/view_users.php">
                                    <i class="icon-Commit"></class><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Users</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header">Orders</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-clipboard-list"><span class="path1"></span><span class="path2"></span></i>
                            <span>Orders</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('orders'); ?>">
                                <a href="/../views/dashboard/orders/view_orders.php">
                                    <i class="icon-Commit"></class><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Orders</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header">Order items</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-shopping-cart"><span class="path1"></span><span class="path2"></span></i>
                            <span>Order items</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('orderItems'); ?>">
                                <a href="/../views/dashboard/order_items/view_items.php">
                                    <i class="icon-Commit"></class><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Order items</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header">Blogs</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-pen-alt"><span class="path1"></span><span class="path2"></span></i>
                            <span>Blogs</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('blogs'); ?>">
                                <a href="/../views/dashboard/blogs/view_blogs.php">
                                    <i class="icon-Commit"></class><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Blogs</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header">Social URLs</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-link"><span class="path1"></span><span class="path2"></span></i>
                            <span>Social URLs</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('socials'); ?>">
                                <a href="/../views/dashboard/socials/view_socials.php">
                                    <i class="icon-Commit"></class><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Social URLs</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header">Static Pages</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-file-alt"><span class="path1"></span><span class="path2"></span></i>
                            <span>Static Pages</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('staticPages'); ?>">
                                <a href="/../views/dashboard/staticPages/view_pages.php">
                                    <i class="icon-Commit"></class><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Static pages</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header">Contacts Us</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-envelope"><span class="path1"></span><span class="path2"></span></i>
                            <span>Contacts Us</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo isActive('ContactsUs'); ?>">
                                <a href="/../views/dashboard/contactUs/view_contacts.php">
                                    <i class="icon-Commit"></class><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i>
                                    <span>Contacts Us</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <div class="sidebar-footer d-flex justify-content-center align-items-center">
        <a href="/views/front/auth/logout.php" class="link" data-bs-toggle="tooltip" title="Logout">
            <span class="icon-Lock-overturning"><span class="path1"></span><span class="path2"></span>
            </span>
        </a>
    </div>

</aside>