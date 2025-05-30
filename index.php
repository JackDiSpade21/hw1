<?php
    require_once './dbconfig.php';
    session_start();

    if(isset($_SESSION['email'])) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());
        $email = mysqli_real_escape_string($conn, $_SESSION['email']);
        
        $query = "SELECT * FROM Utente WHERE Mail = '".$email."'";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $utente = mysqli_fetch_assoc($res);

        mysqli_free_result($res);
        mysqli_close($conn);
    }
?>
<html>
<head>
    <title>Ticketmaster | Biglietti Ufficiali per Concerti, Festival, Arte e Teatro</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/homepage.css">
    <script src="./scripts/nav.js" defer></script>
    <script src="./scripts/footer.js" defer></script>
    <script src="./scripts/menu.js" defer></script>
    <script src="./scripts/homepage.js" defer></script>
    <link rel="stylesheet" type="text/css" href="./styles/nav.css">
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
    <link rel="stylesheet" type="text/css" href="./styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    
    <?php include './blocks/top.php'; ?>

    <section id="hero">
        <div id="heroblur"></div>   
        <div id="description">
            <h3></h3>
            <p></p>
            <a>Biglietti</a>
        </div>       
    </section>

    <?php include './blocks/mobiletop.php'; ?>

    <section id="main">
        <div id="content">

            <div id="main-cards">

            </div>

            <div id="featured">
                <div id="scroll-arrow" class="sc-feat-right"></div>
                <h1>Biglietti più richiesti</h1>
                <div id="most-wanted">
                    
                </div>
            </div>

            <div id="scopri">
                <div id="scroll-arrow" class="sc-dis-right"></div>
                <h1>Scopri</h1>
                <div id="discover">
                    
                </div>
            </div>

        </div>
        <div id="side">
            <h1>consigliati</h1>
            <div id="sidebar">                
                <a class="card sidebar" href="#">
                    <div id="holder">
                        <img class="big-card" src="./cards/BigliettiVipmedium2.webp"></img>
                        <div class="overlay">
                            <div class="tsov"></div>
                            <div class="solidov"><img src="./icons/freccia.png"></img></div>
                        </div>
                    </div>
                    <h3>Biglietti VIP</h3>
                </a>
                <a href="#" class="card sidebar">
                    <div id="holder">
                        <img class="big-card" src="./cards/RapMaster2023_medium.webp"></img>
                        <div class="overlay">
                            <div class="tsov"></div>
                            <div class="solidov"><img src="./icons/freccia.png"></img></div>
                        </div>
                    </div>
                    <h3>RapMaster</h3>
                </a>
                <a href="#" class="card sidebar">
                    <div id="holder">
                        <img class="big-card" src="./cards/PopMaster2023_medium.webp"></img>
                        <div class="overlay">
                            <div class="tsov"></div>
                            <div class="solidov"><img src="./icons/freccia.png"></img></div>
                        </div>
                    </div>
                    <h3>Popmaster</h3>
                </a>
                <a href="#" class="card sidebar">
                    <div id="holder">
                        <img class="big-card" src="./cards/IndieMaster2023_medium.webp"></img>
                        <div class="overlay">
                            <div class="tsov"></div>
                            <div class="solidov"><img src="./icons/freccia.png"></img></div>
                        </div>
                    </div>
                    <h3>Indiemaster</h3>
                </a>
            </div>
        </div>
    </section>

    <?php include './blocks/bottom.php'; ?>

</body>
</html>
