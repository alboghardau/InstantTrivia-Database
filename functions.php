<?php



function test_chars($answer)
{
    
    $allowed = range("A","Z");
    array_push($allowed, " ");
    $ret = true;
    $input = str_split($answer);

    foreach ($input as $letter) {
        if(!in_array($letter, $allowed) ){
            $ret = false;
        }        
    }
    //var_dump($ret);
    return $ret;

}

?>
