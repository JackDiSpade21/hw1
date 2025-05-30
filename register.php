<?php
    require_once './dbconfig.php';
    session_start();
    if (isset($_SESSION['email'])) {
        header("Location: ./index.php");
        exit();
    }

    $error = array();

    if (
        !empty($_POST['email']) &&
        !empty($_POST['confirmEmail']) &&
        !empty($_POST['password']) &&
        !empty($_POST['confirmPassword']) &&
        !empty($_POST['numberPrefix']) &&
        !empty($_POST['number']) &&
        !empty($_POST['name']) &&
        !empty($_POST['surname']) &&
        !empty($_POST['birth']) &&
        !empty($_POST['privacy']) &&
        !empty($_POST['terms']) &&
        isset($_POST['birthPlace'])
    ) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $confirmEmail = mysqli_real_escape_string($conn, $_POST['confirmEmail']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
        $numberPrefix = mysqli_real_escape_string($conn, $_POST['numberPrefix']);
        $number = mysqli_real_escape_string($conn, $_POST['number']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $birth = mysqli_real_escape_string($conn, $_POST['birth']);
        $birthPlace = mysqli_real_escape_string($conn, $_POST['birthPlace']);
        $newsletter = isset($_POST['newsletter']) ? 1 : 0;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $res = mysqli_query($conn, "SELECT Mail FROM Utente WHERE Mail = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "L'email inserita è già in uso.";
            }
        }

        if ($email !== $confirmEmail) {
            $error[] = "Le email non corrispondono";
        }

        if (strlen($password) < 8 || strlen($password) > 32) {
            $error[] = "La password deve essere tra 8 e 32 caratteri";
        } else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,32}$/', $password)) {
            $error[] = "La password deve rispettare i requisiti indicati.";
        }

        if ($password !== $confirmPassword) {
            $error[] = "Le password non corrispondono";
        }

        if ($_POST['privacy'] !== "agreePrivacy") {
            $error[] = "Devi accettare l'informativa sulla privacy";
        }
        if ($_POST['terms'] !== "agreeTerms") {
            $error[] = "Devi accettare i termini e le condizioni";
        }

        if (strlen($number) < 9) {
            $error[] = "Numero di telefono non valido";
        } elseif (!preg_match('/^[0-9]{9,20}$/', $number)) {
            $error[] = "Il numero di telefono deve contenere solo cifre";
        }

        if (
            $numberPrefix !== "+39" &&
            $numberPrefix !== "+1" &&
            $numberPrefix !== "+44" &&
            $numberPrefix !== "+49" &&
            $numberPrefix !== "+33" &&
            $numberPrefix !== "+34"
        ) {
            $error[] = "Prefisso non valido";
        }

        $today = new DateTime();
        $birthDate = DateTime::createFromFormat('Y-m-d', $birth);
        if ($birthDate) {
            $age = $today->diff($birthDate)->y;
            if ($age < 18) {
                $error[] = "L'età deve essere compresa tra 18 e 100 anni";
            } else if ($age > 100) {
                $error[] = "Data di nascita non valida";
            }
        } else {
            $error[] = "Data di nascita non valida";
        }

        if (count($error) == 0) {
            if($birthPlace !== ""){
                $birthPlace = "'$birthPlace'";
            } else {
                $birthPlace = "NULL";
            }

            $password = password_hash($password, PASSWORD_BCRYPT);

            $queryInsert = "INSERT INTO Utente (Mail, Psw, Tel, Nome, Cognome, Nascita, Luogo, Newsletter) 
                VALUES ('$email', '$password', '$numberPrefix$number', '$name', '$surname', '$birth', $birthPlace, '$newsletter')";

            if (mysqli_query($conn, $queryInsert)) {
                $_SESSION["email"] = $_POST["email"];
                mysqli_close($conn);
                header("Location: ./profile.php?firstLogin=true");
                exit();
            } else {
                $error[] = "Si è verificato un errore durante la registrazione. Riprova.";
            }
        }

        mysqli_close($conn);
    } else if (isset($_POST['email'])) {
        $error[] = "Riempi tutti i campi obbligatori";
    }
