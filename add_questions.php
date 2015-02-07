<?php
session_start();
$db = new PDO("sqlite:phpliteadmin/questions.db");
$ans = new PDO("sqlite:phpliteadmin/answerit.db");

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
            <div class="row"><center>
            
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
                
                echo '<div class="span12">';
                
                echo '<form class="form-inline" action="scripts/import_edit.php" method="post">
                      <input type="text" name="q" value="'.$q.'" style="width:60%"/>
                      <input type="text" name="a" value="'.$a.'"/>
                      <input type="hidden" name="id" value="'.$_SESSION['edit_q'].' "/>
                      <button class="btn" type="submit">Edit</button>
                      </form>';
                disp_cats($_SESSION['edit_q']);
                disp_diff($_SESSION['edit_q']);
                
                echo '</div>';
            }
            
            ?>      
                </center>
            <div class="span12 well">
        
                <center>
                    <form class="form-inline" method="post" action="scripts/session_set.php?action=5">
                        <input type="text" name="pg"/>
                        <button class="btn "type="submit">Set Page</button>
                    </form>
                    <form class="form-inline" method="post" action="scripts/session_set.php?action=3">
                        <input type="text" name="cat_search" value="<?php if(isset($_SESSION['cat_search'])) echo $_SESSION['cat_search'];?>"/>
                        <button class="btn" type="submit">Search Category</button>
                    </form>
                    
                </center>
                
                
            <?php 
            
            disp_cats_preset();
            disp_diff_preset();
            
            if(isset($_SESSION['cat_search'])) {
                $sql = $db->query("SELECT * FROM questions");                
                
                echo '<table class="table table-condensed">';
            foreach ($sql as $val) {
                if(strpos($val['category'], $_SESSION['cat_search']) == true || $val["category"] == $_SESSION['cat_search'])
                {
                echo "<tr>";
                echo '<td>'.$val['id'].'</td>';
                echo '<td>'.$val['category'].'</td>';
                echo '<td>'.$val['question'].'</td>';
                echo '<td>'.$val['answer'].'</td>';
                echo '<td><a class="btn-xs btn-success" href="scripts/import_q.php?id='.$val['id'].'">'."Add".'</a></td>';
                echo "</tr>";   
                }
            }
            echo '</table>';
                
            }else{     
            
            $sql = $db->query("SELECT * FROM questions ORDER BY id ASC LIMIT ".(($_SESSION['add_page']-1)*20).",20");
            
            $sql2 = $db->prepare("SELECT count(*) FROM questions");
            $sql2->execute();
            $count = $sql2->fetch(PDO::FETCH_NUM);
            
            echo '<center><ul class="pagination">';
            
            for($i = $_SESSION['add_page']-8; $i < $_SESSION['add_page']+8; $i++)
            {
                if($i > 0 && $i < $count[0]/20)
                {
                    if($_SESSION['add_page'] == $i)
                    {
                        echo '<li class="active"><a href="scripts/session_set.php?action=4&pg='.$i.'">'.$i."</a></li>"; 
                    }else
                    {
                       echo '<li><a href="scripts/session_set.php?action=4&pg='.$i.'">'.$i."</a></li>"; 
                    }                
                }
            }
            
            echo '</ul></center>';            
            
            echo '<table class="table table-condensed">';
            foreach ($sql as $val) {
                echo "<tr>";
                echo '<td>'.$val['id'].'</td>';
                echo '<td>'.$val['category'].'</td>';
                echo '<td>'.$val['question'].'</td>';
                echo '<td>'.$val['answer'].'</td>';
                echo '<td><a class="btn-xs btn-success" href="scripts/import_q.php?id='.$val['id'].'">'."Add".'</a></td>';
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

function disp_diff_preset()
{
        $data = new PDO("sqlite:phpliteadmin/answerit.db");
    
    $sql = array("Easy",'Medium',"Hard");
    
    echo '<center><div class="btn_group">';
    
    for($i = 0; $i < 3; $i++)
    {
        if(isset($_SESSION['preset_diff']) && $_SESSION['preset_diff'] == $i+1)
        {
           echo '<a class="btn btn-success">'.$sql[$i].'</a>'; 
        }  else {
           echo '<a class="btn" href="scripts/session_set.php?action=6&diff='.($i+1).'">'.$sql[$i].'</a>';
        }
    }
    echo '</div></center>';
    
    $data = null;
}

function disp_cats_preset()
{
    $data = new PDO("sqlite:phpliteadmin/answerit.db");
    
    $sql = $data->prepare("SELECT * FROM cats");
    $sql->execute();
    
    echo '<center><div class="btn_group">';
    
    foreach ($sql as $val) {
        if(isset($_SESSION['preset_cat']) && $_SESSION['preset_cat'] == $val['id'])
        {
           echo '<a class="btn-xs btn-success">'.$val['name'].'</a>'; 
        }  else {
           echo '<a class="btn-xs" href="scripts/session_set.php?action=7&cat_id='.$val['id'].'">'.$val['name'].'</a>';
        }

    }
    echo '</div></center>';
    
    $data = null;
}

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
           echo '<a class="btn-xs" href="scripts/editors.php?action=3&cat_id='.$val['id'].'&id='.$id.'">'.$val['name'].'</a>';
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
           echo '<a class="btn" href="scripts/editors.php?action=4&diff='.($i+1).'&id='.$id.'">'.$sql[$i].'</a>';
        }
    }
    echo '</div></center>';
    
    $data = null;
}

$db = null;
$ans = null;
ob_flush();
?>