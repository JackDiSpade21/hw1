const mobileMenuButton = document.querySelector("#mobile-menu");
mobileMenuButton.addEventListener("click", openMobileMenu);
const closeButton = document.querySelector("#close-button");
closeButton.addEventListener("click", closeMobileMenu);
const mobileMenu = document.querySelector("#mobile-menu-nav");

function openMobileMenu(){
    document.body.classList.add("no-scroll");
    document.body.classList.add("no");
    mobileMenu.classList.remove("hidden");
    mobileMenu.classList.add("mobile-menu-style");
    mobileMenu.style.top = window.pageYOffset + 'px';
}

function closeMobileMenu() {
    document.body.classList.remove("no-scroll");
    mobileMenu.classList.add("hidden");
    mobileMenu.classList.remove("mobile-menu-style");
}