<?php $db = new PDO("sqlite:phpliteadmin/answerit.db");
 session_start();

 $testid = $_GET['id'];
 
 function show_diff($lvl)
 {
     switch ($lvl) {
         case 1: $diff = "Easy"; break;
         case 2: $diff = "Medium"; break;
         case 3: $diff = "Hard"; break;          
     }
     return $diff;
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
          
            <div class="span12 well">
                <a class="btn" href="tests.php">Back</a>
       
                

                <?php
                
                //read test topic
                $res2 = $db->query("SELECT * FROM tests WHERE id=".$testid);
                     foreach($res2 as $val2)
                     {
                         $topic = $val2['topic'];   
                         $ex_diff = $val2['diff'];
                     }                

                if(isset($_SESSION['edit_q']))
                {
                       
                     echo '<a class="btn" href="scripts/quest_edit_set.php?act=3&tid='.$testid.'">Close Edit</a>';
                     $res = $db->query("SELECT * FROM quest WHERE id=".$_SESSION['edit_q']);
                     foreach ($res as $val)
                     {
                         $qu = $val['question'];
                         $an = $val['answer'];
                         $qid = $val['id'];
                        
                         
                     }
                     
                     
                    echo '          <center>
                <table>
                <form action="scripts/quest_edit.php" method="post">
                <tr><td>Question:</td><td><textarea type="text-area" name="question" rows="4"/>'.$qu.'</textarea></td></tr>
                <tr><td>  Answer:</td><td><input type="text" name="answer" value="'.$an.'"/></td></tr>
                <tr><td></td><td><button  class="btn" type="submit">Edit</button></td></tr>
                <input type="hidden" name="quest_id" value="'.$qid.'"/>   
                <input type="hidden" name="test_id" value="'.$testid.'"/>        
                </form>
                </table></center>';
                }else{                    
                    echo '
                        <center><table>
                <form action="scripts/quest_add.php" method="post">
                <tr><td>Question:</td><td><textarea type="text-area" name="question" rows="4"/></textarea></td></tr>
                <tr><td>  Answer:</td><td><input type="text" name="answer"/></td></tr>
                <tr><td></td><td><button  class="btn" type="submit">Add</button></td></tr>
                <input type="hidden" name="test_id" value="'.$testid.'"/>
                </form>
                </table></center>';
                    
                    echo'
                <br/><center>
                <form class="form-inline" action="scripts/test_topic.php" method="post">                
                Topic:</td><td><input class="input-long" type="text" name="desc" value="'.$topic.'"/>
                <button  class="btn" type="submit">Save</button>
                <input type="hidden" name="test_id" value="'.$testid.'"/>
                </form></center>               
                        ';
                }
                 
                echo "<center>";
                for($i = 1; $i <= 3; $i++)
                {
                    if($ex_diff == $i)
                    {    
                    echo '<a class="btn btn-warning" href="scripts/test_diff.php?diff='.$i.'&testid='.$testid.'">'.show_diff($i)."</a>";
                    }
                    else
                    {                        
                    echo '<a class="btn" href="scripts/test_diff.php?diff='.$i.'&testid='.$testid.'">'.show_diff($i)."</a>";
                    }
                }
                echo "</center>";
                
                $no = 1;
             
                     $res = $db->query("SELECT * FROM quest WHERE test_id=".$testid);
                     echo '<table class="table"><thead>'; 
                     echo '<th>Del</th>';
                     echo '<th>Edit</th>';
                     echo '<th>No</th>';
                     echo '<th>ID</th>';
                     echo '<th>Q</th>';
                     echo '<th>A</th>';
                     
                     echo '</thead><tbody>';
                     foreach($res as $val)
                     {
                         echo '<tr>';
                         echo '<td><a class="btn btn-danger" href="scripts/quest_edit_set.php?act=1&tid='.$testid.'&id='.$val['id'].'">'.'</a></td>';
                         echo '<td><a class="btn btn-warning" href="scripts/quest_edit_set.php?act=2&tid='.$testid.'&id='.$val['id'].'">'.'</a></td>';
                         echo '<td>'.$no.'</td>';
                         echo '<td>'.$val['id'].'</td>';
                         echo '<td>'.$val['question'].'</td>';
                         echo '<td>'.$val['answer'].'</td>';
                         echo '</tr>';
                         
                         $no++;
                     }
                     echo '</tbody></table>';
               
                ?>
          
            </div>
        </div>
        </div>
    </body>
</html>