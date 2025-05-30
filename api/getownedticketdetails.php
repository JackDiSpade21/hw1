<?php
    require_once '../dbconfig.php';
    header('Content-Type: application/json');
    session_start();
    
    if (!isset($_SESSION['email']) || !isset($_GET['id'])) {
        exit();
    }

    $email = $_SESSION['email'];
    $ricevuta = intval($_GET['id']);

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());

    $check_query = "SELECT 1 FROM ricevuta WHERE ID = $ricevuta AND Utente = '" . $email . "'";
    $check_result = mysqli_query($conn, $check_query) or die(mysqli_error($conn));
    if (mysqli_num_rows($check_result) === 0) {
        mysqli_close($conn);
        exit();
    }
    mysqli_free_result($check_result);

    $query = "SELECT biglietto.ID, biglietto.Codice, biglietto.Stato,
            biglietto.Tipo, biglietto.Evento, evento.DataEvento, posto.Nome AS NomePosto
            FROM ricevuta 
            JOIN biglietto ON biglietto.Ricevuta = ricevuta.ID
            JOIN evento ON biglietto.Evento = evento.ID
            JOIN posto ON biglietto.Tipo = posto.ID
            WHERE biglietto.Ricevuta = $ricevuta;";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $rows = array();
    $today = date('Y-m-d');
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['DataEvento'] < $today && $row['Stato'] != 2) {
            $bid = intval($row['ID']);
            mysqli_query($conn, "UPDATE biglietto SET Stato = 2 WHERE ID = $bid");
            $row['Stato'] = 2;
        }
        $rows[] = $row;
    }

    echo json_encode($rows);

    mysqli_free_result($result);
    mysqli_close($conn);
?>