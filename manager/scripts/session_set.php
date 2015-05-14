<?php
session_start();
ob_start();

$action = $_GET['action'];
$id = $_GET['id'];

//set session for edit question page
if($action == 1){
        
    $_SESSION['edit_q'] = $id;
    header("Location: ../edit_question.php");
}

//set search string for edit questions page
if($action == 2){
    $text = $_POST['q_search'];
    if($text != ""){
        $_SESSION["q_search"] = $text;
    }else{
        unset($_SESSION['q_search']);
    }

    header("Location: ../edit_question.php");
}

//category search term in add questions
if($action == 3){
    $text = $_POST['cat_search'];
        if($text != ""){
        $_SESSION["cat_search"] = $text;
    }else{
        unset($_SESSION['cat_search']);
    }

    header("Location: ../add_questions.php");
}

//set page for add question
if($action == 4){
    $pg = $_GET['pg'];

$_SESSION['add_page'] = $pg;
unset($_SESSION['cat_search']);

header("Location: ../add_questions.php");
}
if($action == 5){
    $pg = $_POST['pg'];

$_SESSION['add_page'] = $pg;
unset($_SESSION['cat_search']);

header("Location: ../add_questions.php");
}


//set pre set diff in add question
if($action == 6)
{
    $_SESSION['preset_diff'] = $_GET['diff'];
    header("Location: ../add_questions.php");
}

//set pre set category in add question
if($action == 7){
    $_SESSION['preset_cat'] = $_GET['cat_id'];
    header("Location: ../add_questions.php");
}

//set pre set diff in add question
if($action == 8)
{
    $_SESSION['preset_diff'] = $_GET['diff'];
    header("Location: ../special_add.php");
}

//set pre set category in add question
if($action == 9){
    $_SESSION['preset_cat'] = $_GET['cat_id'];
    header("Location: ../special_add.php");
}


//set page for add question buffer
if($action == 10){
    $pg = $_GET['pg'];

    $_SESSION['add_page'] = $pg;
    unset($_SESSION['cat_search']);

    header("Location: ../add_from_buffer.php");
}

//set pre set diff in add question
if($action == 11)
{
    $_SESSION['preset_diff'] = $_GET['diff'];
    header("Location: ../add_from_buffer.php");
}

//set pre set category in add question
if($action == 12){
    $_SESSION['preset_cat'] = $_GET['cat_id'];
    header("Location: ../add_from_buffer.php");
}



ob_flush();
?>