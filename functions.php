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
           echo '<a class="btn btn-success">'.$val['name'].'</a>'; 
        }  else {
           echo '<a class="btn" href="scripts/import_cat.php?cat_id='.$val['id'].'&id='.$id.'">'.$val['name'].'</a>';
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
           echo '<a class="btn" href="scripts/import_diff.php?diff='.($i+1).'&id='.$id.'">'.$sql[$i].'</a>';
        }

    }
    echo '</div></center>';
    
    $data = null;
}
?>
