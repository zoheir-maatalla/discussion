<?php
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Location: index.php");
        die;
    }

    extract($_SESSION["user"]);

    if (count($_POST) > 0) {
        $newInfo = &$_POST;

        if (isset($newInfo["password"]) && $newInfo["password"] != "") {
            if ($newInfo["password"] != $newInfo["passwordConfirm"]) {
                $error = "Le mot de passe que vous avez fourni ne correspond pas avec votre confirmation !";
            }
        } else {
            $newInfo["password"] = $password;
        }

        if (!isset($error)) {
            $db = new mysqli("localhost", "root", "", "discussion");

            try {
                $request = "UPDATE utilisateurs SET login = ?, password = ? WHERE login = ?;";
                $stmt = $db->prepare($request);
                $stmt->bind_param("sss", $newInfo["login"], $newInfo["password"], $login);
                $success = $stmt->execute();

                if ($success) {
                    $request = "SELECT * FROM utilisateurs WHERE login = ?;";
                    $stmt = $db->prepare($request);
                    $stmt->bind_param("s", $newInfo["login"]);
                    $stmt->execute();
                    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                    // Mise à jour de la session
                    $_SESSION["user"] = $results[0];
                    extract($_SESSION["user"]);
                }
            } catch (Exception $e) {
                echo "Exception reçue: {$e->getMessage()}";
                die;
            }
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
        <title>Profil</title>
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
            if (isset($success) && $success) {
                echo "<h4 class='success'>Modifications enregistrées avec  succès !</h4>";
            }
            ?>
            <form method="post">
            <div class="container">
                      <h2>Profil</h2>
  
                    <form action="/action_page.php">
                        <div class="form-group">
                        <label for="usr">Login:</label>
                        <input type="text" class="form-control" id="usr" name="username">
                        </div>
                        <div class="form-group">
                        <label for="pwd">Mot de passe:</label>
                        <input type="password" class="form-control" id="pwd" name="password">
                         </div>
                         <label for="pwd2"> Mot de passe (confirmation):</label>
                        <input type="password" class="form-control" id="pwd2" name="password">
                         
                        <button type="submit" class="btn btn-primary">S'inscrire</button>
                    </form>
                    </div>

        </main>
    </body>
</html>