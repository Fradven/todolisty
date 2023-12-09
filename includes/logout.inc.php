<?php

session_start();
session_unset();
session_destroy();
$_SESSION['logout_message'] = 'You have been successfully logged out.';
header("location: ../index.php");
exit();