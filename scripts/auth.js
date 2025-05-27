const error = document.querySelector('#error');

const register = document.forms['register'];
register.addEventListener('submit', registerValidation);

function registerValidation(event) {

    const number = register.number.value;
    if(number.length < 9 || number.length === 0) {
        errorHandler('Numero di telefono non valido', event);
        return;
    }

    const email = register.email.value;
    const confirmEmail = register.confirmEmail.value;
    if(email !== confirmEmail) {
        errorHandler('Le email non corrispondono', event);
        return;
    }

    const password = register.password.value;
    const confirmPassword = register.confirmPassword.value;

    if(password.length < 8 || password.length > 32) {
        errorHandler('Rispetta i requisiti indicati della password', event);
        return;
    }

    if(password !== confirmPassword) {
        errorHandler('Le password non corrispondono', event);
        return;
    }

    const birth = register.birth.value;
    const today = new Date();
    const birthDate = new Date(birth);

    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    if (age < 18) {
        errorHandler('Devi avere almeno 18 anni', event);
        return;
    }
    if (age > 100) {
        errorHandler('Età non valida', event);
        return;
    }

    const privacy = register.privacy;
    if(privacy.value !== 'agreePrivacy') {
        errorHandler('Devi accettare la informativa sulla privacy', event);
        return;
    }

    const terms = register.terms;
    if(terms.value !== 'agreeTerms') {
        errorHandler('Devi accettare i termini e le condizioni', event);
        return;
    }
    
}

function errorHandler(message, event) {
    error.textContent = message;
    error.classList.remove('hidden');
    window.scrollTo(0, 0);
    event.preventDefault();
}