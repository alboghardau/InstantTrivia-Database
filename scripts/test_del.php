<?php
session_start();
ob_start();

$id = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("DELETE FROM tests WHERE id=".$id);
$sql->execute();

$sql = $db->prepare("DELETE FROM quest WHERE test_id=".$id);
$sql->execute();


header("Location: ../tests.php");
ob_flush();
?>