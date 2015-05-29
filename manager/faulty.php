<?php

session_start();
ob_start();
$db = new PDO("sqlite:../phpliteadmin/answerit.db");

?>


<!DOCTYPE html>
<html>
<head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

</head>

<body>


<?php include 'menu.php'; ?>


    <div class="row container">
        <div class="card">
            <div class="card-content">


        <?php

        $sql = $db->query("SELECT * FROM quest ORDER BY id ASC");
        echo '<table class="bordered striped" >';
        foreach ($sql as $val) {
            if(test_answer($val['answer'],$val['question']) == true) {
                echo "<tr>";
                echo '<td>' . $val['id'] . '</td>';
                echo '<td>' . $val['question'] . '</td>';
                echo '<td>' . $val['answer'] . '</td>';
                echo '<td>' . $val['cat_name'] . '</td>';
                echo '<td><a class="" href="scripts/editors.php?action=6&id=' . $val['id'] . '" ><i class="mdi-action-delete"></i></a></td>';
                echo "</tr>";
            }
        }
        echo '</table>';

        ?>

            </div>
        </div>
    </div>

</body>
</html>

<?php
function test_answer($answer,$question){
    $tester = false;

    if (strpos($question,'  ') != false) {
        return true;
    }
//        if (strpos($question,"?") == false){
//            return true;
//        }

    if(ctype_lower($answer)){
        return true;
    }

    $array = explode(" ", $answer);

    if(sizeof($array) > 2){
        return true;
    }
    foreach ($array as $key => $value){
        if(strlen($value) > 10){
            return true;
        }
    }
}

ob_flush();
?>