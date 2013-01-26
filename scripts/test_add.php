<?php
session_start();
ob_start();

$catid = $_GET['catid'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("INSERT INTO tests (cat_id) VALUES (?)");
$sql ->bindParam(1, $catid);
$sql->execute();

header("Location: ../tests.php");
ob_flush();
?>
