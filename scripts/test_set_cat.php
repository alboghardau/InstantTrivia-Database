<?php
session_start();
ob_start();

$action = $_GET['action'];
$id = $_GET['id'];

if($action == 1){
    $_SESSION['test_cat_id'] = $id;
 
}


header("Location: ../tests.php");
ob_flush();
?>
