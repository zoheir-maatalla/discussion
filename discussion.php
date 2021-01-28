<?php
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Location: connexion.php");
        die;
    }

    extract($_SESSION["user"]);
    extract($_POST);

    $db = new mysqli("localhost", "root", "", "discussion");

    if (isset($message)) {
        $request = "INSERT INTO messages (message, id_utilisateur, date) VALUES (?, ?, NOW())";
        $stmt = $db->prepare($request);
        $stmt->bind_param("ss", $message, $id);
        $stmt->execute();

        header("Location: discussion.php");
        die;
    }

    $request = "SELECT * FROM messages";
    $query = $db->query($request);
    $result = $query->fetch_all(MYSQLI_ASSOC);

    function getUsername($id) {
        global $db;

        $request = "SELECT login FROM utilisateurs WHERE id = ?";
        $stmt = $db->prepare($request);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all();

        return $result["0"]["0"];
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
    <title>Discussion</title>
</head>
<body>
    <header>
        <h1>Discussion</h1>
        <a href="index.php">Retour</a>
    </header>
    <main>
        <?php
        foreach ($result as $message) {
            ?>
            <div class="message">
                <div>
                    <span class="username"><?= getUsername($message["id_utilisateur"]) ?></span>
                    <span class="date"><?= $message["date"] ?></span>
                </div>
                <div class="content"><?= $message["message"] ?></div>
            </div>
            <?php
        }
        ?>
        <form method="post">
            <label>Poster un message en tant que "<i><?= $_SESSION["user"]["login"] ?></i>":</label>
            <br/>
            <textarea name="message" style="width: 100%; min-height: 64px;"></textarea>
            <input type="submit" value="Envoyer">
        </form>
    </main>
</body>
</html>