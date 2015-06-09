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

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-60465509-2', 'auto');
    ga('send', 'pageview');

</script>