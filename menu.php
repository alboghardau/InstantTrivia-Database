   <?php
   
   $db3 = new PDO("sqlite:phpliteadmin/answerit.db");
   
   $s = $db3->prepare("SELECT count(*) FROM quest");
   $s->execute();
   $result = $s->fetch(PDO::FETCH_NUM);
   $db3 = null;
   
   
   
   ?>
   


<div class="navbar navbar-static-top" >
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand">Answer It Trivia Database Editor</a>
                    <ul class="nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="add_questions.php">Import Q</a></li>
                        <li><a href="categories.php">Categories</a></li>
                        <li><a href="tests.php">Tests</a></li>
                        <li><a href="phpliteadmin/phpliteadmin.php">PHPLiteAdmin</a></li>
                        <li><a href="scripts/generate_tests.php">Create tests</a></li>
                        <li><a href="#"><?php 
                        
                        echo $result[0];
           ?> </a></li>
                    </ul>                   
                </div>
            </div>
        </div>


 
