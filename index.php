<?php
    session_start();

    if (isset($_SESSION["user"])) {
        extract($_SESSION["user"]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Accueil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="container">
  <h1 class ="title" Discussion </h1>
              
  <img src="img/2.jpg" class="rounded" alt="Cinque Terre" width="800" height="500"> 
</div>
<div class="container p-3 my-3 bg-primary text-white">
<h2>Bienvenue <?= isset($login) ? ($login . ' ') : ' ' ?>!</h2>
        <p>Que souhaitez-vous faire ?</p>
  
</div>
<div class="buttons">


            <?php
                if (!isset($_SESSION["user"])) {
                    echo '<a href="inscription.php"><button type="button" class="btn btn-outline-secondary"> Inscprition</button></a>';
                    echo '<a href="connexion.php"> <button type="button" class="btn btn-outline-primary"> Conexion</button></a>';
                } else {
                    echo '<a href="discussion.php">Discussion</a>';
                    echo '<a href="profil.php">Profil</a>';
                    echo '<a href="deconnexion.php">Déconnexion</a>';
                }
            ?>




 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>