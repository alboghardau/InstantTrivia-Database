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
            $sql = $db->query("SELECT * FROM quest ORDER BY id ASC LIMIT ".(($_SESSION['edit_page']-1)*20).",20");
            
            $sql2 = $db->prepare("SELECT count(*) FROM quest");
            $sql2->execute();
            $count = $sql2->fetch(PDO::FETCH_NUM);
            
            echo '<center><ul class="pagination">';
            
            for($i = $_SESSION['edit_page']-8; $i < $_SESSION['edit_page']+8; $i++)
            {
                if($i > 0 && $i < $count[0]/20)
                {
                    if($_SESSION['edit_page'] == $i)
                    {
                        echo '<li class="active"><a href="scripts/edit_set_page.php?pg='.$i.'">'.$i."</a></li>"; 
                    }else
                    {
                       echo '<li><a href="scripts/edit_set_page.php?pg='.$i.'">'.$i."</a></li>"; 
                    }
                
                }
            }
            
            echo '</ul></center>';
            
            echo '<table class="table table-condensed">';
            foreach ($sql as $val) {
                echo "<tr>";
                echo '<td>'.$val['id'].'</td>';
                echo '<td>'.$val['question'].'</td>';
                echo '<td>'.$val['answer'].'</td>';
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
    ob_flush();
?>