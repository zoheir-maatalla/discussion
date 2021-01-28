<?php
    session_start();

    if (isset($_SESSION["user"])) {
        header("Location: index.php");
        die;
    }

    if (count($_POST) > 0) {
        extract($_POST);

        $db = new mysqli("localhost", "root", "", "discussion");

        $request = "SELECT * FROM utilisateurs WHERE login = ?;";
        $stmt = $db->prepare($request);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        if (count($results) > 0 && password_verify($password, $results[0]["password"])) {
            $_SESSION["user"] = $results[0];
            if (isset($_GET["from"])) {
                header("Location: {$_GET['from']}.php");
            } else {
                header("Location: index.php");
            }
            die;
        } else {
            $error = "Mot de passe incorrect !";
        }
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <title>Connexion</title>
    </head>

    <body>
        <header>
            
            <a href="index.php">Retour</a>
        </header>
        <main>
            
            <?php
            if (isset($error)) {
                echo "<h4 class='error'>$error</h4>";
            }
            ?>
            <div class="container">
              <h2> Conexion </h2>
            <form method="post">
                    <div class="form-group">
                    <label for="login">login:</label>
                    <input type="text" class="form-control" id="login" name="login">
                    </div>
                    <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary"> Se connecter</button>
                </form>
                
                
            
        </main>
    </body>
</html>