const mydata = document.querySelector('#my-data');
const mytickets = document.querySelector('#my-tickets');
const databutton = document.querySelector('#dati-personali');
const ticketsbutton = document.querySelector('#biglietti');
const error = document.querySelector('.error');
const welcome = document.querySelector('.welcome');
const eventBox = document.querySelector('#event-list');
const loadMoreButton = document.querySelector('#load-more');
databutton.addEventListener('click', showMyData);
ticketsbutton.addEventListener('click', showMyTickets);
loadMoreButton.addEventListener('click', loadMore);

let start = 0;
let count = 5;

fetch("http://localhost/hw1/api/getownedtickets.php")
    .then(onResponse, onError)
    .then(onJSONTicket);

function loadMore() {
    start += count;
    count += 5;
    fetch("http://localhost/hw1/api/getownedtickets.php?start=" + start + "&count=" + count)
        .then(onResponse, onError)
        .then(onJSONTicket);
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

function onJSONTicket(json) {

    console.log(json);

    const results = json.length;
    if (results <= 5) {
        loadMoreButton.remove();
    }

    for (let i = 0; i < results; i++) {
        const item = json[i];

        const eventEntry = document.createElement('div');
        eventEntry.classList.add('event-entry');

        const eventInfo = document.createElement('div');
        eventInfo.classList.add('event-info');

        const eventDesc = document.createElement('div');
        eventDesc.classList.add('event-desc');

        const eventTitle = document.createElement('strong');
        eventTitle.textContent = item.Nome;

        const ticketsInfo = document.createElement('p');
        ticketsInfo.innerHTML = 'Hai acquistato <strong>' + item.Quantita
        + '</strong> biglietti il <strong>' + item.Acquisto + '</strong> per <strong>' + item.Totale + '€</strong>';

        const eventDetails = document.createElement('p');
        eventDetails.textContent = item.Luogo + ' - ' + item.DataEvento + ' - ' + item.Ora;

        eventDesc.appendChild(eventTitle);
        eventDesc.appendChild(ticketsInfo);
        eventDesc.appendChild(eventDetails);

        const eventBuy = document.createElement('a');
        eventBuy.classList.add('event-buy');
        eventBuy.setAttribute('data-eventid', item.ID);
        eventBuy.addEventListener('click', ticketDetails);

        const dettaglioP = document.createElement('p');
        dettaglioP.textContent = 'Dettaglio';

        const arrowImg = document.createElement('img');
        arrowImg.src = './icons/freccia.png';

        eventBuy.appendChild(dettaglioP);
        eventBuy.appendChild(arrowImg);

        eventInfo.appendChild(eventDesc);
        eventInfo.appendChild(eventBuy);

        eventEntry.appendChild(eventInfo);

        eventBox.appendChild(eventEntry);
    }
}

function onJSONEvent(json) {
    console.log(json);
    const results = json.length;
    const eventEntry = onJSONEvent.lastButton.closest('.event-entry');

    // Se i ticket sono già visibili, non rigenerarli
    if (eventEntry.querySelector('.ticket')) return;

    for (let i = 0; i < results; i++) {
        const item = json[i];

        const ticketDiv = document.createElement('div');
        ticketDiv.classList.add('ticket');

        const qrImg = document.createElement('img');
        qrImg.classList.add('qr-code');
        qrImg.src = "http://localhost/hw1/api/getqrcode.php?codice=" + encodeURIComponent(item.Codice);

        const ticketInfo = document.createElement('div');
        ticketInfo.classList.add('ticket-info');

        const idStrong = document.createElement('strong');
        idStrong.textContent = 'ID #' + String(item.ID).padStart(6, '0');

        const seatP = document.createElement('p');
        seatP.textContent = item.NomePosto;

        const validLabel = document.createElement('label');
        validLabel.classList.add('valid');
        switch (item.Stato) {
            case '0':
                validLabel.textContent = 'Valido';
                validLabel.classList.add('valid');
                break;
            case '1':
                validLabel.textContent = 'Usato';
                validLabel.classList.add('used');
                break;
            case '2':
                validLabel.textContent = 'Scaduto';
                validLabel.classList.add('expired');
                break;
            default:
                validLabel.textContent = 'Stato sconosciuto';
                validLabel.classList.add('expired');
                break;
        }

        ticketInfo.appendChild(idStrong);
        ticketInfo.appendChild(seatP);
        ticketInfo.appendChild(validLabel);

        ticketDiv.appendChild(qrImg);
        ticketDiv.appendChild(ticketInfo);

        eventEntry.appendChild(ticketDiv);
    }
}

function ticketDetails() {
    const eventId = this.getAttribute('data-eventid');
    const eventEntry = this.closest('.event-entry');
    const arrowImg = this.querySelector('img');

    arrowImg.src = './icons/downarrow.png';

    const tickets = eventEntry.querySelectorAll('.ticket');
    if (tickets.length > 0) {
        for (const t of tickets) {
            t.classList.toggle('hide');
        }
        if ([...tickets].every(t => t.classList.contains('hide'))) {
            arrowImg.src = './icons/freccia.png';
        }
        return;
    }

    onJSONEvent.lastButton = this;
    fetch("http://localhost/hw1/api/getownedticketdetails.php?id=" + eventId)
        .then(onResponse, onError)
        .then(onJSONEvent);
}

function showMyData() {
    mydata.classList.remove('hidden');
    mytickets.classList.add('hidden');
    databutton.classList.add('event-nav-active');
    ticketsbutton.classList.remove('event-nav-active');
    databutton.classList.remove('nav-button');
    ticketsbutton.classList.add('nav-button');
}

function showMyTickets() {
    mydata.classList.add('hidden');
    mytickets.classList.remove('hidden');
    databutton.classList.remove('event-nav-active');
    ticketsbutton.classList.add('event-nav-active');
    databutton.classList.add('nav-button');
    ticketsbutton.classList.remove('nav-button');
    if(error) {
        error.remove();
    }
    if(welcome) {
        welcome.remove();
    }
}