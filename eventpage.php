<?php
    require_once './dbconfig.php';
    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit;
    }

    session_start();

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());
    $query = "SELECT * FROM Artista WHERE ID = " .$_GET['id'] . " LIMIT 1";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);
    
    $query2 = "SELECT scaletta.ID as ScalettaID, scaletta.Nome as ScalettaNome, concerto.Canzone 
                FROM artista
                JOIN scaletta ON artista.ID = scaletta.Artista
                RIGHT JOIN concerto ON concerto.Scaletta = scaletta.ID
                WHERE artista.ID =".$_GET['id'].";";

    $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));

    $scalette = array();
    while ($row2 = mysqli_fetch_assoc($result)) {
        $sid = $row2['ScalettaID'];
        if (!isset($scalette[$sid])) {
            $scalette[$sid] = [
                'nome' => $row2['ScalettaNome'],
                'canzoni' => []
            ];
        }
        $scalette[$sid]['canzoni'][] = $row2['Canzone'];
    }

    //print_r($scalette);

    if(isset($_SESSION['email'])) {
        $email = mysqli_real_escape_string($conn, $_SESSION['email']);
        
        $query3 = "SELECT * FROM Utente WHERE Mail = '".$email."'";

        $result = mysqli_query($conn, $query3) or die(mysqli_error($conn));
        $utente = mysqli_fetch_assoc($result);
    }

    mysqli_free_result($result);
    mysqli_close($conn);
