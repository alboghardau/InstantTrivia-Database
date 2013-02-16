<?php
session_start();
$db = new PDO("sqlite:phpliteadmin/questions.db");

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
                echo '<td><a class="btn">'."Add".'</a></td>';
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
?>