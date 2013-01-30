<?php
session_start();
ob_start();

$act = $_GET['act'];
$tid = $_GET['tid'];
$id = $_GET['id'];

    $db = new PDO("sqlite:../phpliteadmin/answerit.db");
   
    if($act == 1)
    {
    $sql = $db->prepare("DELETE FROM quest WHERE id=".$id);
    $sql->execute();
    }
    if($act == 2)
    {
        $_SESSION['edit_q'] = $id;
    }
    if($act == 3)
    {
        unset($_SESSION['ans_test']);
        unset($_SESSION['edit_q']);
    }
$db = null;   
header("Location: ../test_edit.php?id=".$tid);
ob_flush();
?>