?>
<html>
<head>
    <title>Biglietti per <?php echo $row['Nome']?> | Ticketmaster</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/eventpage.css">
    <script src="./scripts/nav.js" defer></script>
    <script src="./scripts/footer.js" defer></script>
    <script src="./scripts/eventpage.js" defer></script>
    <script src="./scripts/spotifybox.js" defer></script>
    <script src="./scripts/menu.js" defer></script>
    <link rel="stylesheet" type="text/css" href="./styles/nav.css">
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
    <link rel="stylesheet" type="text/css" href="./styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div id="spotifybox" class="spotifybox-style hidden">
        <div id="spotify-close">
            <div id="close-button-spotify"><img src="./icons/cross.png"></div>
        </div>

        <img id="spotify-pic" src="./icons/person.png">
        <h2 id="spotify-title">Brani popolari di <br></h2>

        <div id="spotify-songs">
            
        </div>

    </div>

    <?php include './blocks/top.php'; ?>
    <?php include './blocks/mobiletop.php'; ?>

    <section id="hero">
        <div id="heroblur" style="background-image: url('<?php echo $row['Img']; ?>');"></div>
        <div id="description" class="width-limiter des-box">
            <div id="link-path">
                <a href="#">Pagina iniziale</a>
                <span>&nbsp/&nbsp</span>
                <?php
                    echo '<a href="#">' . $row['Categoria'] . '</a>';
                ?>
                <span>&nbsp/&nbsp</span>
                <?php
                    echo '<a href="#">' . $row['Genere'] . '</a>';
                ?>
                <span>&nbsp/&nbsp</span>
                <span><?php echo $row['Nome']?> Biglietti</span>
            </div>
            <div id="hero-des">
                <p><?php echo $row['Genere']?></p>
                <h1>Biglietti per <?php echo $row['Nome']?></h1>
            </div>
        </div>       
    </section>

    <nav id="event-nav">
        <div class="width-limiter">
            <div id="navigation-event">
                <div id="biglietti-evento" class="event-nav-active event-nav-hover">Eventi</div>
                <div id="info-evento" class="nav-button event-nav-hover">Informazioni</div>
                <div id="scalette" class="nav-button event-nav-hover">Scaletta</div>
                <div id="faq" class="nav-button event-nav-hover">Faq</div>
            </div>
        </div>
    </nav>

    <section id="main" <?php echo 'data-id='.$_GET['id']?>>
        <div id="event-container">
            <div class="width-limiter">
                <div class="section-title">
                    <p></p>
                    <h2>Eventi</h2>
                </div>

                <div id="event-box">
                    <div class="event-count">
                        <h2><strong id="eventi-futuri">0</strong> Eventi futuri</h2>
                    </div>
                </div>
            </div>

        </div>

        <div id="info-container">
            <div class="width-limiter">
                <div id="info-box">
                    <div class="section-title">
                        <p></p>
                        <h2>Informazioni</h2>
                    </div>
                    <p>
                        <strong>Tutto su <?php echo $row['Nome']?>!</strong>
                        <br><br>
                        <?php echo $row['Descrizione']?>

                        <?php
                            if(strcmp($row['Categoria'], 'Musica') == 0) {
                                echo '<a class="spotify-button" data-id='.$_GET['id'].' data-name="'.$row['Nome'].'">
                                        <span>Spotify</span>
                                        <img src="./icons/arrowblack.png"></img>
                                    </a>';
                            }
                        ?>
                    </p>
                </div>
            </div>
            <div class="white-filler"></div>
            <img class="back-image" <?php echo 'src="' . $row['Img'] . '"'; ?>>
        </div>

        <div id="scaletta-container">
            <div class="width-limiter">
                <div class="section-title">
                    <p></p>
                    <h2>Scaletta</h2>
                </div>
                <br>

                <?php
                foreach ($scalette as $id => $scaletta) {
                    echo '<strong>' . $scaletta['nome'] . '</strong>';
                    echo '<ol>';
                    foreach ($scaletta['canzoni'] as $canzone) {
                        echo '<li>' . $canzone . '</li>';
                    }
                    echo '</ol>';
                }
                ?>
            </div>
        </div>

        <div id="faq-container">
            <div class="width-limiter">
                <div class="section-title">
                    <p></p>
                    <h2>FAQ</h2>
                </div>

                <div id="collegamenti-faq">

                    <div id="divider-faq"><div></div></div>

                    <div class="elenco-faq" data-cat="domanda1">
                        <h3>Come si descrive in breve <?php echo $row['Nome']?>?</h3>
                        <img class="faq-arrow" src="./icons/downarrowblack.png"></img>
                    </div>

                    <div class="faqlist hidden" data-cat="domanda1">                   
                        <p><?php echo $row['Hero']?></p>
                    </div>

                    <div id="divider-faq"><div></div></div>

                    <div class="elenco-faq" data-cat="domanda2">
                        <h3>I biglietti per l'evento di <?php echo $row['Nome']?> sono nominativi?</h3>
                        <img class="faq-arrow" src="./icons/downarrowblack.png"></img>
                    </div>

                    <div class="faqlist hidden" data-cat="domanda2">                   
                        <p>I biglietti non sono nominativi, ma è necessario un account Ticketmaster per acquistarli.</p>
                    </div>

                    <div id="divider-faq"><div></div></div>

                    <div class="elenco-faq" data-cat="domanda3">
                        <h3>Come posso ottenere un rimborso per un biglietto di <?php echo $row['Nome']?>?</h3>
                        <img class="faq-arrow" src="./icons/downarrowblack.png"></img>
                    </div>

                    <div class="faqlist hidden" data-cat="domanda3">                   
                        <p>Per richiedere il rimborso per un biglietto consulta le <a class="faq-link" href="#">FAQ sui rimborsi.</a></p>
                    </div>

                    <div id="divider-faq"><div></div></div>

                    <div class="elenco-faq" data-cat="domanda4">
                        <h3>Come posso rivendere un biglietto di <?php echo $row['Nome']?>?</h3>
                        <img class="faq-arrow" src="./icons/downarrowblack.png"></img>
                    </div>

                    <div class="faqlist hidden" data-cat="domanda4">                   
                        <p>Per rivendere un biglietto di <?php echo $row['Nome']?> consulta le <a class="faq-link" href="#">FAQ sulla rivendita dei biglietti.</a></p>
                    </div>

                    <div id="divider-faq"><div></div></div>
                
                </div>

            </div>

        </div>
    </section>

    <?php include './blocks/bottom.php'; ?>
</body>
</html>        