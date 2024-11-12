<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../controllers/CategoryController.php';
require_once __DIR__ . '/../../../controllers/BlogController.php';

$categories = (new \controllers\CategoryController())->index();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$blog = (new \controllers\BlogController())->find($id);

if (!$blog) {
    die("Blog ID does not exist");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image'];

    $blog = (new \controllers\BlogController())->update($id, $title, $content, $category_id, $image);

    if ($blog) {
        header("Location: view_blogs.php");
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
                            <h3 class="box-title">Edit Blog</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body wizard-content">
                            <form class="form" method="POST" action="" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="form-label">Blog name:</label>
                                        <input type="text" class="form-control"
                                            placeholder="Blog title" name="title" required minlength="3" value="<?php echo htmlspecialchars($blog['title']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Content:</label>
                                        <textarea class="form-control" name="content" id="content" placeholder="Blog content"><?php echo htmlspecialchars($blog['content']) ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Category:</label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                                    <?php if (htmlspecialchars($category['id']) == htmlspecialchars($blog['category_id'])) : ?> selected <?php endif; ?>>
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <?php if ($blog['image']): ?>
                                            <img src="/../../assets/images/uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" alt="Blog image" width="150" class="rounded border shadow-sm">
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