<?php
//GENERATE JSON RESPONSE FOR UPDATE REQUEST
//$receivedTimeStamp = $_POST['time'];

$receivedTimeStamp = 20150400000000;

$data = new PDO("sqlite:../phpliteadmin/answerit.db");
$sql = $data->prepare("SELECT * FROM quest WHERE time_stamp > ".$receivedTimeStamp);
$sql->execute();
$sql->setFetchMode(PDO::FETCH_OBJ);

$json = json_encode(array('questions' => $sql->fetchAll()));
echo $json;

 
?>


