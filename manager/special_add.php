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
            <p>Question format here.</p>
            <form class="row col s12" action="scripts/q1_movie.php" method="post">
                <div class="input-field col s10">
                    <input type="text" name="id"/>
                </div>
                <div class="input-field col s2">
                    <button class="btn" type="submit">Add</button>
                </div>
                </form>
            </form>
        </div>
    </div>
</div>





</body>
</html>
