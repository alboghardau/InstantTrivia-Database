<?php
session_start();
ob_start();

$pg = $_GET['pg'];

$_SESSION['edit_page'] = $pg;

header("Location: ../edit_question.php");
ob_flush();
?>
