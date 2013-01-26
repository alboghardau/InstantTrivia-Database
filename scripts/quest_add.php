<?php
session_start();
ob_start();

$testid = $_POST['test_id'];
$q = $_POST['question'];
$a = $_POST['answer'];
$a = strtoupper($a);

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$quer = $db->query("SELECT * FROM tests WHERE id=".$testid);
foreach($quer as $res)
{
    $cat_id = $res['cat_id'];
    $diff = $res['diff'];
}

$quer = $db->query("SELECT * FROM cats WHERE id=".$cat_id);
foreach ($quer as $res)
{
    $cat_name = $res['name'];

}

$sql = $db->prepare("INSERT INTO quest (question,answer,cat_id,cat_name,test_id,diff) VALUES (?,?,?,?,?,?)");
$sql ->bindParam(1, $q);
$sql ->bindParam(2, $a);
$sql ->bindParam(3, $cat_id);
$sql ->bindParam(4, $cat_name);
$sql ->bindParam(5, $testid);
$sql ->bindParam(6, $diff);
$sql->execute();

header("Location: ../test_edit.php?id=".$testid);
ob_flush();
?>
