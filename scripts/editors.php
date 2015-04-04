<?php

session_start();
ob_start();

$action = $_GET['action'];

//EDIT CATEGORY FROM EDIT QUESTION PAGE
if($action == 1){
    $catid = $_GET['cat_id'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("SELECT * FROM cats WHERE id=".$catid);
    $sql->execute();

    foreach($sql as $val){
        $catname = $val['name'];
    }

    $sql = $db->prepare("UPDATE quest SET cat_id= ?, cat_name=? WHERE id=".$qid);
    $sql ->bindParam(1, $catid);
    $sql ->bindParam(2, $catname);
    $sql->execute();

    header("Location: ../edit_question.php");
}

//SET DIFFICULTY FOR EDIT QUESTION
if($action ==2 ){    
    $d = $_GET['diff'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("UPDATE quest SET diff= ? WHERE id=".$qid);
    $sql ->bindParam(1, $d);

    $sql->execute();

    header("Location: ../edit_question.php");
}

//ADD QUESTIONS SET CAT FOR EDIT
if($action == 3){
    $catid = $_GET['cat_id'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("SELECT * FROM cats WHERE id=".$catid);
    $sql->execute();

    foreach($sql as $val){
        $catname = $val['name'];
    }

    $sql = $db->prepare("UPDATE quest SET cat_id= ?, cat_name=? WHERE id=".$qid);
    $sql ->bindParam(1, $catid);
    $sql ->bindParam(2, $catname);
    $sql->execute();

    header("Location: ../add_questions.php");
}

//ADD QUESTIONS SET DIFF FOR EDIT
if($action == 4){
    $d = $_GET['diff'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("UPDATE quest SET diff= ? WHERE id=".$qid);
    $sql ->bindParam(1, $d);

    $sql->execute();

    header("Location: ../add_questions.php");
}

if($action == 5){
    $id = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("DELETE FROM quest WHERE id=".$id);
    $sql->execute();

    unset($_SESSION['edit_q']);

    header("Location: ../edit_question.php");
}

if($action == 6){
    $q = $_POST['q'];
    $a = $_POST['a'];
    $qid = $_POST['id'];
    $a = strtoupper($a);

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("UPDATE quest SET question= ?, answer= ? WHERE id=".$qid);
    $sql ->bindParam(1, $q);
    $sql ->bindParam(2, $a);
    $sql->execute();

    header("Location: ../edit_question.php");
}

//REFRESH NUMBER OF QUESTIONS
if($action == 7){
    
    $db = new PDO("sqlite:../phpliteadmin/answerit.db");
    
    $sql = $db->query("SELECT * FROM cats");
    
    foreach ($sql as $val){
        
        $sql2 = $db->prepare("SELECT count(*) FROM quest WHERE cat_id =".$val['id']);
        $sql2->execute();
        $result = $sql2->fetch(PDO::FETCH_NUM);
                
        $sql3 = $db->prepare("UPDATE cats SET total_no = ? WHERE id=".$val['id']);
        $sql3 ->bindParam(1, $result[0]);
        $sql3->execute();
        
        $sql2 = $db->prepare("SELECT count(*) FROM quest WHERE diff = 1 AND cat_id =".$val['id']);
        $sql2->execute();
        $result = $sql2->fetch(PDO::FETCH_NUM);
                
        $sql3 = $db->prepare("UPDATE cats SET easy_no = ? WHERE id=".$val['id']);
        $sql3 ->bindParam(1, $result[0]);
        $sql3->execute();
        
        $sql2 = $db->prepare("SELECT count(*) FROM quest WHERE diff = 2 AND cat_id =".$val['id']);
        $sql2->execute();
        $result = $sql2->fetch(PDO::FETCH_NUM);
                
        $sql3 = $db->prepare("UPDATE cats SET med_no = ? WHERE id=".$val['id']);
        $sql3 ->bindParam(1, $result[0]);
        $sql3->execute();

        $sql2 = $db->prepare("SELECT count(*) FROM quest WHERE diff = 3 AND cat_id =".$val['id']);
        $sql2->execute();
        $result = $sql2->fetch(PDO::FETCH_NUM);
                
        $sql3 = $db->prepare("UPDATE cats SET hard_no = ? WHERE id=".$val['id']);
        $sql3 ->bindParam(1, $result[0]);
        $sql3->execute();
    }
    header("Location: ../categories.php");
}

//DELETE ALL QUESTIONS FROM MAIN TABLE FOR ONE CATEGORY
if($action == 8){
    $cat_id = $_GET['id'];
    
    $db = new PDO("sqlite:../phpliteadmin/answerit.db");
    
    $sql = $db->query("DELETE FROM quest WHERE cat_id = ".$cat_id);
    
    header("Location: ../categories.php");
    
}

//DELETE ALL RECORDS FROM QUESTION BUFFER TABLE
if($action == 9){
    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->query("DELETE FROM question_buffer");

    header("Location: ../add_from_buffer.php");
}

//DELETE QUESTION FROM BASE QUESTIONS DATABASE
if($action == 10){
    $id = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/questions.db");

    $sql = $db->query("DELETE FROM questions WHERE id=".$id);

    header("Location: ../add_questions.php");
}

//ADD SIMPLE QUESTION TO BUFFER TABLE
if($action == 11){

    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("INSERT INTO question_buffer (question,answer) VALUES (?,?)");
    $sql ->bindParam(1, $question);
    $sql ->bindParam(2, $answer);
    $sql->execute();

    header("Location: ../special_add.php");
}

//BUFFER QUESTIONS SET CAT FOR EDIT
if($action == 12){
    $catid = $_GET['cat_id'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("SELECT * FROM cats WHERE id=".$catid);
    $sql->execute();

    foreach($sql as $val){
        $catname = $val['name'];
    }

    $sql = $db->prepare("UPDATE quest SET cat_id= ?, cat_name=? WHERE id=".$qid);
    $sql ->bindParam(1, $catid);
    $sql ->bindParam(2, $catname);
    $sql->execute();

    header("Location: ../add_from_buffer.php");
}

//BUFFER QUESTIONS SET DIFF FOR EDIT
if($action == 13){
    $d = $_GET['diff'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->prepare("UPDATE quest SET diff= ? WHERE id=".$qid);
    $sql ->bindParam(1, $d);

    $sql->execute();

    header("Location: ../add_from_buffer.php");
}

//DELETE QUESTION FROM BUFFER TABLE MAIN DATABASE
if($action == 14){
    $id = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $db->query("DELETE FROM question_buffer WHERE id=".$id);

    header("Location: ../add_from_buffer.php");
}


ob_flush();

?>
