<?php
session_start();
ob_start();

$action = $_GET['action'];

$time_stamp = date("YmdHis");

//EDIT CATEGORY FROM MOBILE EDIT QUESTION PAGE
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

    header("Location: ../mobile_edit_q.php?id=".$qid);
}

//SET DIFFICULTY FOR EDIT QUESTION
if($action == 2){
    $d = $_GET['diff'];
    $qid = $_GET['id'];

    $db = new PDO("sqlite:../../phpliteadmin/answerit.db");

    $sql = $db->prepare("UPDATE quest SET diff= ?, time_stamp= ? WHERE id=".$qid);
    $sql ->bindParam(1, $d);
    $sql ->bindParam(2, $time_stamp);

    $sql->execute();

    header("Location: ../mobile_edit_q.php?id=".$qid);
}

//EDIT
if($action == 3){

    $qid = $_GET['id'];
    $q = $_POST['question'];
    $a = $_POST['answer'];
    $a = strtoupper($a);

    $db = new PDO("sqlite:../../phpliteadmin/answerit.db");

    $sql = $db->prepare("UPDATE quest SET question=?, answer=?, time_stamp=? WHERE id=".$qid);
    $sql ->bindParam(1, $q);
    $sql ->bindParam(2, $a);
    $sql ->bindParam(3, $time_stamp);
    $sql->execute();

    //header("Location: ../mobile_edit_q.php?id=".$qid);
}


ob_flush();