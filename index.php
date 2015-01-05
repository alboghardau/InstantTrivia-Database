<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="stylesheet">
    </head>
    <body>
        
        <?php include("menu.php");?>
        
        <div class="container">
        <div class="row">

            <div class="span12 well">
                <table class="table">
            <?php
            include("functions.php");
            
            $db = new PDO("sqlite:phpliteadmin/answerit.db"); 
            
            $sql = $db->query("SELECT * FROM quest");
            foreach($sql as $val)
            {
                if(test_chars($val['answer']) == false)
                {
                echo "<tr>";
                echo "<td>".$val['answer'].'<td>';
                echo '</tr>';
                }
            }
            
          test_chars("TES AS");
                    
            
            ?>
            </table>
            </div>
        </div>
        </div>
    </body>
</html>