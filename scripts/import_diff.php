<?php
session_start();
ob_start();

$d = $_GET['diff'];
$qid = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("UPDATE quest SET diff= ? WHERE id=".$qid);
$sql ->bindParam(1, $d);

$sql->execute();

header("Location: ../add_questions.php");
ob_flush();
?>