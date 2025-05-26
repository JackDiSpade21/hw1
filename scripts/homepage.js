fetch('http://localhost/hw1/api/gethomecards.php')
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

function onJSONTicket(json) {
    //console.log(json);

    const events = new Map();
    const results = json.length;

    for (let i = 0; i < results; i++) {
        const item = json[i];
        const id = item.ID;
        const name = item.Nome;
        const type = item.Categoria;
        const imageUrl = item.Img;
        const herodes = item.Hero;

        if (!events.has(id)) {
            events.set(id, { id, name, type, imageUrl, herodes });
        }
    }

    //console.log(Array.from(events.values()));

    const maincards = document.querySelector('#main-cards');
    const mostwanted = document.querySelector('#most-wanted');
    const discover = document.querySelector('#discover');

    const hero = document.querySelector('#hero');
    const herodes = document.querySelector('#description');

    let index = 0;
    for (const [key, event] of events) {

        if (index == 0){
            hero.style.backgroundImage = 'url(' + event.imageUrl + ')';
            herodes.querySelector('h3').textContent = event.name;
            herodes.querySelector('p').textContent = event.herodes;
            herodes.querySelector('a').href = 'eventpage.php?id=' + event.id;
            index++;
            continue;
        }

        if (index >= 5) break;
        createCard(event.name, event.type, event.imageUrl, maincards, ['cmain'], event.id);
        index++;
    }

    index = 0;
    for (const [key, event] of events) {
        if (index < 6){
            index++;
            continue;
        }else if (index === 6){
            createCard(event.name, event.type, event.imageUrl, mostwanted, ['featured'], event.id);
        }else if (index >= 7 && index < 9){
            createCard(event.name, event.type, event.imageUrl, mostwanted, ['featured', 'feat-max-two'], event.id);
        }else if (index < 11){
            createCard(event.name, event.type, event.imageUrl, mostwanted, ['featured', 'feat-max'], event.id);
        }else{
            break;
        }
        index++;
    }

    index = 0;
    for (const [key, event] of events) {
        if (index < 11){
            index++;
            continue;
        }else if (index === 12){
            createCard(event.name, event.type, event.imageUrl, discover, ['dis'], event.id);
        }else if (index === 13){
            createCard(event.name, event.type, event.imageUrl, discover, ['dis', 'dis-max-two'], event.id);
        }else if (index < 17){
            createCard(event.name, event.type, event.imageUrl, discover, ['dis', 'dis-max'], event.id);
        }else{
            break;
        }
        index++;
    }


}

function createCard(name, type, imageUrl, section, classes, id) {

    const article = document.createElement('a');
    article.classList.add('card');
    article.href = 'eventpage.php?id=' + id;

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

    return;
}