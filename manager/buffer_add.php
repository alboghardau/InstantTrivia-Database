<?php

session_start();
ob_start();
$db = new PDO("sqlite:../phpliteadmin/answerit.db");

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
        <div class="card-content">

            <?php

            $sql = $db->query("SELECT * FROM question_buffer ORDER BY id ASC");

            echo '<table class="table table-condensed">';
            foreach ($sql as $val) {
                echo "<tr>";
                echo '<td>'.$val['id'].'</td>';
                echo '<td>'.$val['question'].'</td>';
                echo '<td>'.$val['answer'].'</td>';
                echo '<td><a class="btn-xs btn-danger" href="scripts/editors.php?action=14&id='.$val['id'].'">'."Del".'</a></td>';
                echo '<td><a class="btn-xs btn-success" href="scripts/import_q_buff.php?id='.$val['id'].'">'."Add".'</a></td>';
                echo "</tr>";
            }
            echo '</table>';

            ?>

        </div>
    </div>
</div>





</body>
</html>

<?php
ob_flush();
?>