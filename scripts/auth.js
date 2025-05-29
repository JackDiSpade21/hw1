const error = document.querySelector('#error');

const register = document.forms['register'];
register.addEventListener('submit', registerValidation);
register.addEventListener('submit', checkBoxesValidation);
register.number.addEventListener('blur', registerValidation);
register.email.addEventListener('blur', registerValidation);
register.confirmEmail.addEventListener('blur', registerValidation);
register.password.addEventListener('blur', registerValidation);
register.confirmPassword.addEventListener('blur', registerValidation);
register.birth.addEventListener('blur', registerValidation);

const errors = [];

function registerValidation(event) {
    errors.length = 0;

    const number = register.number.value;
    if(number && (!/^[0-9]{9,20}$/.test(number))) {
        errors.push('Numero di telefono non valido (solo cifre, almeno 9 numeri)');
    }

    const email = register.email.value;
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(email).toLowerCase())){
        errors.push('Email non valida');
    }

    const confirmEmail = register.confirmEmail.value;
    if(email && confirmEmail && email !== confirmEmail) {
        errors.push('Le email non corrispondono');
    }

    const password = register.password.value;
    if(password && !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,32}$/.test(password)) {
        errors.push('La password non segue i requisiti indicati.');
    }

    const confirmPassword = register.confirmPassword.value;
    if(password && confirmPassword && password !== confirmPassword) {
        errors.push('Le password non corrispondono');
    }

    const birth = register.birth.value;
    if(birth) {
        const today = new Date();
        const birthDate = new Date(birth);
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        if (age < 18) {
            errors.push('Devi avere almeno 18 anni');
        }
        if (age > 100) {
            errors.push('Età non valida');
        }
    }

    if(email){
        fetch('http://localhost/hw1/api/checkemail.php?Mail=' + encodeURIComponent(String(email).toLowerCase()))
            .then(onResponseMail, onError)
            .then(onJSONMail);
    }

    if(errors.length > 0) {
        errorHandler(errors, event);
        event.preventDefault();
    } else {
        error.textContent = '';
    }
}

function errorHandler(messages) {
    if (Array.isArray(messages)) {
        error.innerHTML = messages.join('<br>');
    } else {
        error.textContent = messages;
    }
    error.classList.remove('hidden');
}

function onResponseMail(response) {
    if (response.ok) {
        return response.json();
    }
    else
        return null;
}

function onError(err) {
    console.error('Fetch problem: ' + err.message);
}

function onJSONMail(json) {
    if (json && json.exists) {
        errors.push('Email già registrata. Se sei tu, accedi con le tue credenziali.');
        errorHandler(errors);
    }
}

function checkBoxesValidation(event) {
    const privacyChecked = document.querySelector('#checkPrivacy:checked');
    if (!privacyChecked) {
        errors.push('Devi accettare la informativa sulla privacy');
        errorHandler(errors);
        window.scrollTo(0,0);
    }

    const termsChecked = document.querySelector('#checkTerms:checked');
    if (!termsChecked) {
        errors.push('Devi accettare i termini e le condizioni');
        errorHandler(errors);
        window.scrollTo(0,0);
    }
}