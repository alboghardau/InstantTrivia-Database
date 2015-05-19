<?php
session_start();
ob_start();

$action = $_GET['action'];

$time_stamp = date("YmdHis");

//EDIT CATEGORY FROM EDIT QUESTION PAGE
if($action == 1){
    $catid = $_GET['cat_id'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../../phpliteadmin/answerit.db");

    $sql = $db->prepare("SELECT * FROM cats WHERE id=".$catid);
    $sql->execute();

    foreach($sql as $val){
        $catname = $val['name'];
    }

    $sql = $db->prepare("UPDATE quest SET cat_id= ?, cat_name=?, time_stamp=? WHERE id=".$qid);
    $sql ->bindParam(1, $catid);
    $sql ->bindParam(2, $catname);
    $sql ->bindParam(3, $time_stamp);
    $sql->execute();

    $_SESSION['edit_q'] = $qid;

    header("Location: ../questions_edit.php");
}

//SET DIFFICULTY FROM EDIT QUESTION PAGE
if($action == 2){
    $d = $_GET['diff'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../../phpliteadmin/answerit.db");

    $sql = $db->prepare("UPDATE quest SET diff= ?, time_stamp= ? WHERE id=".$qid);
    $sql ->bindParam(1, $d);
    $sql ->bindParam(2, $time_stamp);

    $sql->execute();

    $_SESSION['edit_q'] = $qid;

    header("Location: ../questions_edit.php");
}

//EDIT QUESTION FROM MOBILE VIEW
if($action == 3){

    $qid = $_POST['id'];
    $q = $_POST['question'];
    $a = $_POST['answer'];
    $a = strtoupper($a);

    $db = new PDO("sqlite:../../phpliteadmin/answerit.db");

    $sql = $db->prepare("UPDATE quest SET question=?, answer=?, time_stamp=? WHERE id=".$qid);
    $sql ->bindParam(1, $q);
    $sql ->bindParam(2, $a);
    $sql ->bindParam(3, $time_stamp);
    $sql->execute();

    header("Location: ../questions_edit.php");
}

//DELETE FROM EDIT QUESTIONS
if($action == 4){
    $qid = $_GET["id"];

    $db = new PDO("sqlite:../../phpliteadmin/answerit.db");

    $sql1 = $db->prepare("DELETE FROM quest WHERE id=".$qid);
    $sql1->execute();
    $sql2 = $db->prepare("INSERT INTO question_deleted (id,time_stamp) VALUES (?,?)");
    $sql2->bindParam(1,$qid);
    $sql2->bindParam(2,$time_stamp);
    $sql2->execute();

    header("Location: ../questions_edit.php");
}

ob_flush();
?>