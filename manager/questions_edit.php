<?php
    session_start();
    ob_start();
    $db = new PDO("sqlite:../phpliteadmin/answerit.db");
    if(!isset($_SESSION['edit_page'])) {$_SESSION['edit_page'] = 1;}


    function disp_cats($id)
    {
        $data = new PDO("sqlite:../phpliteadmin/answerit.db");

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
                echo '<a class="btn yellow black-text">'.$val['name'].'</a>';
            }  else {
                echo '<a class="btn teal" href="scripts/editors.php?action=1&cat_id='.$val['id'].'&id='.$id.'">'.$val['name'].'</a>';
            }
        }
        echo '</div></center>';

        $data = null;
    }

    function disp_diff($id){
        $data = new PDO("sqlite:../phpliteadmin/answerit.db");

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
                echo '<a class="btn yellow black-text">'.$sql[$i].'</a>';
            }  else {
                echo '<a class="btn teal" href="scripts/editors.php?action=2&diff='.($i+1).'&id='.$id.'">'.$sql[$i].'</a>';
            }

        }
        echo '</div></center>';

        $data = null;
    }
    
?>

  <!DOCTYPE html>
  <html>
    <head>
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

              <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

    </head>

    <body>
 
        
        <?php include 'menu.php'; ?>
        
        <!--DISPLAY EDITOR--> 
        <?php
        
        if(isset($_SESSION['edit_q'])){
                $sql = $db->prepare("SELECT * FROM quest WHERE id=".$_SESSION['edit_q']);
                $sql->execute();
                foreach($sql as $val){
                    $q = $val['question'];
                    $a = $val['answer'];
                }
                
        echo '        
        <br/>
        <div class="row container">
            <div class="card">
                <div class="card-content"> ';
                
                echo '<div style="row">
                    <form class="row col s12" action="scripts/editors.php?action=3" method="post">
                        <div class="input-field col s8">
                            <input type="text" name="question" value="' .$q.'" style="width:60%"/>
                        </div>
                        <div class="input-field col s2">
                            <input type="text" name="answer" value="'.$a.'"/>
                        </div>
                        <div class="input-field col s1">
                            <input type="hidden" name="id" value="'.$_SESSION['edit_q']. ' "/>
                            <button class="btn" type="submit">Edit</button>
                        </div>
                    </form></div><br/>';
                disp_cats($_SESSION['edit_q']);
                disp_diff($_SESSION['edit_q']);
                
                echo '</div></div></div>';
            }
        
        
        ?>
        
        <!--PAGINATION-->
<div class="row container">
    <div class="center">
        <?php

        $sql = $db->query("SELECT * FROM quest ORDER BY id ASC LIMIT ".(($_SESSION['edit_page']-1)*20).",20");
        $sql2 = $db->prepare("SELECT count(*) FROM quest");
        $sql2->execute();
        $count = $sql2->fetch(PDO::FETCH_NUM);

        echo '<ul class="pagination">';

        for($i = $_SESSION['edit_page']-8; $i < $_SESSION['edit_page']+8; $i++)
        {
            if($i > 0 && $i < $count[0]/20)
            {
                if($_SESSION['edit_page'] == $i)
                {
                    echo '<li class="active"><a href="scripts/session_set.php?action=2&pg='.$i.'">'.$i."</a></li>";
                }else
                {
                    echo '<li class="waves-effect"><a href="scripts/session_set.php?action=2&pg='.$i.'">'.$i."</a></li>";
                }
            }
        }

        echo '</ul>';

        ?>
    </div>
</div>


        <!--DISPLAY TABLE-->
    <div class="row container">
        <div class="card">
            <div class="card-content">
        <?php 
                $sql = $db->query("SELECT * FROM quest ORDER BY id ASC LIMIT ".(($_SESSION['edit_page']-1)*20).",20");
                echo '<table class="bordered striped">';
                foreach ($sql as $val) {
                    echo "<tr>";
                    echo '<td>'.$val['id'].'</td>';
                    echo '<td>'.$val['question'].'</td>';
                    echo '<td>'.$val['answer'].'</td>';
                    echo '<td>'.$val['cat_name'].'</td>';
                    echo '<td><a class="btn-floating btn waves-effect waves-light red" href="scripts/editors.php?action=4&id='.$val['id'].'" ><i class="mdi-action-delete"></i></a></td>';
                    echo '<td><a class="btn-floating btn waves-effect waves-light teal" href="scripts/session_set.php?action=1&id='.$val['id'].'" ><i class="mdi-editor-border-color"></i></a></td>';
                    echo "</tr>";
                }
                echo '</table>';                   
        ?>                   
            </div>
        </div>
    </div>




        
    </body>
</html>
