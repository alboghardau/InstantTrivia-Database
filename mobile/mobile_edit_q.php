<?php
session_start();
ob_start();

$id = $_GET['id'];
$db = new PDO("sqlite:../phpliteadmin/answerit.db");


$sql = $db->prepare("SELECT * FROM quest WHERE id=".$id);
$sql->execute();
foreach($sql as $val)
{
    $question = $val['question'];
    $answer = $val['answer'];
    $cat_id = $val['id'];
}

function disp_cats($id)
{
    $data = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $data->prepare("SELECT * FROM quest WHERE id=".$id);
    $sql->execute();

    foreach($sql as $val)
    {
        $cat_id = $val['cat_id'];
    }

    $sql = $data->prepare("SELECT * FROM cats");
    $sql->execute();

    echo '<center><div class="btn_group">';

    foreach ($sql as $val) {
        if($val['id'] == $cat_id)
        {
            echo '<a class="btn-floating btn-large orange">'.substr($val['name'],0,3).'</a>';
        }  else {
            echo '<a class="btn-floating btn-large blue" href="scripts/editors.php?action=1&cat_id='.$val['id'].'&id='.$id.'">'.substr($val['name'],0,3).'</a>';
        }
    }
    echo '</div></center>';

    $data = null;
}

function disp_diff($id){
    $data = new PDO("sqlite:../phpliteadmin/answerit.db");

    $sql = $data->prepare("SELECT * FROM quest WHERE id=".$id);
    $sql->execute();

    foreach($sql as $val)
    {
        $diff = $val['diff'];
    }

    $sql = array("Easy",'Medium',"Hard");

    echo '<center><div class="btn_group">';

    for($i = 0; $i < 3; $i++)
    {
        if($i+1 == $diff)
        {
            echo '<a class="btn-floating btn-large orange">'.substr($sql[$i],0,3).'</a>';
        }  else {
            echo '<a class="btn-floating btn-large blue" href="scripts/editors.php?action=2&diff='.($i+1).'&id='.$id.'">'.substr($sql[$i],0,3).'</a>';
        }

    }
    echo '</div></center>';

    $data = null;
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

    <div class="row">
        <div class="col s12">
            <div class="card red">
                <div class="card-content">
                    <form action="scripts/editors.php?action=3&id=<?php echo $id;?>" method="post" class="col s12">
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" name="question" value="<?php echo $question;?>" class="white-text"/>
                            </div>
                            <div class="input-field col s12">
                                <input type="text" name="answer" value="<?php echo $answer;?>" class="white-text" />
                            </div>
                            <div class="input-field">
                                <a class="btn col s6 white red-text" href="import_from_db.php">Exit</a>
                                <input type="submit" name="send" value="Edit" class="btn white red-text col s6"/>
                            </div>
                        </div>
                    </form>

                            <div class="row">
                                <?php disp_cats($cat_id);?>
                            </div>
                            <div class="row">
                                <?php disp_diff($cat_id);?>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    </body>
</html>

<?php
ob_flush();
?>