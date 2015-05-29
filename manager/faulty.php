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
            echo "<tr>";
            echo '<td>'.$val['id'].'</td>';
            echo '<td>'.$val['question'].'</td>';
            echo '<td>'.$val['answer'].'</td>';
            echo '<td>'.$val['cat_name'].'</td>';
            echo '<td><a class="" href="scripts/editors.php?action=4&id='.$val['id'].'" ><i class="mdi-action-delete"></i></a></td>';
            echo '<td><a class="" href="scripts/session_set.php?action=1&id='.$val['id'].'" ><i class="mdi-editor-border-color"></i></a></td>';
            echo "</tr>";
        }
        echo '</table>';

        ?>

            </div>
        </div>
    </div>




</body>
</html>