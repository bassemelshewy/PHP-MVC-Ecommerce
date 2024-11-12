<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/CategoryController.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';

$categories = (new \controllers\CategoryController())->index();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$product = (new \controllers\ProductController())->find($id);

if (!$product) {
    die("Product ID does not exist");
}
// var_dump($product);
// return 0;
// print_r($_POST); 
// print_r($_FILES);
// return 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    $product = (new \controllers\ProductController())->update($id, $name, $description, $category_id, $price, $image);

    if ($product) {
        header("Location: view_products.php");
        exit();
    } else {
        die("Something went wrong! Please try again.");
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Commerce</title>

    <?php include __DIR__ . '/../includes/style.php'; ?>


</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>

        <?php include __DIR__ . '/../includes/header.php'; ?>
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="container-full">
                <section class="content">
                    <div class="box">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h3 class="box-title">Edit Product</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body wizard-content">
                            <form class="form" method="POST" action="" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="form-label">Product name:</label>
                                        <input type="text" class="form-control"
                                            placeholder="Product name" name="name" required minlength="3" value="<?php echo htmlspecialchars($product['name']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Description:</label>
                                        <textarea class="form-control" name="description" id="description" placeholder="Product description"><?php echo htmlspecialchars($product['description']) ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Category:</label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                                    <?php if (htmlspecialchars($category['id']) == htmlspecialchars($product['category_id'])) : ?> selected <?php endif; ?>>
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Price:</label>
                                        <input type="number" name="price" step="0.01" class="form-control" required
                                            value="<?php echo $product['price'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <?php if ($product['image']): ?>
                                            <img src="/../../assets/images/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Product image" width="150" class="rounded border shadow-sm">
                                        <?php else: ?>
                                            <span class="text-muted">No image found</span>
                                        <?php endif; ?>
                                        <div class="mt-20">
                                            <label class="form-label mb-1">Image:</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>


                                </div>
                                <div class="box-footer">
                                    <a href="javascript:history.back()" class="btn btn-warning me-1">
                                        <i class="ti-trash"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-save-alt"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </section>
            </div>
        </div>
    </div>


    <?php include __DIR__ . '/../includes/js.php'; ?>

</body>

</html>