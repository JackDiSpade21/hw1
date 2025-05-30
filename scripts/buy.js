const error = document.querySelector('.error');

const buy = document.forms['buy'];
buy.addEventListener('submit', validateAll);
buy.cap.addEventListener('blur', validateAll);
buy.card.addEventListener('blur', validateAll);
buy.cvc.addEventListener('blur', validateAll);
buy.expiry.addEventListener('blur', validateAll);

const ticketInputs = document.querySelectorAll('input[type="number"][id^="quantity_"]');
const printRadios = document.querySelectorAll('input[name="print"]');
const totalPriceElem = document.querySelector('h2.margin-bottom');
const ticketPrices = {};

for (let i = 0; i < ticketInputs.length; i++) {
    const input = ticketInputs[i];
    const priceElem = input.parentElement.querySelector('.tick-quantity');
    if (priceElem) {
        ticketPrices[input.id] = parseFloat(priceElem.textContent.replace(/\./g, '').replace(',', '.'));
    }
}

function getShippingCost() {
    const selected = document.querySelector('input[name="print"]:checked');
    return selected && selected.value === 'pay' ? 10.00 : 0.00;
}

function updateTotal() {
    let total = 0;
    for (const input of ticketInputs) {
        const qty = parseInt(input.value) || 0;
        total += qty * (ticketPrices[input.id] || 0);
    }
    total += getShippingCost();

    totalPriceElem.textContent = total.toFixed(2).replace('.', ',') + ' €';
}

for (const input of ticketInputs) {
    input.addEventListener('input', updateTotal);
    input.addEventListener('blur', validateAll);
}
for (const radio of printRadios) {
    radio.addEventListener('change', updateTotal);
}

updateTotal();

function errorHandler(messages) {
    if (Array.isArray(messages)) {
        error.innerHTML = messages.join('<br>');
    } else {
        error.textContent = messages;
    }
    error.classList.remove('hidden');
}

function validateAll(event) {
    let sum = 0;
    for (let i = 0; i < ticketInputs.length; i++) {
        sum += parseInt(ticketInputs[i].value) || 0;
    }

    const errors = [];

    if (sum > 5) {
        errors.push("Puoi acquistare al massimo 5 biglietti per ordine.");
    }

    const cap = buy.elements['cap'].value;
    if (cap !== "" && !/^\d{5}$/.test(cap)) {
        errors.push("Il CAP deve essere composto da 5 cifre.");
    }

    const card = buy.elements['card'].value;
    if (card !== "" && !/^\d{16}$/.test(card)) {
        errors.push("Il numero di carta deve essere composto da 16 cifre.");
    }

    const cvc = buy.elements['cvc'].value;
    if (cvc !== "" && !/^\d{3}$/.test(cvc)) {
        errors.push("Il CVC deve essere composto da 3 cifre.");
    }

    const expiry = buy.elements['expiry'].value;
    if (expiry !== "" && !/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
        errors.push("La data di scadenza deve essere nel formato MM/AA.");
    } else if (expiry !== "") {
        const [mm, yy] = expiry.split('/');
        const expMonth = parseInt(mm, 10);
        const expYear = 2000 + parseInt(yy, 10);
        const now = new Date();
        const thisMonth = now.getMonth() + 1;
        const thisYear = now.getFullYear();
        if (expYear < thisYear || (expYear === thisYear && expMonth < thisMonth)) {
            errors.push("La carta è scaduta.");
        }
    }

    if (errors.length > 0) {
        if (event) event.preventDefault();
        errorHandler(errors);
        return false;
    } else {
        error.textContent = '';
        error.classList.add('hidden');
        return true;
    }
}