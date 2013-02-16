<?php
session_start();
ob_start();

$pg = $_GET['pg'];

$_SESSION['add_page'] = $pg;

header("Location: ../add_questions.php");
ob_flush();
?>
