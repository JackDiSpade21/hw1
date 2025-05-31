const form = document.querySelector('#search-form');
form.addEventListener('submit', search);
const loadMoreButton = document.querySelector('#load-more');
loadMoreButton.addEventListener('click', loadMore);
const eventBox = document.querySelector('#event-list');
window.addEventListener('DOMContentLoaded', searchStart);

let start_artisti = 0;
let count_artisti = 5;
let start_eventi = 0;
let count_eventi = 5;
let lastSearch = '';

function search(event) {
    const searchInput = form.searchInput.value;
    event.preventDefault();

    if (searchInput === '') {
        return;
    }
    lastSearch = searchInput;
    start_artisti = 0;
    count_artisti = 5;
    start_eventi = 0;
    count_eventi = 5;

    fetchResults(false);
}

function loadMore() {
    start_artisti += count_artisti;
    start_eventi += count_eventi;
    fetchResults(true);
}

function fetchResults(append) {
    fetch("http://localhost/hw1/api/searchresults.php?search=" + encodeURIComponent(lastSearch) +
        "&start_artisti=" + start_artisti + "&count_artisti=" + count_artisti +
        "&start_eventi=" + start_eventi + "&count_eventi=" + count_eventi)
        .then(onResponse, onError)
        .then(json => onJSONResults(json, append));
}

function onResponse(response) {
    if (response.ok) {
        return response.json();
    }
    else
        return null;
}

function onError(err) {
    console.error('Fetch problem: ' + err.message);
}

function createCard(item, tipo) {
    const eventEntry = document.createElement('div');
    eventEntry.classList.add('event-entry');

    const eventInfo = document.createElement('div');
    eventInfo.classList.add('event-info');

    const eventDesc = document.createElement('div');
    eventDesc.classList.add('event-desc');

    const eventTitle = document.createElement('strong');
    const eventSubtitle = document.createElement('p');
    const eventDetails = document.createElement('p');
    const dettaglioP = document.createElement('p');
    const eventBuy = document.createElement('a');
    eventBuy.classList.add('event-buy');

    if(tipo === 'artista'){
        eventTitle.textContent = item.Nome;
        eventSubtitle.textContent = item.Categoria + " - " + item.Genere;
        eventDetails.textContent = item.Hero;
        dettaglioP.textContent = 'Profilo';
        eventBuy.href = './eventpage.php?id=' + item.ID;
    } else if(tipo === 'evento'){
        eventTitle.textContent = item.Nome;
        eventSubtitle.textContent = item.NomeArtista;
        eventDetails.textContent = item.Luogo + " - " + item.DataEvento + " - " + item.Ora;
        dettaglioP.textContent = 'Acquista';
        eventBuy.href = './buy.php?id=' + item.ID;
    }

    eventDesc.appendChild(eventTitle);
    eventDesc.appendChild(eventSubtitle);
    eventDesc.appendChild(eventDetails);

    const arrowImg = document.createElement('img');
    arrowImg.src = './icons/freccia.png';

    eventBuy.appendChild(dettaglioP);
    eventBuy.appendChild(arrowImg);

    eventInfo.appendChild(eventDesc);
    eventInfo.appendChild(eventBuy);

    eventEntry.appendChild(eventInfo);

    eventBox.appendChild(eventEntry);
}

function createResults(json, append = false) {
    if (!append) eventBox.innerHTML = '';

    for (const artista of json.artisti) {
        createCard(artista, 'artista');
    }
    for (const evento of json.eventi) {
        createCard(evento, 'evento');
    }
}

function onJSONResults(json, append) {
    if ((json.artisti.length < count_artisti) && (json.eventi.length < count_eventi)) {
        loadMoreButton.classList.add('hide');
        loadMoreButton.classList.remove('load-more');
    } else {
        loadMoreButton.classList.remove('hide');
        loadMoreButton.classList.add('load-more');
    }
    createResults(json, append);
}

function searchStart() {
    const params = new URLSearchParams(window.location.search);
    if (params.has('search')) {
        const value = params.get('search');
        form.searchInput.value = value;
        lastSearch = value;
        start_artisti = 0;
        count_artisti = 5;
        start_eventi = 0;
        count_eventi = 5;
        fetchResults(false);
    }
}