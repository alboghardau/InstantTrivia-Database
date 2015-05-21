<?php
session_start();
ob_start();

$action = $_GET['action'];


//SET EDIT FOR QUESTION EDIT
if($action == 1){
    $id = $_GET['id'];
    $_SESSION['edit_q'] = $id;
    header("Location: ../questions_edit.php");
}

//SET PAGE FOR QUESTION EDIT
if($action == 2){
    $_SESSION['edit_page'] = $_GET['pg'];
    header("Location: ../questions_edit.php");
}

//SET SEARCH TERM IN SEARCH PAGE
if($action == 3){
    $_SESSION['search_term'] = $_POST['search'];
    header("Location: ../search.php");
}




//SET SEARCH FILTER
if($action == 5){
    $_SESSION['search_filter'] = $_GET['option'];
    header("Location: ../search.php");
}



ob_flush();
?>