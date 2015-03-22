<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css" type="stylesheet">
    </head>
        <body>

            <?php include("menu.php");?>

        <div class="container">
            <div class="row" style="text-align: center;">
                <div class="span12 well">


                    <?php
                    //Who played Tris in 'Divergent' movie?"

                    session_start();
                    disp_cats_preset();
                    disp_diff_preset();

                    function disp_diff_preset()
                    {
                        $data = new PDO("sqlite:phpliteadmin/answerit.db");

                        $sql = array("Easy",'Medium',"Hard");

                        echo '<center><div class="btn_group">';

                        for($i = 0; $i < 3; $i++)
                        {
                            if(isset($_SESSION['preset_diff']) && $_SESSION['preset_diff'] == $i+1)
                            {
                                echo '<a class="btn btn-success">'.$sql[$i].'</a>';
                            }  else {
                                echo '<a class="btn" href="scripts/session_set.php?action=8&diff='.($i+1).'">'.$sql[$i].'</a>';
                            }
                        }
                        echo '</div></center>';

                        $data = null;
                    }

                    function disp_cats_preset()
                    {
                        $data = new PDO("sqlite:phpliteadmin/answerit.db");

                        $sql = $data->prepare("SELECT * FROM cats");
                        $sql->execute();

                        echo '<center><div class="btn_group">';

                        foreach ($sql as $val) {
                            if(isset($_SESSION['preset_cat']) && $_SESSION['preset_cat'] == $val['id'])
                            {
                                echo '<a class="btn-xs btn-success">'.$val['name'].'</a>';
                            }  else {
                                echo '<a class="btn-xs" href="scripts/session_set.php?action=9&cat_id='.$val['id'].'">'.$val['name'].'</a>';
                            }

                        }
                        echo '</div></center>';

                        $data = null;
                    }

                    ?>

                    Example: Who played Tris in 'Divergent' movie?
                    <form method="post" action="scripts/movie_q1.php">
                        moviedb.org id<input type="text" name="id">
                        <input type="submit">
                    </form>



                </div>
            </div>
        </div>
    </body>
</html>