<?php
    require_once './dbconfig.php';
    session_start();
    if (isset($_SESSION['email'])) {
        header("Location: ./index.php");
        exit();
    }

    if(!empty($_POST["email"]) && !empty($_POST["password"])) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $query = "SELECT * FROM Utente WHERE Mail = '".$email."'";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if(mysqli_num_rows($res) > 0)
        {
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($password, $entry['Psw'])) {
                $_SESSION["email"] = $_POST["email"];
                header("Location: ./index.php");
                exit;
            }
            else
            {
                $errore = "Credenziali non corrette.";
            }
        }
        else
        {
            $errore = "Utente sconosciuto.";
        }

        mysqli_free_result($res);
        mysqli_close($conn);
    }else if (isset($_POST["email"]) || isset($_POST["password"])) {
        $error = "Inserisci username e password.";
    }
?>

<html>
<head>
    <title>Accedi | Ticketmaster</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/auth.css">
    <script src="./scripts/footer.js" defer></script>
    <link rel="stylesheet" type="text/css" href="./styles/nav.css">
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
    <link rel="stylesheet" type="text/css" href="./styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <?php include './blocks/topslim.php'; ?>

    <section id="main">
        <?php
            if (isset($errore)) {
                echo '<h4 id="error" class="error">' . $errore . '</h4>';
            } else {
                echo '<h4 id="error" class="error hidden"></h4>';
            }
        ?>
        <form name="login" method="post">
            <h2>Login</h2>
            <p class="margin-bottom">Non ancora registrato?&nbsp;
                <a href="./register.php">Registrati</a>
            </p>
            <div class="input-container">
                <div class="input-grouped">
                    <div class="input-field">
                        <label for="email">Email</label>
                        <input id="email" name="email" required="required" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?> type="email">
                    </div>
                    <div class="input-field">
                        <label for="password" >Password&nbsp;
                            <a class="recovery" href="#">Recupera</a>
                        </label>
                        <input id="password" name="password" required="required" value="" type="password">
                    </div>
                </div>                 
                <label class="margin-bottom">
                    <input type="checkbox" name="ricordami" value="ricordami"/>
                    Ricordami
                </label>
                <input class="button-submit margin-bottom-double" value="Accedi" name="submit_btn" type="submit">
            </div>
        </form>
    </section>

    <?php include './blocks/bottom.php'; ?>
</body>
</html>        