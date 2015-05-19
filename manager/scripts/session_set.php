<?php
session_start();
ob_start();

$action = $_GET['action'];
$id = $_GET['id'];

//SET EDIT FOR QUESTION EDIT
if($action == 1){
        
    $_SESSION['edit_q'] = $id;
    header("Location: ../questions_edit.php");
}

//SET PAGE FOR QUESTION EDIT
if($action == 2){
    $_SESSION['edit_page'] = $_GET['pg'];
    header("Location: ../questions_edit.php");
}



ob_flush();
?>