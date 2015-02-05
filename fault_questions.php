<?php 
session_start();
ob_start();
$db = new PDO("sqlite:phpliteadmin/answerit.db");
if(!isset($_SESSION['edit_page'])) {$_SESSION['edit_page'] = 1;}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css" type="stylesheet">
    </head>
    <body>
       
         <?php include("menu.php");?>
        <div class="container">
            <div class="row">
                <div class="span12 well">
          
            <?php
            $sql = $db->query("SELECT * FROM quest");
            
            $sql2 = $db->prepare("SELECT count(*) FROM quest");
            $sql2->execute();
            $count = $sql2->fetch(PDO::FETCH_NUM);            
        
            echo '<table class="table table-condensed">';
            foreach ($sql as $val) {
                
                if(test_answer($val['answer'],$val['question']) == true){
                echo "<tr>";
                    echo '<td>'.'<a class="btn btn-danger" href="scripts/quest_del.php?id='.$val['id'].'"/>'.'</td>';
                    echo '<td>'.$val['id'].'</td>';
                    echo '<td>'.$val['question'].'</td>';
                    echo '<td>'.$val['answer'].'</td>';
                echo "</tr>";                    
                }
            }            
            echo '</table>';            
            ?>
                </div> 
            </div>
        </div>
    </body>
</html>

<?php
    function test_answer($answer,$question){
        $tester = false;
        
        if (strpos($question,'  ') != false) {
            return true;
        }
//        if (strpos($question,"?") == false){
//            return true;
//        }
        
        if(ctype_lower($answer)){
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

    ob_flush();
?>