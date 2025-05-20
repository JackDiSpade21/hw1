const footerElement = document.querySelectorAll(".elenco");
for(let i = 0; i < footerElement.length; i++){
    footerElement[i].addEventListener("click", toggleFooterSection);
}
const footerSection = document.querySelectorAll(".mobilelist");

function toggleFooterSection(event){
    const imgChild = event.currentTarget.querySelector("img");

    for(let i = 0; i < footerSection.length; i++){
        if(footerSection[i].dataset.cat === event.currentTarget.dataset.cat){
            if(footerSection[i].classList.contains("hidden")){
                footerSection[i].classList.remove("hidden");
                footerSection[i].classList.add("lista-mobile");
                imgChild.src = "./icons/uparrow.png";
            }
            else{
                footerSection[i].classList.add("hidden");
                footerSection[i].classList.remove("lista-mobile");
                imgChild.src = "./icons/downarrow.png";
            }

            break;
        }
    }

}