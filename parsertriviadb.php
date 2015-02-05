<?php
set_time_limit(6000);
$db = new PDO('sqlite:phpliteadmin/questions2.db');

for ($i = 1; $i <= 14; $i++)
{
   

$txt_file    = file_get_contents('b0'.$i.'.txt');
$rows        = explode("\n", $txt_file);
array_shift($rows);

$db->exec("BEGIN IMEDIATE TRANSACTION");

foreach($rows as $row => $data)
{
    //get row data
    $row_data = explode(':', $data);         

    $cat = $row_data[0];
    //$cat = trim($cat, ":");
    
    
    
    $question = stristr($data, ": ");
    $question = trim($question, ": ");
    $question = str_replace('"',"'",$question);
    $answer = stristr($question, "*");
    
    if($answer == ""){
        $answer = stristr($cat, "*");
        $question = substr($cat, 0 ,  strpos($cat, "*"))."?";   
        $question = str_replace('"',"'",$question);
        $cat = "";
        
        $answer = trim($answer,"*");    
    }else{
            $question = substr($question, 0 ,  strpos($question, "*"))."?";   
    }
 
    //if($question == "?") $question = $row_data[0];    
    
    if($cat == "How Many") $question = "How many ".lcfirst ($question);
    
    
    $answer = trim($answer,"*");        

    //display data
    //echo 'Row ' . $row . ' Cat: ' . $info[$row]['category'] . '<br />';
    echo $data. '<br/>';
    echo "CAT:".$cat. '<br/>';
    echo "QST:".$question. '<br/>';
    echo "ANS:".$answer. '<br/>';

    if($question != "?"){    
    //$db->exec('INSERT INTO questions ("id","category","question","answer") VALUES (NULL,"'.$cat.'","'.$question.'","'.$answer.'")');
    //var_dump($db->errorInfo());
    }


    echo '<br />';
}

$db->exec("COMMIT TRANSACTION");
}

?>

