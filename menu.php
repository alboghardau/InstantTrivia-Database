   <?php
   
   $db3 = new PDO("sqlite:phpliteadmin/answerit.db");
   
   $s = $db3->prepare("SELECT count(*) FROM quest");
   $s->execute();
   $result = $s->fetch(PDO::FETCH_NUM);
   $db3 = null;
   
   
   
   ?>
   


<div class="bs-component" >
            <div class="navbar-inverse">
                <div class="navbar-collapse collapse navbar-inverse-collapse">
                  
                    
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="add_questions.php">Import Questions</a></li>
                        <li><a href="edit_question.php">Edit Questions</a>
                        <li><a href="categories.php">Categories</a></li>
                        <li><a href="phpliteadmin/phpliteadmin.php">PHPLiteAdmin</a></li>
                        
                        <li><a href="#"><?php 
                        
                        echo $result[0];
           ?> </a></li>
                    </ul>                   
                </div>
            </div>
        </div>


 
