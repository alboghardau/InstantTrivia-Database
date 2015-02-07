<?php

session_start();
ob_start();

$action = $_GET['action'];

//EDIT CATEGORY FROM EDIT QUESTION PAGE
if($action == 1){
    
    $catid = $_GET['cat_id'];
$qid = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("SELECT * FROM cats WHERE id=".$catid);
$sql->execute();

foreach($sql as $val)
{
    $catname = $val['name'];
}

$sql = $db->prepare("UPDATE quest SET cat_id= ?, cat_name=? WHERE id=".$qid);
$sql ->bindParam(1, $catid);
$sql ->bindParam(2, $catname);
$sql->execute();

header("Location: ../edit_question.php");    
}

//SET DIFFICULTY FOR EDIT QUESTION
if($action ==2 ){    
$d = $_GET['diff'];
$qid = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("UPDATE quest SET diff= ? WHERE id=".$qid);
$sql ->bindParam(1, $d);

$sql->execute();

header("Location: ../edit_question.php");
}

//ADD QUESTIONS SET CAT FOR EDIT
if($action == 3){
    $catid = $_GET['cat_id'];
$qid = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("SELECT * FROM cats WHERE id=".$catid);
$sql->execute();

foreach($sql as $val)
{
    $catname = $val['name'];
}

$sql = $db->prepare("UPDATE quest SET cat_id= ?, cat_name=? WHERE id=".$qid);
$sql ->bindParam(1, $catid);
$sql ->bindParam(2, $catname);
$sql->execute();

header("Location: ../add_questions.php");
}

//ADD QUESTIONS SET DIFF FOR EDIT
if($action == 4){
    $d = $_GET['diff'];
$qid = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("UPDATE quest SET diff= ? WHERE id=".$qid);
$sql ->bindParam(1, $d);

$sql->execute();

header("Location: ../add_questions.php");
}



ob_flush();

?>
