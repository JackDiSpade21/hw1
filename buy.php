<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: ./login.php");
        exit();
    }

    if(!isset($_GET['id'])) {
        header("Location: ./index.php");
        exit();
    }

    $conn = mysqli_connect("localhost", "root", "", "ticketmaster") or die(mysqli_connect_error());

    $query = "SELECT artista.Nome, artista.Img FROM evento
            JOIN artista ON evento.Artista = artista.ID
            WHERE evento.ID =  " .$_GET['id'];
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $artista = mysqli_fetch_assoc($result);

    $query = "SELECT * FROM Evento WHERE ID = " .$_GET['id'] ;
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $evento = mysqli_fetch_assoc($result);

    $query = "SELECT SUM(Capacita) AS Rimasti FROM posto
                WHERE evento = ".$evento['ID'];
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $postiRimasti = mysqli_fetch_assoc($result);

    $query = "Select * FROM Utente WHERE Mail = '" . mysqli_real_escape_string($conn, $_SESSION['email']) . "'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $utente = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
?>
<html>
<head>
    <title>Acquista biglietti per <?php echo $artista['Nome']?> | Ticketmaster</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/buy.css">
    <script src="./scripts/footer.js" defer></script>
    <script src="./scripts/buy.js" defer></script>
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
    <div class="width-limiter">
        <form name="buy" method="post">
            <div id="concert-recap">
                <img <?php echo 'src="' . $artista['Img'] . '"'; ?> class="event-image">
                <div>
                    <h3 class="margin-bottom event-title"><?php echo $evento['Nome']?></h3>
                    <!-- mer 06 ago 2025 - h 20:00 | Ippodromo SNAI La Maura, Milano -->
                    <label class="margin-bottom"><?php echo $evento['DataEvento'].' - h '.
                    substr($evento['Ora'], 0, -3).' | '.$evento['Luogo'] ?></label>
                    <label class="margin-bottom">Artista: <?php echo $artista['Nome'] ?></label>
                </div>
            </div>
            
            <div id="step1" class="input-container">

                <div id="ticketdisclaimer">Si esercita un limite di 5 biglietti per singolo ordine.
                    Biglietti rimasti: <?php echo $postiRimasti['Rimasti'] ?>.</div>
                <b class="section-title">tipologia di biglietto</b>
                
                <?php
                    $conn = mysqli_connect("localhost", "root", "", "ticketmaster") or die(mysqli_connect_error());
                    $query = "SELECT * FROM Posto WHERE Evento = " . intval($evento['ID']);
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                    while ($posto = mysqli_fetch_assoc($result)) {
                        echo '<div class="divider-buy"></div>';
                        echo '<div class="input-grouped input-go-column">';
                        echo '<h3 class="ticket-type">' . $posto['Nome'] . ' / ' . $posto['Des'] . '</h3>';
                        echo '<div class="quantity-field">';
                        if ($posto['Capacita'] > 0) {
                            echo '<input type="number" id="quantity_' . $posto['ID'] . '" name="quantity_' . $posto['ID'] . '" min="0" max="' . min(5, $posto['Capacita']) . '" value="0">';
                        } else {
                            echo '<p class="oos">esaurito</p>';
                        }
                        echo '<p class="tick-quantity" for="quantity_' . $posto['ID'] . '">' . number_format($posto['Costo'], 2, ',', '.') . ' €</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '<div class="divider-buy"></div>';
                    mysqli_free_result($result);
                    mysqli_close($conn);
                ?>

                <b class="section-title">Modalità di consegna</b>
                <div class="divider-buy"></div>

                <div class="margin-bottom-double">
                    
                    <label>
                        <input required="required" type="radio" name="print" value="pay"/>
                        <div class="ticket-mode">
                            <p>Spedizione tramite corriere espresso.</p>
                            <p class="print-price">10,00 €</p>
                        </div>
                    </label>

                    <div class="divider-buy"></div>
                    
                    <label>
                        <input required="required" type="radio" name="print" value="free" checked/>
                        <div class="ticket-mode">
                            <p>Stampa a casa, ricevi via mail.</p>
                            <p class="print-price">Gratis</p>
                        </div>
                    </label>

                    <div class="divider-buy"></div>
                </div>
            </div>

            <div id="step2" class="input-container">

                <b class="section-title">Dati di fatturazione</b>
                
                <div class="divider-buy margin-bottom-double"></div>
                <div class="input-grouped margin-bottom">
                    <div class="input-field">
                        <label>Nome *</label>
                        <input name="name" required="required" value="" type="text">
                    </div>
                    <div class="input-field">
                        <label for="surname">Cognome *</label>
                        <input name="surname" required="required" value="" type="text">
                    </div>
                </div>

                <div class="input-grouped margin-bottom">
                    <div class="input-field">
                        <label for="address">Indirizzo completo *</label>
                        <input name="address" required="required" value="" type="text">
                    </div>
                    <div class="input-field">
                        <label for="cap">CAP *</label>
                        <input name="cap" required="required" value="" type="text">
                    </div>
                </div>

                <div class="input-grouped margin-bottom">
                    <div class="input-field">
                        <label for="city">Provincia *</label>
                        <input name="city" required="required" value="" type="text">
                    </div>
                </div>

                <b class="section-title">Dati di pagamento</b>
                <div class="divider-buy margin-bottom-double"></div>
                <div class="input-grouped margin-bottom">
                    <div class="input-field">
                        <label for="card">Numero di carta *</label>
                        <input name="card" required="required" value="" type="text">
                    </div>
                    <div class="input-field">
                        <label>CVC *</label>
                        <input name="cvc" required="required" value="" type="text">
                    </div>
                </div>

                <div class="input-grouped">
                    <div class="input-field">
                        <label>Data di scadenza *</label>
                        <input name="expiry" required="required" value="" type="text" >
                    </div>
                </div>

                <b class="section-title">Finalizzazione</b>
                <div class="divider-buy margin-bottom"></div>
                <h2 class="margin-bottom">450.00 €</h2>
                <h3 class="margin-bottom">I biglietti saranno connessi al profilo di <strong><?php echo $utente['Nome']." ".$utente['Cognome']?></strong>.</h3>
                <label>Sono incluse le tasse. Verrà inviata una ricevuta via mail.</label>
                <label class="margin-bottom-double">I biglietti saranno visibili sul tuo profilo.</label>

                <div class="submit-wrapper">
                    <p class="error hidden">Ricontrolla i dati inseriti.</p>
                    <input class="button-proceed margin-bottom-double" value="Completa acquisto" name="submit_btn" type="submit">
                </div>
            </div>

        </form>
    </div>
        
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