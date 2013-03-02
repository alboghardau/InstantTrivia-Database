<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap-responsive.css" type="stylesheet">
    </head>
    <body>

        
        <div class="navbar navbar-static-top" >
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand">Answer It Trivia Database Editor</a>
                    <ul class="nav">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../categories.php">Categories</a></li>
                        <li><a href="../tests.php">Tests</a></li>
                        <li><a href="../phpliteadmin/phpliteadmin.php">PHPLiteAdmin</a></li>                        
                    </ul>                   
                </div>
            </div>
        </div>

        <div class="container">
        <div class="row">

            <div class="span12 well">

<?php
session_start();
ob_start();

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $starttime = $mtime; 

$db = new PDO("sqlite:../phpliteadmin/answerit.db");

//reset tests
//$sql = $db->prepare("DELETE FROM tests");
//$sql->execute();
//
//resete test_id in quest table
//$sql = $db->prepare("UPDATE quest SET test_id=0");
//$sql->execute();


$query_1 = $db->query("SELECT * FROM cats");

$updates_cont = 0;

foreach ($query_1 as $val) {
    echo $val['id']." / ";
    
    //reset arrays
    $easy = null;
    $med = null;
    $hard = null;
    
    $c1 = 0;
    $query_2 = $db->query("SELECT * FROM quest WHERE diff=1 AND cat_id=".$val['id']);
    foreach ($query_2 as $val2) {
        if($val2['test_id'] == 0)
        {
        $easy[$c1] = $val2['id'];
        $c1++;
        }
    }
    
    echo "Easy:".floor(sizeof($easy)/10);
    
    if($easy != NULL)
    {
        for($i = 0; $i<floor(sizeof($easy)/10);$i++)
        {            
            //create test
            $sql = $db->prepare("INSERT INTO tests (cat_id,diff) VALUES (".$val['id'].",1)");
            $sql->execute();
            //get last id added
            
            $sql = $db->prepare("SELECT * FROM tests ORDER BY id DESC LIMIT 1");
            $sql->execute();
            foreach ($sql as $value) {
                $test_id = $value[0];
            }            
            
            for($j = $i*10; $j < ($i+1)*10; $j++)
            {
            $updates[$updates_cont] = "UPDATE quest SET test_id=".$test_id." WHERE id=".$easy[$j];
            $updates_cont++;   
            }
        }
    }
    
        $c2 = 0;
        $query_2 = $db->query("SELECT * FROM quest WHERE diff=2 AND cat_id=".$val['id']);
        foreach ($query_2 as $val2) {
            if($val2['test_id'] == 0)
            {
            $med[$c2] = $val2['id'];
            $c2++;
            }
    }
    
        echo " Medium:".floor(sizeof($med)/10);
        
            if($med != NULL)
    {
        for($i = 0; $i<floor(sizeof($med)/10);$i++)
        {            
            //create test
            $sql = $db->prepare("INSERT INTO tests (cat_id,diff) VALUES (".$val['id'].",2)");
            $sql->execute();
            //get last id added
            
            $sql = $db->prepare("SELECT * FROM tests ORDER BY id DESC LIMIT 1");
            $sql->execute();
            foreach ($sql as $value) {
                $test_id = $value[0];
            }            
            
            for($j = $i*10; $j < ($i+1)*10; $j++)
            {            
            $updates[$updates_cont] = "UPDATE quest SET test_id=".$test_id." WHERE id=".$med[$j];
            $updates_cont++;          
            }
        }
    }
        
        $c3 = 0;
        $query_2 = $db->query("SELECT * FROM quest WHERE diff=3 AND cat_id=".$val['id']);
        foreach ($query_2 as $val2) {
        if($val2['test_id'] == 0)
        {
        $hard[$c3] = $val2['id'];
        $c3++;
        }
    }
    
        echo " Hard:".floor(sizeof($hard)/10);
        
            if($med != NULL)
    {
        for($i = 0; $i<floor(sizeof($hard)/10);$i++)
        {            
            //create test
            $sql = $db->prepare("INSERT INTO tests (cat_id,diff) VALUES (".$val['id'].",3)");
            $sql->execute();
            //get last id added
            
            $sql = $db->prepare("SELECT * FROM tests ORDER BY id DESC LIMIT 1");
            $sql->execute();
            foreach ($sql as $value) {
                $test_id = $value[0];
            }

            for($j = $i*10; $j < ($i+1)*10; $j++)
            {      
            $updates[$updates_cont] = "UPDATE quest SET test_id=".$test_id." WHERE id=".$hard[$j];
            $updates_cont++;
            }
        }
    }
    
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo " / ".round($totaltime,2)." seconds";  
    
    echo "<br/>";
    //var_dump($easy);
}

    $db->beginTransaction();
   foreach($updates as $upd)
   {
       $db->query($upd);
   }
    $db->commit();

   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "<br/>This page was created in ".round($totaltime,2)." seconds"; 

$db = null;
$db2 = null;
   
ob_flush();


?>
            </div>
        </div>
        </div>
            </body>
</html>