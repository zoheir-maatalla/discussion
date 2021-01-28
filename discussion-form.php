<?php
session_start();
$connexion = mysqli_connect("localhost", "root","", "discussion");


if(isset($_POST["submit"]))
{
    //On récupère les données du formulaire
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $debut = $_POST["debut"];
    $fin = $_POST["fin"];
    $id_utilisateur = $_SESSION['id'];

    //Préparation de la requête SQL pour ajouter le commentaire à la bdd
    $insert="INSERT INTO messages (id, message, id_utilisateur, date) VALUES (NULL, \"$mes\",\"$id_utilisateur\",date)";

    //Execution de la requête SQL pour màj les données dans la bdd
    $query_update=mysqli_query($connexion,$insert);
    header("Location: discussion.php");
}
    

mysqli_close($connexion);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Formulaire de discussion</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Permanent+Marker&display=swap" rel="stylesheet">
    </head>

<body>
    <?php include("header.php"); ?>
<main>
 


<h1>Formulaire de discussion</h1>

<form method ="POST">
    <label for="titre">Titre de votre réservation :</label>
    <input type="text" placeholder="Titre" id="titre" name="titre" required>

    <label for="password">Description :</label>
    <input type="text" placeholder = "Entrez une description"  id = "description" name="description" required>
    
    <label for="debut"> Heure de début :</label>
    <input type="datetime-local"  placeholder = "" id = "debut" name="debut" required>
    
    <label for="fin"> Heure de fin :</label>
    
    <input type="datetime-local" placeholder = "" id = "fin" name="fin" required>
    <input type="submit" name = "submit"> 
</form>


</main>
<?php include("footer.php"); ?>



</body>
</html>
