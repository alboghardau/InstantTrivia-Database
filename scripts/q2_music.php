<?php

session_start();
ob_start();

$file = fopen("../songs.csv","r");
$row = 0;
while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    $num = count($data);
    $row++;

    if(!test_answer($data[0])) {
        echo "Which $data[1] $data[2] recorded the track $data[4] in $data[3]? ".strtoupper($data[0])."<br/>";
        add_to_buffer_table("Which $data[1] $data[2] recorded the track '$data[4]' in $data[3]?", $data[0]);
    }

    if(!test_answer($data[1])) {
        echo "What music genre is the track $data[4] by $data[0]? ".strtoupper($data[1])."<br/>";
        add_to_buffer_table("What music genre is the track '$data[4]' by $data[0]?",$data[1]);
    }

    if(!test_answer($data[5])){
        echo "Which album by the $data[1] $data[2] $data[0] has the track $data[4]? ".strtoupper($data[5])."<br/>";
        add_to_buffer_table("Which album by the $data[1] $data[2] $data[0] has the track '$data[4]'?",$data[5]);
    }
}

fclose($file);

function add_to_buffer_table($question , $answer){

    $ans = new PDO("sqlite:../phpliteadmin/answerit.db");

    $cat_id = 0;
    $cat_name = "test";
    $diff = 1;

    try{
        $sql = $ans->prepare("INSERT INTO question_buffer (question,answer) VALUES (?,?)");
        $sql ->bindParam(1, $question);
        $sql ->bindParam(2, strtoupper($answer));
        $sql->execute();
    }catch(PDOException $e) {echo $e->getMessage();}


}

function test_answer($answer){
    $tester = false;

    if(ctype_digit($answer)){
        return true;
    }

    $array = explode(" ", $answer);

    if(sizeof($array) > 2){
        return true;
    }
    foreach ($array as $key => $value){
        if(strlen($value) > 10){
            return true;
        }
    }
}

header("Location: ../add_from_buffer.php");

?>