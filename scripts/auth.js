const error = document.querySelector('#error');

const login = document.forms['login'];
if (login) {
    //login.addEventListener('submit', loginValidation);
}

function loginValidation(event) {
    error.classList.remove('hidden');
    event.preventDefault();
}