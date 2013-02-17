<?php
session_start();
$db = new PDO("sqlite:phpliteadmin/questions.db");
$ans = new PDO("sqlite:phpliteadmin/answerit.db");

include("functions.php");

if(!isset($_SESSION['add_page'])) {$_SESSION['add_page'] = 0;}

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
            
            <?php
            
            if(isset($_SESSION['edit_q']))
            {
                $sql = $ans->prepare("SELECT * FROM quest WHERE id=".$_SESSION['edit_q']);
                $sql->execute();
                foreach($sql as $val)
                {
                    $q = $val['question'];
                    $a = $val['answer'];
                }
                
                echo '<div class="span12 well">';
                
                echo '<form class="form-inline" action="scripts/import_edit.php" method="post">
                      <input type="text" name="q" value="'.$q.'" style="width:60%"/>
                      <input type="text" name="a" value="'.$a.'"/>
                      <input type="hidden" name="id" value="'.$_SESSION['edit_q'].' "/>
                      <button class="btn" type="submit">Edit</button>
                      </form>
';
                disp_cats($_SESSION['edit_q']);
                disp_diff($_SESSION['edit_q']);
                
                echo '</div>';
            }
            
            ?>      
            
            <div class="span12 well">
        
                <center>
                    <form class="form-inline" method="get" action="scripts/add_set_page.php">
                        Pg;<input type="text" name="pg"/>
                        <button class="btn "type="submit">Set</button>
                    </form>
                </center>
                
                
            <?php 
            $sql = $db->query("SELECT * FROM questions ORDER BY id ASC LIMIT ".$_SESSION['add_page'].",20");
            
            $sql2 = $db->prepare("SELECT count(*) FROM questions");
            $sql2->execute();
            $count = $sql2->fetch(PDO::FETCH_NUM);
            
            echo '<center><div class="pagination"><ul>';
            
            for($i = $_SESSION['add_page']-8; $i < $_SESSION['add_page']+8; $i++)
            {
                if($i > 0 && $i < $count[0]/20)
                {
                    if($_SESSION['add_page'] == $i)
                    {
                        echo '<li class="active"><a href="scripts/add_set_page.php?pg='.$i.'">'.$i."</a></li>"; 
                    }else
                    {
                       echo '<li><a href="scripts/add_set_page.php?pg='.$i.'">'.$i."</a></li>"; 
                    }
                
                }
            }
            
            echo '</ul></div></center>';
            
            
            echo '<table class="table table-condensed">';
            foreach ($sql as $val) {
                echo "<tr>";
                echo '<td>'.$val['question'].'</td>';
                echo '<td>'.$val['answer'].'</td>';
                echo '<td><a class="btn" href="scripts/import_q.php?id='.$val['id'].'">'."Add".'</a></td>';
                echo "</tr>";
    
}
            echo '</table>';
            
            ?>    
                
            </div>
        </div>
        </div>
    </body>
</html>

<?php
$db = null;
$ans = null;
?>