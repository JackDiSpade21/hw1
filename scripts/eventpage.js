const faqElement = document.querySelectorAll(".elenco-faq");
const faqSection = document.querySelectorAll(".faqlist");

const main = document.querySelector("#main");
const eventId = main.dataset.id;

const eventBox = document.querySelector("#event-box");
const eventiFuturi = document.querySelector("#eventi-futuri");

fetch('http://localhost/hw1/api/geteventdetail.php?id=' + eventId)
    .then(onResponseTicket, onError)
    .then(onJSONTicket);

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

function getMonthAbbr(dateString) {
    const mesi = ["GEN", "FEB", "MAR", "APR", "MAG", "GIU", "LUG", "AGO", "SET", "OTT", "NOV", "DIC"];
    //console.log("Date String:", dateString);
    const monthIndex = new Date(dateString).getMonth();
    //console.log("Month Index:", monthIndex);
    return mesi[monthIndex];
}

function createEventEntry(eventArray) {
    for (const evento of eventArray) {
        const eventEntry = document.createElement('div');
        eventEntry.classList.add('event-entry');
        const eventInfo = document.createElement('div');
        eventInfo.classList.add('event-info');

        const eventDate = document.createElement('div');
        eventDate.classList.add('event-date');
        const eventMonth = document.createElement('p');
        eventMonth.textContent = getMonthAbbr(evento.DataEvento);
        const eventDay = document.createElement('strong');
        eventDay.textContent = new Date(evento.DataEvento).getDate();
        eventDate.appendChild(eventMonth);
        eventDate.appendChild(eventDay);
        eventInfo.appendChild(eventDate);

        const eventDesc = document.createElement('div');
        eventDesc.classList.add('event-desc');
        const eventTime = document.createElement('p');
        eventTime.textContent = "Alle " + evento.Ora.slice(0, -3);
        const eventPlace = document.createElement('strong');
        eventPlace.textContent = evento.Luogo;
        const eventName = document.createElement('p');
        eventName.textContent = evento.Nome;
        eventDesc.appendChild(eventTime);
        eventDesc.appendChild(eventPlace);
        eventDesc.appendChild(eventName);
        eventInfo.appendChild(eventDesc);

        const eventLink = document.createElement('a');
        eventLink.href = "./buy.php?id=" + evento.ID;
        eventLink.classList.add('event-buy');
        const eventLinkText = document.createElement('p');
        eventLinkText.textContent = "Biglietti";
        const eventLinkIcon = document.createElement('img');
        eventLinkIcon.src = "./icons/freccia.png";
        eventLink.appendChild(eventLinkText);
        eventLink.appendChild(eventLinkIcon);
        eventInfo.appendChild(eventLink);

        eventEntry.appendChild(eventInfo);
        eventBox.appendChild(eventEntry);
    }
}

function onJSONTicket(json) {
    const nazionali = [];
    const internazionali = [];

    for (const evento of json) {
        if (evento.Nazionale === "1") {
            nazionali.push(evento);
        } else {
            internazionali.push(evento);
        }
    }

    eventiFuturi.textContent = nazionali.length + internazionali.length;
    console.log("Nazionali:", nazionali);
    console.log("Internazionali:", internazionali);

    const eventCountry = document.createElement('div');
    eventCountry.classList.add('event-country');
    const eventNation = document.createElement('strong');
    eventNation.textContent = "Italia";
    eventCountry.appendChild(eventNation);
    const eventNationCount = document.createElement('p');
    eventNationCount.textContent = nazionali.length + " eventi";
    if( nazionali.length === 0) {
        eventCountry.classList.add('no-events');
    }
    eventCountry.appendChild(eventNationCount);
    eventBox.appendChild(eventCountry);

    createEventEntry(nazionali);

    const eventSplit = document.createElement('div');
    eventSplit.classList.add('event-split');
    eventBox.appendChild(eventSplit);
    
    const eventCountry2 = document.createElement('div');
    eventCountry2.classList.add('event-country');
    const eventNation2 = document.createElement('strong');
    eventNation2.textContent = "Eventi Internazionali";
    eventCountry2.appendChild(eventNation2);
    const eventNationCount2 = document.createElement('p');
    eventNationCount2.textContent = internazionali.length + " eventi";
    if( internazionali.length === 0) {
        eventCountry2.classList.add('no-events');
    }
    eventCountry2.appendChild(eventNationCount2);
    eventBox.appendChild(eventCountry2);
    eventBox.appendChild(eventCountry2);

    createEventEntry(internazionali);
}

for(let i = 0; i < faqElement.length; i++){
    faqElement[i].addEventListener("click", togglefaqSection);
}

function togglefaqSection(event){
    const imgChild = event.currentTarget.querySelector("img");

    for(let i = 0; i < faqSection.length; i++){
        if(faqSection[i].dataset.cat === event.currentTarget.dataset.cat){
            if(faqSection[i].classList.contains("hidden")){
                faqSection[i].classList.remove("hidden");
                faqSection[i].classList.add("lista-faq");
                event.currentTarget.classList.add("elenco-faq-active");
                event.currentTarget.classList.remove("elenco-faq");
                imgChild.src = "./icons/uparrowblack.png";
            }
            else{
                faqSection[i].classList.add("hidden");
                faqSection[i].classList.remove("lista-faq");
                event.currentTarget.classList.remove("elenco-faq-active");
                event.currentTarget.classList.add("elenco-faq");
                imgChild.src = "./icons/downarrowblack.png";
            }

            break;
        }
    }

}