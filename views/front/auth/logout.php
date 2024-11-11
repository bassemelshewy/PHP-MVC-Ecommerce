<?php
session_start();
session_unset();
session_destroy();

header("Location: /views/front/pages/home.php");
exit();
