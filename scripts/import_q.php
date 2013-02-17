<?php
session_start();
ob_start();

$id = $_GET['id'];

$db = new PDO("sqlite:../phpliteadmin/questions.db");
$ans = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->prepare("SELECT * FROM questions WHERE id=".$id);
$sql->execute();

foreach($sql as $val)
{
   $q = $val['question'];
   $a = $val['answer'];
}

echo $q."/".$a."<br/>";

$cat_id = 0;
$cat_name = "name";
$diff = 1;
$testid = 0;

try{
$sql = $ans->prepare("INSERT INTO quest (question,answer,cat_id,cat_name,test_id,diff) VALUES (?,?,?,?,?,?)");
$sql ->bindParam(1, $q);
$sql ->bindParam(2, $a);
$sql ->bindParam(3, $cat_id);
$sql ->bindParam(4, $cat_name);
$sql ->bindParam(5, $testid);
$sql ->bindParam(6, $diff);
//$sql->execute();

var_dump($sql);

echo $sql->rowCount();
}
catch(PDOException $e) {echo $e->getMessage();}

$sql = $ans->prepare("SELECT * FROM quest ORDER BY id DESC LIMIT 1");
$sql->execute();
foreach($sql as $val)
{
    $_SESSION['edit_q'] = $val['id'];
}

header("Location: ../add_questions.php");
ob_flush();
?>
