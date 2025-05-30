<?php
    require_once '../dbconfig.php';
    header('Content-Type: application/json');
    session_start();
    
    if (!isset($_SESSION['email'])) {
        exit();
    }

    $email = $_SESSION['email'];

    $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
    $count = isset($_GET['count']) ? intval($_GET['count']) : 5;

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());

    $query = "SELECT * FROM ricevuta
            JOIN evento ON ricevuta.Evento = evento.ID
            WHERE ricevuta.Utente = '$email'
            ORDER BY ricevuta.Acquisto DESC
            LIMIT $start, $count;";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    echo json_encode($rows);

    mysqli_free_result($result);
    mysqli_close($conn);
?>