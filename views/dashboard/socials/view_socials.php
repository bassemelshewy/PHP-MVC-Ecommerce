<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 'admin') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: /views/front/auth/login.php");
    exit();
}
require_once __DIR__ . '/../../../controllers/SocialController.php';

$socials = (new SocialController())->index();

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
                    <div class="col-12">
                        <div class="box">
                            <div class="card-header pb-0 d-flex justify-content-between">
                                <h3 class="box-title">Social URLs</h3>
                                <a href="add_social.php" class="btn btn-info btn-sm">
                                    Add social platform
                                </a>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>URL</th>
                                                <th>Created by</th>
                                                <th>Icon</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $index = 1 ?>
                                            <?php foreach ($socials as $social) : ?>
                                                <tr>
                                                    <th><?php echo $index++; ?></th>
                                                    <th><?php echo htmlspecialchars($social['name']); ?></th>
                                                    <th><?php echo htmlspecialchars($social['url']); ?></th>
                                                    <th><?php echo htmlspecialchars($social['user_name']); ?></t>

                                                    <th>
                                                        <?php if ($social['icon']): ?>
                                                            <img src="/../../../assets/images/uploads/socialIcons/<?php echo htmlspecialchars($social['icon']); ?>" alt="Social icon" width="50">
                                                        <?php else: ?>
                                                            No image found
                                                        <?php endif; ?>
                                                    </th>

                                                    <th>
                                                        <div class="dropdown">
                                                            <a class="cursor-pointer" id="dropdownTable" role="button" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">
                                                                <i class="fa fa-ellipsis-v text-secondary" aria-hidden="true"></i>
                                                            </a>
                                                            <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable" data-popper-placement="top-start">
                                                                <li><a class="dropdown-item border-radius-md text-warning" href="edit_social.php?id=<?php echo $social['id'] ?>">Edit</a></li>
                                                                <li>
                                                                    <form method="POST" action="delete_social.php?id=<?php echo $social['id'] ?>"
                                                                        onsubmit="return confirm('Are you sure you want to delete this social url?');">
                                                                        <div class="form-group">
                                                                            <input type="hidden" name="delete_id" value="<?php echo $social['id']; ?>">
                                                                            <input type="submit" class="dropdown-item text-danger border-radius-md" value="Delete">
                                                                        </div>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </th>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>URL</th>
                                                <th>Created by</th>
                                                <th>Icon</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>


    <?php include __DIR__ . '/../includes/js.php'; ?>

</body>

</html>