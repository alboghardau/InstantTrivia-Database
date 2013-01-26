<?php
session_start();
ob_start();

$id = $_GET['id'];

$_SESSION['cat_show'] = $id;

header("Location: ../categories.php");
ob_flush();
?>
