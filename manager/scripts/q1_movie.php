<?php
session_start();
ob_start();

include('simple_html_dom.php');


    $id = $_POST['id'];

    $ans = new PDO("sqlite:../../phpliteadmin/answerit.db");

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

    //READS MOVIE NAME FROM MOVIEDB.ORG
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://api.themoviedb.org/3/movie/$id?api_key=7b5e30851a9285340e78c201c4e4ab99");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($response, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

    foreach ($jsonIterator as $key => $val) {
        if(is_array($val)) {

        } else {
            if($key == "original_title") {
                $name = $val;
            }
        }
    }


    //READS FROM MOVIEDB.ORG THE CAST
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://api.themoviedb.org/3/movie/$id/credits?api_key=7b5e30851a9285340e78c201c4e4ab99");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($response, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

    $i = 0;
    $j = 0;
    foreach ($jsonIterator as $key => $val) {
        if(is_array($val)) {
            //echo "$key:\n";
        } else {
            if($key == "character") {
                $characters[$i] = $val;
                $i++;
            }
            if($key == "name"){
                $actors[$j] = $val;
                $j++;
            }
        }
    }

    //ADDS QUESTIONS TO THE DATABASE
    $j = 0;
    for( $i = 0 ; $i < sizeof($characters) ; $i++){

        if(str_word_count($actors[$i],0)<3 && str_word_count($characters[$i]) < 3) {
            $q = "Who played " . $characters[$i] . " in '" . $name . "' movie?";
            echo $q.' / '.$actors[$i]."<br>";
            $q2 = "Which character is played by ".$actors[$i]." in '".$name."' movie?";
            echo $q2.' / '.$characters[$i]."<br>";
        try{
            $sql = $ans->prepare("INSERT INTO question_buffer (question,answer,cat_id,cat_name,diff) VALUES (?,?,?,?,?)");
            $sql ->bindParam(1, $q);
            $sql ->bindParam(2, strtoupper($actors[$i]));
            $sql ->bindParam(3, $cat_id);
            $sql ->bindParam(4, $cat_name);
            $sql ->bindParam(5, $diff);
            $sql->execute();
        }catch(PDOException $e) {echo $e->getMessage();}

            try{
                $sql = $ans->prepare("INSERT INTO question_buffer (question,answer,cat_id,cat_name,diff) VALUES (?,?,?,?,?)");
                $sql ->bindParam(1, $q2);
                $sql ->bindParam(2, strtoupper($characters[$i]));
                $sql ->bindParam(3, $cat_id);
                $sql ->bindParam(4, $cat_name);
                $sql ->bindParam(5, $diff);
                $sql->execute();
            }catch(PDOException $e) {echo $e->getMessage();}
        }
    }

header("Location: ../buffer_add.php");


?>