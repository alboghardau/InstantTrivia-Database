<?php $db = new PDO("sqlite:phpliteadmin/answerit.db"); 
 session_start();
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
                                
                if(isset($_SESSION['sub_cat_add']))
                {
                    echo '<div class="span5">';
                    echo '<form class="form-inline" action="scripts/sub_cat_add.php" method="get">
                    New SubCat: <input type="text" name="name"/>
                    <input type="hidden" name="catid" value="'.$_SESSION['sub_cat_add'].'"/>
                    <input type="hidden" name="action" value="2"/>
                    <button type="submit" class="btn">Add</button>
                    </form>';
                    
                    

                    echo '</div>';
                    
                }
                ?>
                
               <br/>
                <form class="form-inline" action="scripts/cat_add.php" method="get">
                    NewCategory: <input type="text" name="name"/>
                    <button type="submit" class="btn">Add</button>
                </form>
                
                <?php
                echo '<a class="btn btn-warning" href="scripts/editors.php?action=7" method="get">Count Questions</a>' ;
                
                $res = $db->query("SELECT * FROM cats");
                echo '<table class="table table-striped">'; 
                echo '<thead>';

                echo '<th></th>';
                echo '<th></th>';
                echo '<th>'."ID".'</th>';
                echo '<th>'."Name".'</th>';
                echo '<th>'."Total No".'</th>';
                echo '<th>'."Easy No".'</th>';
                echo '<th>'."Med No".'</th>';
                echo '<th>'."Hard No".'</th>';                
                echo '</thead><tbody>';
                foreach ($res as $val) {
                    echo '<tr>';
                    echo '<td><a class="btn btn-danger btn-small" href="scripts/editors.php?action=8&id='.$val['id'].'">Clear</a></td>';
                    echo '<td><a class="btn btn-danger btn-small" href="scripts/cat_del.php?id='.$val['id'].'">'.'Del'.'</a></td>';
                    echo '<td>'.$val['id'].'</td>';
                    echo '<td>'.$val['name'].'</td>';
                    echo '<td>'.$val['total_no'].'</td>';
                    echo '<td>'.$val['easy_no'].'</td>';
                    echo '<td>'.$val['med_no'].'</td>';
                    echo '<td>'.$val['hard_no'].'</td>';
                    echo '</tr>';
                    }
                echo '</tbody></table>';
                
                ?>
            </div>

            
        </div>
        </div>
    </body>
</html>
<?php $db = null; ?>