<?php
session_start();
ob_start();

$q = $_POST['q'];
$a = $_POST['a'];
$qid = $_POST['id'];
$a = strtoupper($a);

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("UPDATE quest SET question= ?, answer= ? WHERE id=".$qid);
$sql ->bindParam(1, $q);
$sql ->bindParam(2, $a);
$sql->execute();

header("Location: ../add_questions.php");
ob_flush();
?>