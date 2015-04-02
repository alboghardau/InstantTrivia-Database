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



                    ?>
                    Question/Answer
                    <form method="post" action="scripts/editors.php?action=11">
                        <input type="text" name="question">
                        <input type="text" name="answer">
                        <input type="submit"/>
                    </form>


                    <br/>
                    Example: Who played Tris in 'Divergent' movie?  / Which character was played by Angelina Jolie in 'Maleficent" movie?
                    <form method="post" action="scripts/movie_q1.php">
                        moviedb.org id <input type="text" name="id">
                        <input type="submit">
                    </form>



                </div>
            </div>
        </div>
    </body>
</html>