<?php

session_start();
ob_start();

$file = fopen("../q3.csv","r");
$row = 0;


$database[] = null;


$data = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $data->prepare("SELECT * FROM quest");
$sql->execute();

foreach($sql as $val){
    array_push($database,$val[1]);
}

$sql2 = $data->prepare("SELECT * FROM question_buffer");
$sql2->execute();

foreach($sql2 as $val){
    array_push($database,$val[1]);
}

while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    $num = count($data);
    $row++;
    if ($row > 1) {

        if ($data[0] != "" && $data[1] != "" && !test_answer($data[0])) {
            $q1 = "Which country is the city of $data[1] in?";
            echo "$q1 , $data[0] <br/>";
            if(!search_db($database,$q1)){
                add_to_buffer_table($q1, $data[0]);
            }
        }

        if ($data[0] != "" && $data[2] != "" && $data[1] != "" && !test_answer($data[2])) {
            $q2 = "Which region of $data[0] is the city of $data[1] in?";
            echo "$q2 , $data[2] <br/>";
            if(!search_db($database,$q2)){
                add_to_buffer_table($q2, $data[2]);
            }
        }

        if ($data[0] != "" && $data[1] != "" && $data[3]!= "" && !test_answer($data[1])){
            $q3 = "Which is ".order_string($data[3])." city in the $data[0]?";
            echo "$q3 , $data[1] <br/>";
            if(!search_db($database,$q3)){
                add_to_buffer_table($q3, $data[1]);
            }
        }

        if($data[0]!="" && $data[1]!="" && $data[4]!="" && !test_answer($data[4])){
            $q4 = "On which continent is the city of $data[1]?";
            echo "$q4 , $data[4] <br/>";
            if(!search_db($database,$q4)){
                add_to_buffer_table($q4, $data[4]);
            }
        }

        if($data[0]!="" && $data[5]!="" && !test_answer($data[0])){
            $q5 = "Which country does ".island_test($data[5])." belong to?";
            echo "$q5 , $data[0] <br/>";
            if(!search_db($database,$q5)){
                add_to_buffer_table($q5, $data[0]);
            }
        }

        if($data[5]!="" && $data[6]!="" && !test_answer($data[6])){
            $q6 = "Where is the ".island_test($data[5]." located?");
            echo "$q6 , $data[6] <br/>";
            if(!search_db($database,$q6)){
                add_to_buffer_table($q6, $data[6]);
            }
        }

        if($data[0]!="" && $data[7]!="" & !test_answer($data[0])){
            $q7 = "Which country is the mountain peak $data[7] located in?";
            echo "$q7 , $data[0] <br/>";
            if(!search_db($database,$q7)){
                add_to_buffer_table($q7, $data[0]);
            }
        }

        if($data[0]!="" && $data[7]!="" && $data[8]!="" && !test_answer($data[7])){
            $q8 = "Which mountain peak from $data[0] has a height of $data[8]m?";
            echo "$q8 , $data[7] <br/>";
            if(!search_db($database,$q8)){
                add_to_buffer_table($q8, $data[7]);
            }
        }

        if($data[0]!="" && $data[10]!="" && !test_answer($data[0])){
            $q9 = "Which country does the ".river_test($data[10])." belong to?";
            echo "$q9 , $data[0] <br/>";
            if(!search_db($database,$q9)){
                add_to_buffer_table($q9, $data[0]);
            }
        }

        for($i = 11; $i <= 19; $i++){
            if($data[$i]!="" && $data[1]!="" && !test_answer($data[1])){
                $q10 = "Where is the $data[$i] landmark located?";
                echo "$q10 , $data[1] <br/>";
                if(!search_db($database,$q10)){
                    add_to_buffer_table($q10, $data[1]);
                }
            }
        }
    }
}

fclose($file);

function search_db($db, $question){

    if(in_array($question,$db)){
        return true;
    }else{
        return false;
    }

}

function river_test($river){
    if(strpos($river,"River") !== false){
        return $river;
    }else{
        return "$river River";
    }
}

function island_test($island){
        if(strpos($island,"Island") !== false){
            return $island;
        }else{
            return "island of $island";
        }
}

function test_answer($answer){
    $tester = false;

    if (preg_match('/[^ A-Za-z0-9]/', $answer)) // '/[^a-z\d]/i' should also work.
    {
        return true;
    }

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

function order_string($number){
    switch($number){
        case 1: return "the most populated";
        case 2: return "the 2nd most populated";
        case 3: return "the 3rd most populated";
        case 4: return "the 4th most populated";
        case 5: return "the 5th most populated";
        case 6: return "the 6th most populated";
        case 7: return "the 7th most populated";
        case 8: return "the 8th most populated";
        case 9: return "the 9th most populated";
        case 10: return "the 10th most populated";
    }
}

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

header("Location: ../add_from_buffer.php");
?>