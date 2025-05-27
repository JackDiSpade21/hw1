<?php
    require_once '../keys.php';

    // echo $spotifyApi;
    // echo $spotifySecret;

    header('Content-Type: application/json');

    if (!isset($_GET['id'])) {
        exit;
    }

    //Step 1
    $conn = mysqli_connect("localhost", "root", "", "ticketmaster") or die(mysqli_connect_error());

    $query = "SELECT nome, categoria FROM Artista WHERE ID = " . intval($_GET['id']);
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    
    if($row['categoria'] != 'Musica') {
        exit();
    }
    $name = urlencode($row['nome']);

    //Step 2
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = [
        'Authorization: Basic ' . base64_encode($spotifyApi . ':' . $spotifySecret),
        'Content-Type: application/x-www-form-urlencoded'
    ];
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($curl);
    curl_close($curl);

    //Step 3
    $token_json = json_decode($response, true);
    if (!isset($token_json['access_token'])) {
        exit();
    }
    $token = $token_json['access_token'];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.spotify.com/v1/search?q=$name&type=artist");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token
    ]);
    $artist_response = curl_exec($curl);
    curl_close($curl);

    $artist_json = json_decode($artist_response, true);
    //echo $artist_response;
    //exit();

    $artistId = $artist_json['artists']['items'][0]['id'];
    $artistImg = null;
    if (count($artist_json['artists']['items'][0]['images']) > 0) {
        $artistImg = $artist_json['artists']['items'][0]['images'][0]['url'];
    }

    //Step 4
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.spotify.com/v1/artists/$artistId/top-tracks?market=IT");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token
    ]);
    $tracks_response = curl_exec($curl);
    curl_close($curl);

    $tracks_json = json_decode($tracks_response, true);
    echo json_encode([
        'artistImg' => $artistImg,
        'tracks' => $tracks_json['tracks']
    ]);

?>