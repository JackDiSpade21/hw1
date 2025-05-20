const api_ticketmaster = '';
const api_spotify = '';
const secret_spotify = '';
let spotify_token = '';

document.addEventListener("click", closeSpotifyBox);
const modal_spotify = document.querySelector("#spotifybox");
const spotify_songs = document.querySelector("#spotify-songs");
const spotifyTitle = document.querySelector("#spotify-title");
const spotifyPic = document.querySelector("#spotify-pic");
const closeButtonSpotify = document.querySelector("#close-button-spotify");
closeButtonSpotify.addEventListener("click", closeButtonSpotifyBox);

fetch('./keys.txt')
    .then(response => response.text(), onError)
    .then(text => {
        const api_ticketmaster = text.split('\n')[0].trim();
        const api_spotify = text.split('\n')[1].trim();
        const secret_spotify = text.split('\n')[2].trim();
        console.log('API Key spotify:', api_spotify);
        console.log('Secret Spotify:', secret_spotify);
        console.log('API Key ticketmaster:', api_ticketmaster);

        fetch('https://app.ticketmaster.com/discovery/v2/events.json' + '?apikey=' + api_ticketmaster + '&locale=it-it' + '&sort=id,asc' + '&size=50')
            .then(onResponseTicket, onError)
            .then(onJSONTicket);

        
        fetch("https://accounts.spotify.com/api/token",{
                method: "post",
                body: 'grant_type=client_credentials',
                headers:
                {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Authorization': 'Basic ' + btoa(api_spotify + ':' + secret_spotify)
                }
            }).then(onTokenResponse, onError).then(onTokenJson);
    })

function onResponseTicket(response) {
    if (response.ok) {
        return response.json();
    }
    else
        return null;
}

function onError(err) {
    console.error('Fetch problem: ' + err.message);
}

function onJSONTicket(json) {
    console.log(json);

    const events = new Map();
    const results = json._embedded.events.length;

    for (let i = 0; i < results; i++) {
        const embedded = json._embedded.events[i];
        const name = embedded._embedded.attractions[0].name;
        const type = embedded.classifications[0].segment.name;

        let imageUrl = '';
        for (const image of embedded.images) {
            if (image.ratio === "16_9" && image.height > 500) {
                imageUrl = image.url;
                break;
            }
        }

        if (!events.has(name)) {
            events.set(name, { name, type, imageUrl });
        }
    }

    console.log(Array.from(events.values()));

    const maincards = document.querySelector('#main-cards');
    const mostwanted = document.querySelector('#most-wanted');
    const discover = document.querySelector('#discover');

    let index = 0;
    for (const [key, event] of events) {
        if (index >= 4) break;
        createCard(event.name, event.type, event.imageUrl, maincards, ['cmain']);
        index++;
    }

    index = 0;
    for (const [key, event] of events) {
        if (index < 5){
            index++;
            continue;
        }else if (index === 5){
            createCard(event.name, event.type, event.imageUrl, mostwanted, ['featured']);
        }else if (index >= 6 && index < 8){
            createCard(event.name, event.type, event.imageUrl, mostwanted, ['featured', 'feat-max-two']);
        }else if (index < 10){
            createCard(event.name, event.type, event.imageUrl, mostwanted, ['featured', 'feat-max']);
        }else{
            break;
        }
        index++;
    }

    index = 0;
    for (const [key, event] of events) {
        if (index < 10){
            index++;
            continue;
        }else if (index === 11){
            createCard(event.name, event.type, event.imageUrl, discover, ['dis']);
        }else if (index === 12){
            createCard(event.name, event.type, event.imageUrl, discover, ['dis', 'dis-max-two']);
        }else if (index < 16){
            createCard(event.name, event.type, event.imageUrl, discover, ['dis', 'dis-max']);
        }else{
            break;
        }
        index++;
    }


}

function createCard(name, type, imageUrl, section, classes) {

    const article = document.createElement('a');
    article.classList.add('card');
    article.href = '#';

    if(classes) {
        for (let i in classes) {
            article.classList.add(classes[i]);
        }
    }

    const holder = document.createElement('div');
    holder.id = 'holder';

    const thumbnail = document.createElement('img');
    thumbnail.src = imageUrl;
    thumbnail.classList.add('big-card');
    holder.appendChild(thumbnail);

    const overlay = document.createElement('div');
    overlay.classList.add('overlay');
    const tsov = document.createElement('div');

    tsov.classList.add('tsov');
    overlay.appendChild(tsov);

    const solidov = document.createElement('div');
    solidov.classList.add('solidov');

    const freccia = document.createElement('img');
    freccia.src = './icons/freccia.png';
    solidov.appendChild(freccia);

    overlay.appendChild(solidov);
    holder.appendChild(overlay);
    article.appendChild(holder);

    const title = document.createElement('p');
    title.textContent = type;
    article.appendChild(title);

    const link = document.createElement('h3');
    link.textContent = name;

    article.appendChild(link);
    section.appendChild(article);

    if(section.id === 'discover') {
        const span = document.createElement('span');
        span.classList.add('cat');
        span.textContent = 'biglietti';
        article.appendChild(span);
    }

    if(type === 'Musica') {
        article.addEventListener('click', openSpotifyBox);
    }

    return;
}

function onTokenResponse(response) {
    if (response.ok) {
        return response.json();
    }
    else
        return null;
}

function onTokenJson(json) {
    console.log(json);
    spotify_token = json.access_token;
}


function openSpotifyBox(event) {

    if(!modal_spotify.classList.contains('hidden')) {
        return;
    }

    const name = event.currentTarget.querySelector('h3').textContent;

    modal_spotify.classList.remove('hidden');
    document.body.classList.add("no-scroll");
    event.stopPropagation();

    fetch("https://api.spotify.com/v1/search?q=" + name + "&type=artist", {
        headers: {
            'Authorization': 'Bearer ' + spotify_token
        }
    }).then(onResponseArtist, onError).then(onJSONArtist);


    spotifyPic.src = './icons/person.png';
    spotifyTitle.innerHTML = 'Brani popolari di <br>' + name;
}

function onResponseArtist(response) {
    if (response.ok) {
        return response.json();
    }
    else
        return null;
}

function onJSONArtist(json) {
    console.log(json);
    const artistId = json.artists.items[0].id;
    const artistImg = json.artists.items[0].images[0].url;
    spotifyPic.src = artistImg;

    fetch("https://api.spotify.com/v1/artists/" + artistId + "/top-tracks?market=IT", {
        headers: {
            'Authorization': 'Bearer ' + spotify_token
        }
    }).then(onResponseTopTracks, onError).then(onJSONTopTracks);

}

function onResponseTopTracks(response) {
    if (response.ok) {
        return response.json();
    }
    else
        return null;
}

function onJSONTopTracks(json) {
    console.log(json);
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

    spotify_songs.innerHTML = "";
    modal_spotify.classList.add('hidden');
    document.body.classList.remove("no-scroll");
}

function closeButtonSpotifyBox(){
    spotify_songs.innerHTML = "";
    modal_spotify.classList.add('hidden');
    document.body.classList.remove("no-scroll");
}