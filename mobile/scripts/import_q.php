<?php
session_start();
ob_start();

$id = $_GET['id'];

//GENERATE TIMESTAMP
$time_stamp = date("YmdHis");
echo $time_stamp;

$db = new PDO("sqlite:../../phpliteadmin/questions.db");
$ans = new PDO("sqlite:../../phpliteadmin/answerit.db");

$sql = $db->prepare("SELECT * FROM questions WHERE id=".$id);
$sql->execute();

foreach($sql as $val)
{
   $q = $val['question'];
   $a = $val['answer'];
}

echo $q."/".$a."<br/>";



if(isset($_SESSION['preset_cat'])){
    $sql = $ans->prepare("SELECT * FROM cats WHERE id=".$_SESSION['preset_cat']);
    $sql->execute();

       foreach ($sql as $val) {
           $cat_id = $val['id'];
           $cat_name = $val['name'];
       }
}else{
    $cat_id = 0;
    $cat_name = "name";
}

if(isset($_SESSION['preset_diff'])){
    $diff = $_SESSION['preset_diff'];
}else{
    $diff = 1;
}

var_dump($cat_name);

try{
$sql = $ans->prepare("INSERT INTO quest (question,answer,cat_id,cat_name,diff,time_stamp) VALUES (?,?,?,?,?,?)");
$sql ->bindParam(1, $q);
$sql ->bindParam(2, strtoupper($a));
$sql ->bindParam(3, $cat_id);
$sql ->bindParam(4, $cat_name);
$sql ->bindParam(5, $diff);
$sql ->bindParam(6, $time_stamp);
$sql->execute();

var_dump($sql);

echo $sql->rowCount();
}
catch(PDOException $e) {echo $e->getMessage();}

$sql = $db->prepare("DELETE FROM questions WHERE id=".$id);
$sql->execute();

$sql = $ans->prepare("SELECT * FROM quest ORDER BY id DESC LIMIT 1");
$sql->execute();
foreach($sql as $val)
{
    $id = $val['id'];
}

header("Location: ../mobile_edit_q.php?id=".$id);
ob_flush();
?>
