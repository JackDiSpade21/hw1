<?php
    header('Content-Type: application/json');

    if (!isset($_GET['Mail'])) {
        exit;
    }

    $conn = mysqli_connect("localhost", "root", "", "ticketmaster") or die(mysqli_connect_error());

    $query = "SELECT * FROM utente WHERE utente.Mail = '".mysqli_real_escape_string($conn, $_GET['Mail'])."'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }

    mysqli_free_result($result);
    mysqli_close($conn);
?>