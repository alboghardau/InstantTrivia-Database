<?php

session_start();
ob_start();

$file = fopen("../songs.csv","r");
$row = 0;
while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    $num = count($data);
    $row++;
    echo "Which $data[1] $data[2] recorded the song $data[4] in $data[3]? ".strtoupper($data[0])."<br/>";
    echo "What music genre was the song $data[4] by $data[0]? ".strtoupper($data[1])."<br/>";
    echo "Which album by the $data[1] $data[2] $data[0] had the song $data[4]? ".strtoupper($data[5])."<br/>";
}

fclose($file);

?>