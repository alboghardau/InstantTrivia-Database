<?php
session_start();
ob_start();

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
ob_flush();
?>