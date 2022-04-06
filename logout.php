<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['login']);
unset($_SESSION['email']);
unset($_SESSION['avatar']);
header("Location: index.php");
?>