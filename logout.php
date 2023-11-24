<?php
session_start();
session_destroy();

header('location:voter/login.view.php');
?>
