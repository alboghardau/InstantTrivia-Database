<?php
session_start();
ob_start();

$id = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("DELETE FROM quest WHERE id=".$id);
$sql->execute();

header("Location: ../fault_questions.php");
ob_flush();
?>