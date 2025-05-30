<?php
    require_once '../dbconfig.php';
    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());

    $query = "SELECT * FROM Artista";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    shuffle($rows);
    echo json_encode($rows);

    mysqli_free_result($result);
    mysqli_close($conn);
?>