<?php
    session_start();
    ob_start();
    $db = new PDO("sqlite:../phpliteadmin/questions.db");
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
        <br/>


                    <?php

    if(isset($_SESSION['mobile_added_id'])){

    }else{

    echo '
    <div class="row">
        <div class="col s12">
            <div class="card red">
                <div class="card-content white-text">';

                    $sql = $db->query("SELECT * FROM questions ORDER BY RANDOM() LIMIT 1");
                    foreach ($sql as $val){
                        echo '<span class="card-title">'.$val['category']."</span>";
                        echo "<p>".$val['question']."</p>";
                        echo "<h5>".$val['answer']."</h5>";
                        $id = $val['id'];
                    }
    echo '
        </div>
            <div class="card-action">
                <a class="btn white red-text" href="#">Delete</a>
                <a class="btn white red-text" href="scripts/import_q.php?id='.$id.'">Add</a>
            </div>
        </div>
    </div>

    </div>
                    ';
                    }



                    
                    ?>


        <div class="row">
            <div class="col s12">
                <div class="card red">
                    <div class="card-content">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Question" id="first_name" type="text" class="white-text">
                                </div>
                                <div class="input-field col s12">
                                    <input placeholder="Answer" id="last_name" type="text" class="white-text">
                                </div>
                                <div class="input-field col s12">
                                    <input id="submit" type="submit" class="btn col s12 white red-text">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>






        
    </body>
</html>