?>

<html>
<head>
    <title>Registrati | Ticketmaster</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/auth.css">
    <script src="./scripts/footer.js" defer></script>
    <script src="./scripts/auth.js" defer></script>
    <link rel="stylesheet" type="text/css" href="./styles/nav.css">
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
    <link rel="stylesheet" type="text/css" href="./styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div id="languages">
            <img id="flag"src="./icons/italy.png"></img>
            <a href="#">IT</a>
            <img src="./icons/lang.png"></img>
            <a href="#">IT</a>
        </div>
    </header>
    <nav class="nav-auth">
        <div id="left-navbar">
            <a href="./index.php" class="logo">
                <img src="./icons/logo.png">
            </a>
        </div>
    </nav>

    <section id="main">
        <h4 id="error" 
            <?php 
            if (count($error) > 0) { 
                echo 'class="error"'; 
            } else { 
                echo 'class="error hidden"'; 
            }
            ?>>
            <?php
                foreach($error as $err) {
                    echo $err . "<br>";
                }
            ?>
        </h4>

        <form name="register" method="post">
            <h2>Sei un nuovo utente</h2>
            <p class="margin-bottom">Già registrato?&nbsp;
                <a href="./login.php">Accedi</a>
            </p>
            <div class="input-container">
                <h4>Dati di autenticazione</h4>
                <p class="p-subtitle italic margin-bottom">Se non l'hai ancora fatto, ti ricordiamo che 
                    è necessario convalidare il tuo numero di cellulare utilizzando il codice di conferma 
                    OTP che ti verrà inviato tramite SMS
                </p>
                <div class="input-field">
                    <label>Cellulare *</label>
                    <div>
                        <select name="numberPrefix" class="number-prefix">
                            <option value="+39" <?php if(isset($_POST['numberPrefix']) && $_POST['numberPrefix'] === "+39") echo "selected"; ?>>IT +39</option>
                            <option value="+1" <?php if(isset($_POST['numberPrefix']) && $_POST['numberPrefix'] === "+1") echo "selected"; ?>>US +1</option>
                            <option value="+44" <?php if(isset($_POST['numberPrefix']) && $_POST['numberPrefix'] === "+44") echo "selected"; ?>>UK +44</option>
                            <option value="+49" <?php if(isset($_POST['numberPrefix']) && $_POST['numberPrefix'] === "+49") echo "selected"; ?>>DE +49</option>
                            <option value="+33" <?php if(isset($_POST['numberPrefix']) && $_POST['numberPrefix'] === "+33") echo "selected"; ?>>FR +33</option>
                            <option value="+34" <?php if(isset($_POST['numberPrefix']) && $_POST['numberPrefix'] === "+34") echo "selected"; ?>>ES +34</option>
                        </select>
                        <input name="number" required value="<?php echo isset($_POST['number']) ? $_POST['number'] : ''; ?>" type="tel">
                    </div>
                </div>
                <h4>Dati di accesso</h4>
                <div class="input-grouped">
                    <div class="input-field">
                        <label for="email">Email *</label>
                        <input name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" type="email">
                    </div>
                    <div class="input-field">
                        <label for="confirmEmail">Conferma Email *</label>
                        <input name="confirmEmail" required value="<?php echo isset($_POST['confirmEmail']) ? $_POST['confirmEmail'] : ''; ?>" type="email">
                    </div>
                </div>
                <p class="p-subtitle italic margin-bottom">La password deve essere lunga tra 8 e 32 caratteri, deve contenere almeno 
                    una lettera maiuscola, una lettera minuscola e un numero.
                </p>
                <div class="input-grouped">
                    <div class="input-field">
                        <label for="password">Password *</label>
                        <input name="password" required value="" type="password">
                    </div>
                    <div class="input-field">
                        <label for="confirmPassword">Conferma Password *</label>
                        <input name="confirmPassword" required value="" type="password">
                    </div>
                </div>
                <h4>I miei dati</h4>
                <div class="input-grouped">
                    <div class="input-field">
                        <label for="name">Nome *</label>
                        <input name="name" required value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" type="text">
                    </div>
                    <div class="input-field">
                        <label for="surname">Cognome *</label>
                        <input name="surname" required value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : ''; ?>" type="text">
                    </div>
                </div>
                <div class="input-grouped">
                    <div class="input-field">
                        <label for="birth">Data di nascita *</label>
                        <input name="birth" required value="<?php echo isset($_POST['birth']) ? $_POST['birth'] : ''; ?>" type="date">
                    </div>
                    <div class="input-field">
                        <label for="birthPlace">Luogo di nascita</label>
                        <input name="birthPlace" value="<?php echo isset($_POST['birthPlace']) ? $_POST['birthPlace'] : ''; ?>" type="text">
                    </div>
                </div>
                <h4 class="margin-bottom">Newsletter</h4>                  
                <label for="newsletter" class="margin-bottom">
                    <input type="checkbox" id="newsletter" name="newsletter" value="newsletter" <?php if(isset($_POST['newsletter'])) echo "checked"; ?>/>
                    Sì, desidero rimanere aggiornato sulle ultime news dei miei 
                    eventi preferiti. Presale, promozioni, nuovi show e tanto altro! 
                    (facoltativo)
                </label>
                <h4 class="margin-bottom">Informative utente</h4>
                <p class="margin-bottom">Ho preso visione e accetto
                    <a href="#">Informativa Privacy</a> *
                </p>
                <div class="input-grouped margin-bottom-double">
                    <label><input id="checkPrivacy" required type="radio" name="privacy" value="agreePrivacy" <?php if(isset($_POST['privacy']) && $_POST['privacy'] === "agreePrivacy") echo "checked"; ?>/>
                        Acconsento
                    </label>
                    <label><input required type="radio" name="privacy" value="disagreePrivacy" <?php if(isset($_POST['privacy']) && $_POST['privacy'] === "disagreePrivacy") echo "checked"; ?>/>
                        Non acconsento
                    </label>
                </div>
                <p class="margin-bottom">Ho preso visione e accetto i
                    <a href="#">Termini e condizioni di servizio</a> *
                </p>
                <div class="input-grouped margin-bottom-double">
                    <label><input id="checkTerms" required type="radio" name="terms" value="agreeTerms" <?php if(isset($_POST['terms']) && $_POST['terms'] === "agreeTerms") echo "checked"; ?>/>
                        Acconsento
                    </label>
                    <label><input required type="radio" name="terms" value="disagreeTerms" <?php if(isset($_POST['terms']) && $_POST['terms'] === "disagreeTerms") echo "checked"; ?>/>
                        Non acconsento
                    </label>
                </div>
                <input class="button-submit margin-bottom-double" value="Accetta e crea" name="submit_btn" type="submit">
            </div>
        </form>
    </section>

    <footer>
        <div id="footer">
            <div id="promo">
                <a href="/index.php" class="logo">
                    <img src="./icons/logo.png">
                </a>
                <p>Seguiteci</p>
                <div id="social">
                    <div class="app-icon"><img src="./social/facebook.png"></img></div>
                    <div class="app-icon"><img src="./social/instagram.png"></img></div>
                    <div class="app-icon"><img src="./social/blog.png"></img></div>
                    <div class="app-icon"><img src="./social/youtube.png"></img></div>
                    <div class="app-icon"><img src="./social/spotify.png"></img></div>
                    <div class="app-icon"><img src="./social/tiktok.png"></img></div>
                    <div class="app-icon"><img src="./social/linkedin.png"></img></div>
                </div>
                <p id="disclaimer">Ticketmaster Italia srl - Milano, Via Pietrasanta 14 - Partita IVA 09584690961 - REA MI 2100017</p>
            </div>
            <div id="collegamenti">

                <div id="divider" class="div-mobile"><div></div></div>

                <div class="elenco" data-cat="assistenza">
                <h3>Assistenza Clienti</h3>
                <div class="lista">                   
                    <a href="#">FAQ</a>
                    <a href="#">Termini e condizioni di vendita</a>
                    <a href="#">Termini e condizioni di utilizzo</a>
                    <a href="#">Diritto di recesso</a>
                    <a href="#">Eventi annullati o riprogrammati</a>
                    <a href="#">Rivendita biglietti</a>
                    <a href="#">Cambio Nominativo</a>
                    <a href="#">Metodi di consegna</a>
                    <a href="#">Metodi di pagamento</a>
                </div>
                <img id="footer-arrow" src="./icons/downarrow.png"></img>
                </div>

                <div class="mobilelist hidden" data-cat="assistenza">                   
                    <a href="#">FAQ</a>
                    <a href="#">Termini e condizioni di vendita</a>
                    <a href="#">Termini e condizioni di utilizzo</a>
                    <a href="#">Diritto di recesso</a>
                    <a href="#">Eventi annullati o riprogrammati</a>
                    <a href="#">Rivendita biglietti</a>
                    <a href="#">Cambio Nominativo</a>
                    <a href="#">Metodi di consegna</a>
                    <a href="#">Metodi di pagamento</a>
                </div>

                <div id="divider" class="div-mobile"><div></div></div>

                <div class="elenco" data-cat="guide">
                <h3>Guide Ticketmaster</h3>
                <div class="lista">               
                    <a href="#">Indiemaster</a>
                    <a href="#">Popmaster</a>
                    <a href="#">Festival Finder</a>
                    <a href="#">Guida eventi sportivi</a>
                    <a href="#">Guida Teatro</a>
                    <a href="#">Biglietti VIP</a>
                </div>
                <img id="footer-arrow" src="./icons/downarrow.png"></img>
                </div>

                <div class="mobilelist hidden" data-cat="guide">               
                    <a href="#">Indiemaster</a>
                    <a href="#">Popmaster</a>
                    <a href="#">Festival Finder</a>
                    <a href="#">Guida eventi sportivi</a>
                    <a href="#">Guida Teatro</a>
                    <a href="#">Biglietti VIP</a>
                </div>

                <div id="divider" class="div-mobile"><div></div></div>

                <div class="elenco" data-cat="network">
                <h3>Il nostro network</h3>
                <div class="lista">     
                    <a href="#">Ticketmaster nel mondo</a>
                    <a href="#">Live Nation</a>
                    <a href="#">PayPal</a>
                    <a href="#">Lavora con noi</a>
                </div>
                <img id="footer-arrow" src="./icons/downarrow.png"></img>
                </div>

                <div class="mobilelist hidden" data-cat="network">     
                    <a href="#">Ticketmaster nel mondo</a>
                    <a href="#">Live Nation</a>
                    <a href="#">PayPal</a>
                    <a href="#">Lavora con noi</a>
                </div>

                <div id="divider" class="div-mobile"><div></div></div>

                <div class="elenco" data-cat="b2b">
                <h3>B2B</h3>
                <div class="lista">
                    <a href="#">Chi Siamo</a>
                    <a href="#">Artist Services</a>
                    <a href="#">Programma Affiliati</a>
                    <a href="#">Vendi i tuoi eventi con noi</a>
                </div>
                <img id="footer-arrow" src="./icons/downarrow.png"></img>
                </div>

                <div class="mobilelist hidden" data-cat="b2b">
                    <a href="#">Chi Siamo</a>
                    <a href="#">Artist Services</a>
                    <a href="#">Programma Affiliati</a>
                    <a href="#">Vendi i tuoi eventi con noi</a>
                </div>

                <div id="divider" class="div-mobile"><div></div></div>

            </div>

            </div>
        </div>

        <div id="divider" class="div-desktop"><div></div></div>

        <div id="legal">
            <div id="divider" class="div-mobile"><div></div></div>
            <div id="privacy">
                <a href="#">Informativa Privacy</a>
                <a class="middle" href="#">Cookies</a>
                <a href="#">Gestione dei Cookies</a>
            </div>
            <div id="copyright">
                <p>© 1999-2025 Ticketmaster. Tutti i diritti riservati.</p>
            </div>
        </div>
    </footer>
</body>
</html>