<?php
session_start();
ob_start();

$testid = $_POST['test_id'];
$q = $_POST['question'];
$a = $_POST['answer'];
$qid = $_POST['quest_id'];
$a = strtoupper($a);

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("UPDATE quest SET question=?, answer=? WHERE id=".$qid);
$sql ->bindParam(1, $q);
$sql ->bindParam(2, $a);
$sql->execute();

header("Location: ../test_edit.php?id=".$testid);
ob_flush();
?>