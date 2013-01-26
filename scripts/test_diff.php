<?php
session_start();
ob_start();

$diff= $_GET['diff'];
$id = $_GET['testid'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("UPDATE tests SET diff=? WHERE id=".$id);
$sql->execute(array($diff));

$sql = $db->prepare("UPDATE quest SET diff=? WHERE test_id=".$id);
$sql->execute(array($diff));

header("Location: ../test_edit.php?id=".$id);
ob_flush();
?>