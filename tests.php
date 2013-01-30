<?php $db = new PDO("sqlite:phpliteadmin/answerit.db");
 session_start();
 
              function diff($diff){
                    if($diff == 1)
                    return "Easy";
                    if($diff == 2)
                    return "Medium";
                    if($diff == 3)
                    return "Hard";
                }
                
                if(!isset($_SESSION['test_cat_id']))
                {
                    $_SESSION['test_cat_id'] = 0;
                }
                

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
            <div class="span2">
                <div class="btn-group btn-group-vertical"
                <?php 
                
                $res = $db->query("SELECT * FROM cats");

                foreach ($res as $val) {
                    if($val['id'] == $_SESSION['test_cat_id'] && isset($_SESSION['test_cat_id']))
                    {
                    echo '<a class="btn btn-success" href="scripts/test_set_cat.php?action=1&id='.$val['id'].'">'.$val['name'].'</a>';
                    }
                    else {
                    echo '<a class="btn btn-inverse" href="scripts/test_set_cat.php?action=1&id='.$val['id'].'">'.$val['name'].'</a>';
                    }
                }

                
                ?>
            </div>
            </div>
            
            <div class="span9 well">
               <center>
                
                <?php
                
   

                            
                if(isset($_SESSION['test_cat_id']))
                {
                     echo '<a class="btn" href="scripts/test_add.php?catid='.$_SESSION['test_cat_id'].'">Add Test</a>';
                    
                     $res = $db->query("SELECT * FROM tests WHERE cat_id=".$_SESSION['test_cat_id']);
                     echo '<table class="table"><thead>'; 
                     echo '<th></th>';
                     echo '<th></th>';
                     echo '<th>ID</th>';
                     echo '<th>Diff</th>';
                     echo '</thead><tbody>';
                     foreach($res as $val)
                     {
                         echo '<tr>';
                         echo '<td><a class="btn btn-danger" href="scripts/test_del.php?id='.$val['id'].'">Delete</a></td>';
                         echo '<td><a class="btn btn-warning" href="test_edit.php?id='.$val['id'].'">Edit</a></td>';
                         echo '<td>'.$val['id'].'</td>';
                         echo '<td>'.diff($val['diff']).'</td>';
                         echo '<td>'.$val['topic'].'</td>';
                         echo '</tr>';
                     }
                     echo '</tbody></table>';
                }
                
                
                ?>
            </center>
            </div>
        </div>
        </div>
    </body>
</html>