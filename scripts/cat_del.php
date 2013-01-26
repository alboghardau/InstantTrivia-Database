<?php
session_start();
ob_start();

$id = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("DELETE FROM cats WHERE id=".$id);
$sql->execute();

$sql = $db->prepare("UPDATE quest SET cat_id=0 WHERE cat_id=".$id);
$sql->execute();

$sql = $db->prepare("DELETE FROM tests WHERE cat_id=".$id);
$sql->execute();


header("Location: ../categories.php");
ob_flush();
?>