<?php
    session_start();
    if (isset($_SESSION['email'])) {
        header("Location: ./index.php");
        exit();
    }

    $errore = false;
    $exists = false;

    if(isset($_POST['email']) && isset($_POST['confirmEmail']) && isset($_POST['password']) 
    && isset($_POST['confirmPassword']) && isset($_POST['numberPrefix'])
    && isset($_POST['number']) && isset($_POST['name']) && isset($_POST['surname']
    ) && isset($_POST['birth']) && isset($_POST['privacy'])
    && isset($_POST['terms']) && isset($_POST['birthPlace'])) {

        $conn = mysqli_connect("localhost", "root", "", "ticketmaster") or die(mysqli_connect_error());
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


        if($birthPlace !== "")
            $birthPlace = mysqli_real_escape_string($conn, $_POST['birthPlace']);
        else{
            $birthPlace = "NULL";
            echo "VUOTOOOOOO";
        }

        $newsletter = isset($_POST['newsletter']) ? 1 : 0;

        if(strlen($password) < 8 || strlen($password) > 32) {
            $errore = true;
        }

        if($_POST['privacy'] !== "agreePrivacy" || $_POST['terms'] !== "agreeTerms") {
            $errore = true;
        }

        if(strlen($number) < 9) {
            $errore = true;
        }

        if(
            $numberPrefix !== "+39" &&
            $numberPrefix !== "+1" &&
            $numberPrefix !== "+44" &&
            $numberPrefix !== "+49" &&
            $numberPrefix !== "+33" &&
            $numberPrefix !== "+34")
        {
            $errore = true;
        }

        $today = new DateTime();
        $birthDate = DateTime::createFromFormat('Y-m-d', $birth);
        if($birthDate) {
            $age = $today->diff($birthDate)->y;
            if($age < 18 || $age > 100) {
                $errore = true;
            }
        } else {
            $errore = true;
        }

        if ($email !== $confirmEmail || $password !== $confirmPassword) {
            $errore = true;
        } else if (!$errore) {
            $queryCheckEmail = "SELECT * FROM Utente WHERE Mail = '$email'";
            $resCheckEmail = mysqli_query($conn, $queryCheckEmail) or die(mysqli_error($conn));
            if (mysqli_num_rows($resCheckEmail) > 0) {
                $errore = true;
                $exists = true;
            } else {

                $queryInsert = "INSERT INTO Utente (Mail, Psw, Tel, Nome, Cognome, Nascita, Luogo, Newsletter) 
                VALUES ('$email', '$password', '$numberPrefix$number', '$name', '$surname', '$birth', $birthPlace, '$newsletter')";
                  
                if (mysqli_query($conn, $queryInsert)) {
                    $_SESSION["email"] = $_POST["email"];
                    mysqli_close($conn);
                    mysqli_free_result($resCheckEmail);
                    header("Location: ./profile.php?firstLogin=true");
                    exit();
                } else {
                    $errore = true;
                }
            }
            mysqli_free_result($resCheckEmail);
        }
        
        mysqli_close($conn);
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
            if ($errore) { 
                echo 'class="error"'; 
            } else { 
                echo 'class="error hidden"'; 
            }
            ?>>
            <?php
                if($exists) {
                    echo "L'email inserita è già in uso.";
                } else {
                    echo "Si è verificato un errore durante la registrazione. Riprova.";
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
                            <option selected value="+39">IT +39</option>
                            <option value="+1">US +1</option>
                            <option value="+44">UK +44</option>
                            <option value="+49">DE +49</option>
                            <option value="+33">FR +33</option>
                            <option value="+34">ES +34</option>
                        </select>
                        <input name="number" required value="" type="tel">
                    </div>
                </div>
                <h4>Dati di accesso</h4>
                <div class="input-grouped">
                    <div class="input-field">
                        <label for="email">Email *</label>
                        <input name="email" required value="" type="email">
                    </div>
                    <div class="input-field">
                        <label for="confirmEmail">Conferma Email *</label>
                        <input name="confirmEmail" required value="" type="email">
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
                        <input name="name" required value="" type="text">
                    </div>
                    <div class="input-field">
                        <label for="surname">Cognome *</label>
                        <input name="surname" required value="" type="text">
                    </div>
                </div>
                <div class="input-grouped">
                    <div class="input-field">
                        <label for="birth">Data di nascita *</label>
                        <input name="birth" required value="" type="date">
                    </div>
                    <div class="input-field">
                        <label for="birthPlace">Luogo di nascita</label>
                        <input name="birthPlace" value="" type="text">
                    </div>
                </div>
                <h4 class="margin-bottom">Newsletter</h4>                  
                <label for="newsletter" class="margin-bottom">
                    <input type="checkbox" id="newsletter" name="newsletter" value="newsletter"/>
                    Sì, desidero rimanere aggiornato sulle ultime news dei miei 
                    eventi preferiti. Presale, promozioni, nuovi show e tanto altro! 
                    (facoltativo)
                </label>
                <h4 class="margin-bottom">Informative utente</h4>
                <p class="margin-bottom">Ho preso visione e accetto
                    <a href="#">Informativa Privacy</a> *
                </p>
                <div class="input-grouped margin-bottom-double">
                    <label><input required type="radio" name="privacy" value="agreePrivacy"/>
                        Acconsento
                    </label>
                    <label><input required type="radio" name="privacy" value="disagreePrivacy"/>
                        Non acconsento
                    </label>
                </div>
                <p class="margin-bottom">Ho preso visione e accetto i
                    <a href="#">Termini e condizioni di servizio</a> *
                </p>
                <div class="input-grouped margin-bottom-double">
                    <label><input required type="radio" name="terms" value="agreeTerms"/>
                        Acconsento
                    </label>
                    <label><input required type="radio" name="terms" value="disagreeTerms"/>
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