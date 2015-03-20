<?php
session_start();
ob_start();

include('simple_html_dom.php');

    $name = $_POST['name'];
    $url = $_POST['url'];

    $ans = new PDO("sqlite:../phpliteadmin/answerit.db");

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

    $html = file_get_html($url);

    $i = 0;
    $table[][] = null;

    foreach($html -> find("td[class=itemprop]") as $element){
        $table[$i][0]=trim($element->plaintext);
        $i++;
    }

    $i = 0;
    foreach($html -> find("td[class=character]") as $element){
        $table[$i][1] = trim($element->plaintext);
        $i++;
    }

    $j = 0;
    foreach($table as list($a, $b)){

        $j++;
        if($j > 40){break;}

        if(str_word_count($a,0)<3) {
            $q = "Who played " . $b . " in '" . $name . "' movie?";
            echo $q.' / '.$a."<br>";
            $q2 = "Which character is played by ".$a." in '".$name."' movie?";
            echo $q2.' / '.$b."<br>";
        try{
            $sql = $ans->prepare("INSERT INTO question_buffer (question,answer,cat_id,cat_name,diff) VALUES (?,?,?,?,?)");
            $sql ->bindParam(1, $q);
            $sql ->bindParam(2, strtoupper($a));
            $sql ->bindParam(3, $cat_id);
            $sql ->bindParam(4, $cat_name);
            $sql ->bindParam(5, $diff);
            $sql->execute();
        }catch(PDOException $e) {echo $e->getMessage();}

            try{
                $sql = $ans->prepare("INSERT INTO question_buffer (question,answer,cat_id,cat_name,diff) VALUES (?,?,?,?,?)");
                $sql ->bindParam(1, $q2);
                $sql ->bindParam(2, strtoupper($b));
                $sql ->bindParam(3, $cat_id);
                $sql ->bindParam(4, $cat_name);
                $sql ->bindParam(5, $diff);
                $sql->execute();
            }catch(PDOException $e) {echo $e->getMessage();}
        }
    }

header("Location: ../special_add.php");


?>