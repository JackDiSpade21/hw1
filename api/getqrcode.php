<?php
    if (!isset($_GET['codice'])) {
        http_response_code(400);
        exit();
    }

    $codice = $_GET['codice'];
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($codice);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $qr_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $qr_image = curl_exec($ch);
    curl_close($ch);

    if ($qr_image === false) {
        exit();
    }

    header('Content-Type: image/png');
    echo $qr_image;
?>