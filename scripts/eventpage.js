const faqElement = document.querySelectorAll(".elenco-faq");
for(let i = 0; i < faqElement.length; i++){
    faqElement[i].addEventListener("click", togglefaqSection);
}
const faqSection = document.querySelectorAll(".faqlist");

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