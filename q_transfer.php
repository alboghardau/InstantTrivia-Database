<?php

$db = new PDO("sqlite:phpliteadmin/answerit.db"); 

$from_id = 21;
$to_id = 14;

$sql = $db->query("SELECT * FROM cats WHERE id=".$from_id);
foreach ($sql as $val){
    $from_name = $val['name'];
}

$sql = $db->query("SELECT * FROM cats WHERE id=".$to_id);
foreach ($sql as $val){
    $to_name = $val['name'];
}

echo $from_name."<br/>";
echo $to_name;

$sql = $db->prepare("UPDATE quest SET cat_id= ?, cat_name= ? WHERE cat_id=".$from_id);
$sql ->bindParam(1, $to_id);
$sql ->bindParam(2, $to_name);

$sql->execute();

?>