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
                
            <?php
            
            if(isset($_SESSION['edit_q']))
            {
                $sql = $db->prepare("SELECT * FROM quest WHERE id=".$_SESSION['edit_q']);
                $sql->execute();
                foreach($sql as $val)                    
                {
                    $q = $val['question'];
                    $a = $val['answer'];
                }
                
                echo '<div class="span12">';
                
                echo '<div style="text-align: center;"><form class="form-inline" action="scripts/editors.php?action=6" method="post">
                      <input type="text" name="q" value="' .$q.'" style="width:60%"/>
                      <input type="text" name="a" value="'.$a.'"/>
                      <input type="hidden" name="id" value="'.$_SESSION['edit_q']. ' "/>
                      <button class="btn" type="submit">Edit</button>
                      </form></div>';
                disp_cats($_SESSION['edit_q']);
                disp_diff($_SESSION['edit_q']);
                
                echo '</div>';
            }
            
            ?> 
                
                <div class="span12 well">
                    <div style="text-align: center;">
                        <form class="form-inline" action="scripts/session_set.php?action=2" method="post">
                            <input type="text" name="q_search" value="<?php if(isset($_SESSION['q_search'])) {echo $_SESSION['q_search'];}?>"/>
                            <button class="btn" type="submit">Search</button>                            
                        </form>
                    </div>
                
          
            <?php
            if(isset($_SESSION['q_search'])){   
            $sql = $db->query("SELECT * FROM quest");
            $sql->execute();

            echo '<table class="table table-condensed">';
                foreach ($sql as $val) {               
                    if(strpos($val['question'],$_SESSION['q_search']) == TRUE){
                echo "<tr>";
                echo '<td><a class="btn-xs btn-warning" href="scripts/editors.php?action=5&id='.$val['id'].'">Del</a></td>';
                echo '<td><a class="btn-xs btn-warning" href="scripts/session_set.php?action=1&id='.$val['id'].'" >Edit</a></td>';
                echo '<td>'.$val['id'].'</td>';
                echo '<td>'.$val['question'].'</td>';
                echo '<td>'.$val['answer'].'</td>';
                echo '<td>'.$val['cat_name'].'</td>';
                echo "</tr>";
                    }
                }
            echo '</table>';

            }else{
            
            $sql = $db->query("SELECT * FROM quest ORDER BY id ASC LIMIT ".(($_SESSION['edit_page']-1)*20).",20");
            $sql2 = $db->prepare("SELECT count(*) FROM quest");
            $sql2->execute();
            $count = $sql2->fetch(PDO::FETCH_NUM);
            
            echo '<div style="text-align: center;"><ul class="pagination">';
            
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
            
            echo '</ul></div>';
            echo '<table class="table table-condensed">';
                foreach ($sql as $val) {
                    echo "<tr>";
                    echo '<td><a class="btn-xs btn-warning" href="scripts/editors.php?action=5&id='.$val['id'].'" >Del</a></td>';
                    echo '<td><a class="btn-xs btn-warning" href="scripts/session_set.php?action=1&id='.$val['id'].'" >Edit</a></td>';
                    echo '<td>'.$val['id'].'</td>';
                    echo '<td>'.$val['question'].'</td>';
                    echo '<td>'.$val['answer'].'</td>';
                    echo '<td>'.$val['cat_name'].'</td>';
                    echo "</tr>";
                }
            echo '</table>';
            }
            ?>
                </div> 
            </div>
        </div>
    </body>
</html>

<?php
function disp_cats($id)
{
    $data = new PDO("sqlite:phpliteadmin/answerit.db");
    
    $sql = $data->prepare("SELECT * FROM quest WHERE id=".$id);
    $sql->execute();
    
    foreach($sql as $val)
    {
        $cat_id = $val['cat_id'];
    }
    
    $sql = $data->prepare("SELECT * FROM cats");
    $sql->execute();
    
    echo '<center><div class="btn_group">';
    
    foreach ($sql as $val) {
        if($val['id'] == $cat_id)
        {
           echo '<a class="btn-xs btn-success">'.$val['name'].'</a>'; 
        }  else {
           echo '<a class="btn-xs" href="scripts/editors.php?action=1&cat_id='.$val['id'].'&id='.$id.'">'.$val['name'].'</a>';
        }
    }
    echo '</div></center>';
    
    $data = null;
}

function disp_diff($id)
{
    $data = new PDO("sqlite:phpliteadmin/answerit.db");
    
    $sql = $data->prepare("SELECT * FROM quest WHERE id=".$id);
    $sql->execute();
    
    foreach($sql as $val)
    {
        $diff = $val['diff'];
    }
    
    $sql = array("Easy",'Medium',"Hard");
    
    echo '<center><div class="btn_group">';
    
    for($i = 0; $i < 3; $i++)
    {
        if($i+1 == $diff)
        {
           echo '<a class="btn btn-success">'.$sql[$i].'</a>'; 
        }  else {
           echo '<a class="btn" href="scripts/editors.php?action=2&diff='.($i+1).'&id='.$id.'">'.$sql[$i].'</a>';
        }

    }
    echo '</div></center>';
    
    $data = null;}

    ob_flush();
?>