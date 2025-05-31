<?php
    require_once '../dbconfig.php';
    header('Content-Type: application/json');

    if (!isset($_GET['search'])) {
        echo json_encode([]);
        exit();
    }

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $start_artisti = isset($_GET['start_artisti']) ? intval($_GET['start_artisti']) : 0;
    $count_artisti = isset($_GET['count_artisti']) ? intval($_GET['count_artisti']) : 5;
    $start_eventi = isset($_GET['start_eventi']) ? intval($_GET['start_eventi']) : 0;
    $count_eventi = isset($_GET['count_eventi']) ? intval($_GET['count_eventi']) : 5;

    $queryArtisti = "SELECT ID, Nome, Categoria, Genere, Hero, 0 AS Tipo
                FROM ARTISTA
                WHERE Nome LIKE '%$search%' OR Categoria LIKE '%$search%' OR Genere LIKE '%$search%'
                LIMIT $start_artisti, $count_artisti";
    $queryEventi = "SELECT evento.ID, evento.Nome, evento.Luogo, evento.DataEvento, evento.Ora, artista.Nome AS NomeArtista, 1 AS Tipo
                FROM evento
                JOIN artista ON evento.Artista = artista.ID
                WHERE evento.Nome LIKE '%$search%' 
                   OR evento.Luogo LIKE '%$search%' 
                   OR artista.Nome LIKE '%$search%'
                   OR artista.Categoria LIKE '%$search%'
                   OR artista.Genere LIKE '%$search%'
                LIMIT $start_eventi, $count_eventi";

    $resultArtisti = mysqli_query($conn, $queryArtisti) or die(mysqli_error($conn));
    $resultEventi = mysqli_query($conn, $queryEventi) or die(mysqli_error($conn));

    $artisti = array();
    $eventi = array();

    while ($row = mysqli_fetch_assoc($resultArtisti)) {
        $artisti[] = $row;
    }
    while ($row = mysqli_fetch_assoc($resultEventi)) {
        $eventi[] = $row;
    }

    echo json_encode([
        'artisti' => $artisti,
        'eventi' => $eventi
    ]);

    mysqli_free_result($resultArtisti);
    mysqli_free_result($resultEventi);
    mysqli_close($conn);
?>