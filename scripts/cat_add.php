<?php
session_start();
ob_start();

$get = $_GET['name'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("INSERT INTO cats (name) VALUES (?)");
$sql->execute(array($get));

header("Location: ../categories.php");
ob_flush();
?>
