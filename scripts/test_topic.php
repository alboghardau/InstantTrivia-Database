<?php
session_start();
ob_start();

$id = $_POST['test_id'];
$desc = $_POST['desc'];

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("UPDATE tests SET topic=? WHERE id=".$id);
$sql->execute(array($desc));

$db = null;
header("Location: ../test_edit.php?id=".$id);
ob_flush();
?>