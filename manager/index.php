<?php
session_start();
ob_start();
$db = new PDO("sqlite:../phpliteadmin/answerit.db");

$sql = $db->query("SELECT * FROM time_stamp");
foreach($sql as $val){
    $timeStamp = $val['time_stamp'];
}

$sql = $db->query("SELECT * FROM version");
foreach($sql as $val){
    $version = $val['number'];
}

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
                    <span class="card-title black-text">TimeStamp</span>
                    <p>Version:<?php echo $timeStamp?></p>
                    <p>Time:<?php echo $version?></p>
                    <form class="row col s12" action="scripts/editors.php?action=7" method="post">
                        <div class="input-field col s12">
                            <button class="btn col s12" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    </html>

<?php

ob_flush();

?>