<?php


$id = $_POST['id'];
$ratio = $_POST['ratio'];

file_put_contents('testfile.txt',$id." / ".$ratio);


$data = new PDO("sqlite:../phpliteadmin/o_answerit.db");

$sql = $data->prepare("SELECT * FROM question_difficulty WHERE id=".$id);
$sql->execute();
$rows = $sql->fetch(PDO::FETCH_NUM);

if($rows[0] == 0){      //val nu este in tabel

    $sql2 = $data->prepare("INSERT INTO question_difficulty (id,times_played,diff_ratio) VALUES (?,?,?)");
    $times = 1;
    $sql2 -> bindParam(1, $id);
    $sql2 -> bindParam(2, $times);
    $sql2 -> bindParam(3, $ratio);
    $sql2 -> execute();

}else{                  //val este in tabel

    $sql3 = $data->prepare("SELECT * FROM question_difficulty WHERE id=".$id);
    $sql3 -> execute();

    foreach($sql3 as $val){
        $times = $val[1];
        $read_ratio = $val[2];
    }

    $new_ratio = (($times*$read_ratio)+$ratio)/($times+1);
    $new_times = $times+1;

    $sql4 = $data->prepare("UPDATE question_difficulty SET times_played=?, diff_ratio=? WHERE id=".$id);
    $sql4 -> bindParam(1, $new_times);
    $sql4 -> bindParam(2, $new_ratio);
    $sql4 -> execute();
}



?>