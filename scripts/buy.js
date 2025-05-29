const error = document.querySelector('#error');

const buy = document.forms['buy'];
buy.addEventListener('submit', registerValidation);

function registerValidation(event) {
    event.preventDefault();
    
}

function errorHandler(message, event) {
    error.textContent = message;
    error.classList.remove('hidden');
    window.scrollTo(0, 0);
    event.preventDefault();
}