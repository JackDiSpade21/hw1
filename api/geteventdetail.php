<?php
    require_once '../dbconfig.php';
    header('Content-Type: application/json');

    if (!isset($_GET['id'])) {
        exit;
    }

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());

    $query = "SELECT * FROM evento WHERE Artista = " . intval($_GET['id']) ;
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    echo json_encode($rows);

    mysqli_free_result($result);
    mysqli_close($conn);
?>