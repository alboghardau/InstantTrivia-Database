<?php 
require_once 'functions.php';

    session_start();
    ob_start();
    $db = new PDO("sqlite:../phpliteadmin/answerit.db");
    if(!isset($_SESSION['edit_page'])) {$_SESSION['edit_page'] = 1;}
    
    
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
<html>
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
                
                echo '<div style="row"><form class="col s12" action="scripts/editors.php?action=6" method="post">
                        <div class="input-field col s6">
                            <input type="text" name="q" value="' .$q.'" style="width:60%"/>
                        </div>
                        <div class="input-field col s3">
                            <input type="text" name="a" value="'.$a.'"/>
                        </div>
                        <div class="input-field col s3">
                            <input type="hidden" name="id" value="'.$_SESSION['edit_q']. ' "/>
                            <button class="btn" type="submit">Edit</button>
                        </div>
                      </form></div><br/>';
                disp_cats($_SESSION['edit_q']);
                disp_diff($_SESSION['edit_q']);
                
                echo '</div></div></div>';
            }
        
        
        ?>
        
        
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
                    echo '<td><a class="btn-floating btn waves-effect waves-light red" href="scripts/editors.php?action=5&id='.$val['id'].'" ><i class="mdi-action-delete"></i></a></td>';
                    echo '<td><a class="btn-floating btn waves-effect waves-light orange" href="scripts/session_set.php?action=1&id='.$val['id'].'" ><i class="mdi-editor-border-color"></i></a></td>';
                    echo "</tr>";
                }
                echo '</table>';                   
        ?>                   
                </div>                
            </div>
        </div>




        
    </body>
</html>
