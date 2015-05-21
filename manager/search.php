<?php
session_start();
ob_start();
$db = new PDO("sqlite:../phpliteadmin/answerit.db");

if(!isset($_SESSION['search_filter'])) { $_SESSION['search_filter'] = 1;}

//TEST THE ANSWER WITH FILTER
function search($needle, $q ,$a ,$option)
{
    switch ($option){
        case 1:
            if(stripos($q,$needle) !==false) return true;
            if(stripos($a,$needle) !==false) return true;
            break;
        case 2:
            if(stripos($q,$needle) !==false) return true;
            break;
        case 3:
            if(stripos($a,$needle) !==false) return true;
            break;
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

</head>
    <body>

    <!--DISPLAY MENU-->
    <?php include 'menu.php'; ?>

    <!--    FILTER  -->
    <div class="row container">

            <div class=" center">
                <a class="btn" href="scripts/session_set.php?action=5&option=1">All</a>
                <a class="btn" href="scripts/session_set.php?action=5&option=2">Question</a>
                <a class="btn" href="scripts/session_set.php?action=5&option=3">Answer</a>
            </div>
    </div>


    <!--    FORM-->

    <div class="row container">
        <div class="card">
            <div class="card-content">
        <form class="row col s12" action="scripts/session_set.php?action=3" method="post">
            <div class="input-field col s10">
                <input type="text" name="search" value="<?php if(isset($_SESSION['search_term'])) echo $_SESSION['search_term']; ?>" />
            </div>

            <div class="input-field col s2">

                <button class="btn" type="submit">Search</button>
            </div>
        </form>
            </div>
        </div>
    </div>


    <!--DISPLAY TABLE-->
    <div class="row container">
        <div class="card">
            <div class="card-content">
                <?php
                $sql = $db->query("SELECT * FROM quest ORDER BY answer ASC");
                echo '<table class="bordered striped" >';
                foreach ($sql as $val) {
                    if(search($_SESSION['search_term'],$val['question'],$val['answer'],$_SESSION['search_filter']))
                    {
                        echo "<tr>";
                        echo '<td>' . $val['id'] . '</td>';
                        echo '<td>' . $val['question'] . '</td>';
                        echo '<td>' . $val['answer'] . '</td>';
                        echo '<td>' . $val['cat_name'] . '</td>';
                        echo '<td><a class="" href="scripts/editors.php?action=5&id=' . $val['id'] . '" ><i class="mdi-action-delete"></i></a></td>';
                        echo '<td><a class="" href="scripts/session_set.php?action=1&id=' . $val['id'] . '" ><i class="mdi-editor-border-color"></i></a></td>';
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
