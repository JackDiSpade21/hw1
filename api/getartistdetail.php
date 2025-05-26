<?php
    header('Content-Type: application/json');

    if (!isset($_GET['id'])) {
        exit;
    }

    $conn = mysqli_connect("localhost", "root", "", "ticketmaster") or die(mysqli_connect_error());

    $query = "SELECT * FROM Artista WHERE ID = " . intval($_GET['id']) . " LIMIT 1";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);

    mysqli_free_result($result);
    mysqli_close($conn);
?>