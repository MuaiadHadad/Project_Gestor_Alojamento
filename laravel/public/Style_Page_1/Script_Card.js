const cards = document.querySelectorAll(".card");
const FilterButton = document.getElementById("Filter_bot");
const FilterSecao = document.getElementById("Filter");
const PrincibalSecao = document.getElementById("prencipal");

    slideOne();
    slideTwo();


let sliderOne = document.getElementById("slider-1");
let sliderTwo = document.getElementById("slider-2");
let displayValOne = document.getElementById("range1");
let displayValTwo = document.getElementById("range2");
let minGap = 0;
let sliderTrack = document.querySelector(".slider-track");
let sliderMaxValue = document.getElementById("slider-1").max;

function slideOne(){
    if(parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap){
        sliderOne.value = parseInt(sliderTwo.value) - minGap;
    }
    displayValOne.textContent = sliderOne.value;
    fillColor();
}
function slideTwo(){
    if(parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap){
        sliderTwo.value = parseInt(sliderOne.value) + minGap;
    }
    displayValTwo.textContent = sliderTwo.value;
    fillColor();
}
function fillColor(){
    percent1 = (sliderOne.value / sliderMaxValue) * 100;
    percent2 = (sliderTwo.value / sliderMaxValue) * 100;
    sliderTrack.style.background = `linear-gradient(to right, #dadae5 ${percent1}% , #000000 ${percent1}% , #000000 ${percent2}%, #dadae5 ${percent2}%)`;
}


FilterButton.addEventListener("click", function() {
    if (FilterSecao.style.display === "none") {
        FilterSecao.style.display = "block";
        PrincibalSecao.style.display = "none";
    } else {
        FilterSecao.style.display = "none";
        PrincibalSecao.style.display = "block";
    }
});
cards.forEach(card => {
    card.addEventListener("mouseover", function() {
        this.classList.add("rgb");
    });

    card.addEventListener("mouseout", function() {
        this.classList.remove("rgb");
    });
});
const cardS = document.querySelectorAll(".card");
const modal = document.getElementById("myModal");
const modalImg = document.getElementById("modalImage");
const closeBtn = document.querySelector(".close");

cardS.forEach((card, index) => {
    card.addEventListener("click", function() {
        modalImg.src = this.querySelector(".card-image img").src; // Ajuste aqui para acessar a imagem dentro do elemento .card-image
        modal.style.display = "block";
        slideIndex = index; // Define o slideIndex para o índice do card clicado
    });
});

closeBtn.addEventListener("click", function() {
    modal.style.display = "none";
});

window.addEventListener("click", function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});

document.addEventListener("keydown", function(event) {
    if (event.key === "ArrowLeft") {
        plusSlides(-1);
    } else if (event.key === "ArrowRight") {
        plusSlides(1);
    }
});

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    const slides = document.querySelectorAll(".card");
    if (slides.length === 0) {
        return;
    }
    slideIndex = (n + slides.length) % slides.length;
    modalImg.src = slides[slideIndex].querySelector(".card-image img").src; // Ajuste aqui para acessar a imagem dentro do elemento .card-image
}

showSlides(slideIndex);
VanillaTilt.init(document.querySelectorAll(".card"),{
    glare: true,
    reverse: true,
    "max-glare": 0.15
});
