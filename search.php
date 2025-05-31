<html>
<head>
    <title>Ticketmaster | Trova gli Eventi</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/search.css">
    <script src="./scripts/footer.js" defer></script>
    <script src="./scripts/nav.js" defer></script>
    <script src="./scripts/menu.js" defer></script>
    <script src="./scripts/search.js" defer></script>
    <link rel="stylesheet" type="text/css" href="./styles/nav.css">
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
    <link rel="stylesheet" type="text/css" href="./styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <?php include './blocks/topnosearch.php'; ?>
    <?php include './blocks/mobiletop.php'; ?>

    <div id="search-box">
        <form id="search-form">
            <input type="text" name="searchInput" placeholder="Artista, Evento o Località">
            <button type="submit" id="search-button">
                <img class="search-icon" src="./icons/searchblue.png">
            </button>
        </form>
    </div>

    <section id="main">
        <div id="event-container">
            <div id="event-box">
                <div class="event-count">
                    <h2>Risultati della ricerca</h2>
                </div>
                <div id="event-list">
                    
                </div>
                <a id="load-more" class="hide">
                    <p>Carica altro</p>
                </a>
            </div>
        </div>
    </section>

    <?php include './blocks/bottom.php'; ?>
</body>
</html>        