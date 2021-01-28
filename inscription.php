<?php
    session_start();

    if (isset($_SESSION["user"])) {
        header("Location: index.php");
        die;
    }

    if (count($_POST) > 0) {
        extract($_POST);

        if ($password == $passwordConfirm) {
            $db = new mysqli("localhost", "root", "", "discussion");

            $request = "SELECT * FROM utilisateurs WHERE login = ?";
            $stmt = $db->prepare($request);
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            if (count($results) < 1) {
                $request = "INSERT INTO utilisateurs (login, password) VALUES (?, ?);";
                try {
                    $stmt = $db->prepare($request);
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->bind_param("ss", $login, $hashed);
                    $success = $stmt->execute();
                } catch (Exception $e) {
                    echo "Exception reçue: {$e->getMessage()}";
                    die;
                }
            } else {
                $error = "Cet utilisateur existe déjà !";
            }
        } else {
            $error = "Le mot de passe que vous avez fourni ne correspond pas avec votre confirmation !";
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
         <title>Inscription</title>
    </head>

    <body>
        <header>
           
            <a href="index.php"> Retour</a>
        </header>
        
            
            <?php
            if (isset($error)) {
                echo "<h4 class='error'>$error</h4>";
            }
            if (isset($success) && $success) {
                echo "<h4 class='success'>Compte créé avec succès ! Vous pouvez dorénavant vous connecter...<br>Vous allez être redirigé dans 5 secondes...</h4>";
                header("Refresh: 5; URL=/connexion.php");
            } else { ?>
                <form method="post">

                <div class="container">
                      <h2>Inscprition </h2>
  
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


                 <?php
            }
            ?>
        </main>
    </body>
</html>