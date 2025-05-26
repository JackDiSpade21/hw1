document.addEventListener("click", closeSpotifyBox);
const modal_spotify = document.querySelector("#spotifybox");
const spotify_songs = document.querySelector("#spotify-songs");
const spotifyTitle = document.querySelector("#spotify-title");
const spotifyPic = document.querySelector("#spotify-pic");
const closeButtonSpotify = document.querySelector("#close-button-spotify");
closeButtonSpotify.addEventListener("click", closeButtonSpotifyBox);

const spotifyButton = document.querySelector(".spotify-button");
spotifyButton.addEventListener("click", openSpotifyBox);

let spotifyLoaded = false;

function onError(err) {
    console.error('Fetch problem: ' + err.message);
}

function openSpotifyBox(event) {

    if(!modal_spotify.classList.contains('hidden')) {
        return;
    }

    const id = event.currentTarget.getAttribute('data-id');
    const name = event.currentTarget.getAttribute('data-name');

    modal_spotify.classList.remove('hidden');
    document.body.classList.add("no-scroll");
    event.stopPropagation();

    if(!spotifyLoaded){
        fetch("./api/getspotifydetail.php?id=" + id)
            .then(onResponseArtist, onError)
            .then(onJSONArtist);

        spotifyPic.src = './icons/person.png';
        spotifyTitle.innerHTML = 'Brani popolari di <br>' + name;
    }else{
        modal_spotify.classList.remove('hidden');
    }

}

function onResponseArtist(response) {
    if (response.ok) {
        return response.json();
    }
    else
        return null;
}

function onJSONArtist(json) {
    if (!json) return;

    if(json.artistImg) {
        spotifyPic.src = json.artistImg;
    }

    const tracks = json.tracks;

    for (let i = 0; i < 3; i++) {
        const track = tracks[i];
        const canzone = track.name;
        const album = track.album.name;
        const url = track.external_urls.spotify;
        let imageUrl = '';

        for (const image of track.album.images) {
            if (image.height > 500) {
                imageUrl = image.url;
                break;
            }
        }

        createSongBox(canzone, album, imageUrl, url);
        spotifyLoaded = true;
    }

}

function createSongBox(canzone, album, image, url) {

    const songbox = document.createElement('div');
    songbox.classList.add('songbox');
    const img = document.createElement('img');
    img.src = image;
    songbox.appendChild(img);
    const songInfo = document.createElement('div');
    songInfo.classList.add('song-info');
    const songName = document.createElement('p');
    songName.textContent = canzone
    songInfo.appendChild(songName);
    const songAlbum = document.createElement('p');
    songAlbum.textContent = album;
    songInfo.appendChild(songAlbum);
    songbox.appendChild(songInfo);
    const playButton = document.createElement('a');
    playButton.href = url;
    const playImg = document.createElement('img');
    playImg.src = './icons/play-button-spot.png';
    playButton.appendChild(playImg);
    songbox.appendChild(playButton);

    spotify_songs.appendChild(songbox);
    
    return;
}

function closeSpotifyBox(event) {
    if (modal_spotify.contains(event.target) || mobileMenuButton.contains(event.target) || !mobileMenu.classList.contains('hidden')) {
        return;
    }

    //spotify_songs.innerHTML = "";
    modal_spotify.classList.add('hidden');
    document.body.classList.remove("no-scroll");
}

function closeButtonSpotifyBox(){
    //spotify_songs.innerHTML = "";
    modal_spotify.classList.add('hidden');
    document.body.classList.remove("no-scroll");
}