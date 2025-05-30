<?php
    require_once './dbconfig.php';
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: ./index.php");
        exit();
    }

    $firstLogin = false;
    if(isset($_GET['firstLogin']) && $_GET['firstLogin'] == 'true') {
        $firstLogin = true;
    }

    $buy = 0;
    if(isset($_GET['buy']) && $_GET['buy'] > 0) {
        $buy = $_GET['buy'];
    }

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    
    $query = "SELECT * FROM Utente WHERE Mail = '".$email."'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $utente = mysqli_fetch_assoc($res);

    mysqli_free_result($res);
    mysqli_close($conn);
?>
<html>
<head>
    <title>Il mio profilo | Ticketmaster</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/eventpage.css">
    <script src="./scripts/footer.js" defer></script>
    <script src="./scripts/profile.js" defer></script>
    <link rel="stylesheet" type="text/css" href="./styles/nav.css">
    <link rel="stylesheet" type="text/css" href="./styles/profile.css">
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
    <link rel="stylesheet" type="text/css" href="./styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <?php include './blocks/topslim.php'; ?>

    <section class="profilehero">
        <div id="heroblur" class="profilepic"></div>   
        <div id="description" class="width-limiter des-box">
            <div id="link-path">
            </div>
            <div id="hero-des">
                <p>Area Personale di</p>
                <h1><?php 
                    echo $utente['Nome'] . " " . $utente['Cognome'];
                ?></h1>
            </div>
        </div>       
    </section>

    <nav id="event-nav">
        <div class="width-limiter">
            <div id="navigation-event">
                <div id="dati-personali" class="event-nav-active event-nav-hover">I miei dati</div>
                <div id="biglietti" class="nav-button event-nav-hover">Biglietti</div>
            </div>
        </div>
    </nav>

    <section id="main">
        <div id="event-container">
            <div class="width-limiter">
                <div id="my-tickets" class="hidden">
                    <div class="section-title">
                        <p></p>
                        <h2>I tuoi biglietti</h2>
                    </div>
                    <div id="event-box">
                        <div class="event-count">
                            <h2>Elenco dei biglietti posseduti</h2>
                        </div>
                        <div id="event-list">

                        </div>
                        <a id="load-more">
                            <p>Carica altro</p>
                        </a>
                    </div>
                </div>

                <div id="my-data" class="">
                    <h4 
                        <?php if($firstLogin) echo 'class="welcome"'; else echo 'class="hidden"'; ?>>
                    
                        Benvenuto su TicketMaster!<br>Questa è la area personale, potrai
                        vedere i tuoi biglietti acquistati quì.<br>Torna alla home per vedere gli eventi!
                
                    </h4>

                    <h4 
                        <?php if($buy == 1) echo 'class="welcome"'; else echo 'class="hidden"'; ?>>
                    
                        L'acquisto è andato a buon fine!<br>Visualizza i tuoi biglietti
                        nella sezione "BIGLIETTI"!.
                
                    </h4>

                    <h4 
                        <?php if($buy == 2) echo 'class="error"'; else echo 'class="hidden"'; ?>>
                    
                        Errore durante l'emissione dei biglietti.<br>
                        Nessun biglietto è stato emesso.<br> Riprova più tardi.
                
                    </h4>

                    <div class="section-title margin-bottom-double">
                        <p></p>
                        <h2>I tuoi dati personali</h2>
                    </div>

                    <div class="input-grouped margin-bottom-double">
                    <div class="input-field">
                        <h2>Nome</h3>
                        <p><?php echo $utente['Nome'] ?></p>
                    </div>
                    <div class="input-field">
                        <h2>Cognome</h3>
                        <p><?php echo $utente['Cognome'] ?></p>
                    </div>
                    </div>

                    <div class="input-grouped margin-bottom-double">
                    <div class="input-field">
                        <h2>Email</h3>
                        <p><?php echo $utente['Mail'] ?></p>
                    </div>
                    <div class="input-field">
                        <h2>Telefono</h3>
                        <p><?php echo $utente['Tel'] ?></p>
                    </div>
                    </div>

                    <div class="input-grouped margin-bottom-double">
                    <div class="input-field">
                        <h2>Data di nascita</h3>
                        <p><?php echo $utente['Nascita'] ?></p>
                    </div>
                    <div class="input-field">
                        <h2>Luogo di nascita</h3>
                        <p><?php
                            if($utente['Luogo'] == 0){
                                echo "Non fornito";
                            } else {
                                echo $utente['Luogo'];
                            }
                        ?></p>
                    </div>
                    </div>

                    <a class="button-submit margin-bottom" href="./logout.php">Logout</a>
                
                </div>

            </div>
        </div>

        </div>
    </section>

    <?php include './blocks/bottom.php'; ?>
</body>
</html>        