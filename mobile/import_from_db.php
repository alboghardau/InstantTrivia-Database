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
        <div class="row container">
            <div class="card">
                <div class="card-content red white-text">

                    <?php
                    
                     $sql = $db->query("SELECT * FROM questions ORDER BY RANDOM() LIMIT 1");
                     foreach ($sql as $val){
                         echo '<span class="card-title">'.$val['category']."</span>";
                         echo "<p>".$val['question']."</p>";
                         echo "<h5>".$val['answer']."</h5>";
                         
                     }
                    
                    ?>
              <div class="card-action">
              <a class="btn white" href="#">Delete</a>
              <a class="btn white" href='#'>Add</a>
            </div>
            </div>
        </div>

      <div class="row">
        <div class="col s12 m6">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">Card Title</span>
              <p>I am a very simple card. I am good at containing small bits of information.
              I am convenient because I require little markup to use effectively.</p>
            </div>
            <div class="card-action">
              <a href="#">This is a link</a>
              <a href='#'>This is a link</a>
            </div>
          </div>
        </div>
      </div>


        
    </body>
</html>