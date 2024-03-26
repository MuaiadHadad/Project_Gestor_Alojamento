const cards = document.querySelectorAll(".card");
const FilterButton = document.getElementById("Filter_bot");
const FilterSecao = document.getElementById("Filter");
const PrincibalSecao = document.getElementById("prencipal");
const FilteAplicadoSecao = document.getElementById("Filter_aplicado");
const FilterAplicButton = document.getElementById("button_aplic_filter");
/*_________________________________mais menos__________________________________________________*/
FilterAplicButton.addEventListener("click", function() {
    if (FilteAplicadoSecao.style.display === "none") {
        FilteAplicadoSecao.style.display = "block";
    } else {
        FilteAplicadoSecao.style.display = "none";
    }
});
/*_________________________________mais menos__________________________________________________*/
let minusBtn = document.getElementById("minus-btn");
let count = document.getElementById("count");
let plusBtn = document.getElementById("plus-btn");

let countNum = 1;
count.innerHTML = countNum;

minusBtn.addEventListener("click", () => {
    if(countNum>1) {
        countNum -= 1;
        count.innerHTML = countNum;
    }
});

plusBtn.addEventListener("click", () => {
    if(countNum<10){
        countNum += 1;
        count.innerHTML = countNum;
    }
});
/*_________________________________Preco__________________________________________________*/
window.onload = function(){
    slideOne();
    slideTwo();
    slideTr();
    slideFr();

}

let sliderOne = document.getElementById("slider_min_preco");
let sliderTwo = document.getElementById("slider_max_preco");
let displayValOne = document.getElementById("range_min_preco");
let displayValTwo = document.getElementById("range_max_preco");
let minGap = 0;
let sliderTrack_preco = document.querySelector(".slider-track-prco");
let sliderMaxValue = document.getElementById("slider_min_preco").max;

function slideOne(){
    if(parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap){
        sliderOne.value = parseInt(sliderTwo.value) - minGap;
    }
    displayValOne.textContent = sliderOne.value;
    fillColor_preco();
}
function slideTwo(){
    if(parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap){
        sliderTwo.value = parseInt(sliderOne.value) + minGap;
    }
    displayValTwo.textContent = sliderTwo.value;
    fillColor_preco();
}
function fillColor_preco(){
    percent1_preco = (sliderOne.value / sliderMaxValue) * 100;
    percent2_preco = (sliderTwo.value / sliderMaxValue) * 100;
    sliderTrack_preco.style.background = `linear-gradient(to right, #dadae5 ${percent1_preco}% , #000000 ${percent1_preco}% , #000000 ${percent2_preco}%, #dadae5 ${percent2_preco}%)`;
}
/*____________________________________Distance_______________________________________________*/
let sliderOne_dis = document.getElementById("slider_min_dis");
let sliderTwo_dis = document.getElementById("slider_max_dis");
let displayValOne_dis = document.getElementById("range_min_dis");
let displayValTwo_dis = document.getElementById("range_max_dis");
let minGap_dis = 0;
let sliderTrack_dis = document.querySelector(".slider-track-Dis");
let sliderMaxValue_dis = document.getElementById("slider_min_dis").max;

function slideTr(){
    if(parseInt(sliderTwo_dis.value) - parseInt(sliderOne_dis.value) <= minGap_dis){
        sliderOne_dis.value = parseInt(sliderTwo_dis.value) - minGap_dis;
    }
    displayValOne_dis.textContent = sliderOne_dis.value;
    fillColor_dis();
}
function slideFr(){
    if(parseInt(sliderTwo_dis.value) - parseInt(sliderOne_dis.value) <= minGap_dis){
        sliderTwo_dis.value = parseInt(sliderOne_dis.value) + minGap_dis;
    }
    displayValTwo_dis.textContent = sliderTwo_dis.value;
    fillColor_dis();
}
function fillColor_dis(){
    percent1_Dis = (sliderOne_dis.value / sliderMaxValue_dis) * 100;
    percent2_Dis = (sliderTwo_dis.value / sliderMaxValue_dis) * 100;
    sliderTrack_dis.style.background = `linear-gradient(to right, #dadae5 ${percent1_Dis}% , #000000 ${percent1_Dis}% , #000000 ${percent2_Dis}%, #dadae5 ${percent2_Dis}%)`;
}
/*____________________________________Distance_______________________________________________*/
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
    const button_mais = card.querySelector('.botao_mais');
    const cardfront = card.querySelector('.card-front');
    const cardback = card.querySelector('.card-back');
    const buttonMenos = card.querySelector('.botao_menos');

    button_mais.addEventListener('click', function() {
        if (cardfront.style.display === 'none') {
            cardfront.style.display = 'block';
            cardback.style.display = 'none';
        } else {
            cardfront.style.display = 'none';
            cardback.style.display = 'block';
        }
    });
    buttonMenos.addEventListener('click', function() {
        cardfront.style.display = 'block'; // Exibe o card frontal
        cardback.style.display = 'none'; // Oculta o card de trás
    });
});

const modal = document.getElementById("myModal");
const modalImg = document.getElementById("modalImage");
const closeBtn = document.querySelector(".close");

cards.forEach((card, index) => {
    card.querySelector('.card-image img').addEventListener("click", function() {
        modalImg.src = this.src;
        modal.style.display = "block";
        slideIndex = index;
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
///_____________________________________________________________________________________________________________________________________________
const removerLink = document.getElementById("Remover_bot");
const removerAlojamento = document.getElementById("Remover_alojamento");
const prencipal = document.getElementById("prencipal");
const AdicionarLink = document.getElementById("Adcionar_bot");
const AdicionarAlojamento = document.getElementById("Adicionar_selctor");
const ConversaLink = document.getElementById("Conversa_bot");
const Conversa_selctor = document.getElementById("Conversa");


removerLink.addEventListener("click", function() {
    if (removerAlojamento.style.display === 'block') {
        removerAlojamento.style.display = 'none';
        AdicionarAlojamento.style.display = 'none';
        Conversa_selctor.style.display = 'none';
        prencipal.style.display = 'block';
    } else {
        removerAlojamento.style.display = 'block';
        prencipal.style.display = 'none';
        Conversa_selctor.style.display = 'none';
        AdicionarAlojamento.style.display = 'none';
    }
});
///_____________________________________________________________________________________________________________________________________________
//________________________Table #2 Remover_______________________________________
const tabela_Remover = document.getElementById('tabela_remover');
const search_remover = document.getElementById('search_remover');
const search_re = search_remover.querySelector('.input-group input'),
    table_rows_re = tabela_Remover.querySelectorAll('tbody tr'),
    table_headings_re = tabela_Remover.querySelectorAll('thead th');


// 1. Searching for specific data of HTML table
search_re.addEventListener('input', searchTable_re);

function searchTable_re() {
    table_rows_re.forEach((row, i) => {
        let table_data = row.textContent.toLowerCase(),
            search_data = search_re.value.toLowerCase();

        row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
        row.style.setProperty('--delay', i / 25 + 's');
    })

    document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
        visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
    });
}

// 2. Sorting | Ordering data of HTML table

table_headings_re.forEach((head, i) => {
    let sort_asc = true;
    head.onclick = () => {
        table_headings_re.forEach(head => head.classList.remove('active'));
        head.classList.add('active');

        document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
        table_rows_re.forEach(row => {
            row.querySelectorAll('td')[i].classList.add('active');
        })

        head.classList.toggle('asc', sort_asc);
        sort_asc = head.classList.contains('asc') ? false : true;

        sortTable_re(tabela_Remover,i, sort_asc);
    }
})


function sortTable_re(tabela_re,column, sort_asc) {
    [...table_rows_re].sort((a, b) => {
        let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
            second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

        return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
    })
        .map(sorted_row => tabela_re.querySelector('tbody').appendChild(sorted_row));
}
//---------------------------------------------------------------------------------------------------

AdicionarLink.addEventListener("click", function() {
    if (AdicionarAlojamento.style.display === 'block') {
        removerAlojamento.style.display = 'none';
        AdicionarAlojamento.style.display = 'none';
        Conversa_selctor.style.display = 'none';
        prencipal.style.display = 'block';
    } else {
        AdicionarAlojamento.style.display = 'block';
        prencipal.style.display = 'none';
        Conversa_selctor.style.display = 'none';
        removerAlojamento.style.display = 'none';
    }
});
window.onload = function(){
    slideTr();
}
let sliderTwo_dis = document.getElementById("slider_min_dis");
let displayValTwo_dis = document.getElementById("range_max_dis");
let minGap_dis = 0;
let sliderTrack_dis = document.querySelector(".slider-track-Dis");
let sliderMaxValue_dis = document.getElementById("slider_min_dis").max;

function slideTr(){
    if(sliderTwo_dis.value>1000){
        document.getElementById("M_or_Km").textContent="Km";
        displayValTwo_dis.textContent=sliderTwo_dis.value/1000;
    }else{
        displayValTwo_dis.textContent = sliderTwo_dis.value;
    }
    fillColor_dis();
}
function fillColor_dis(){

    percent2_Dis = (sliderTwo_dis.value / sliderMaxValue_dis) * 100;
    sliderTrack_dis.style.background = `linear-gradient(to right, #000000 ${percent2_Dis}%, #dadae5 ${percent2_Dis}%)`;
}
let minusBtn = document.getElementById("minus-btn");
let count = document.getElementById("count");
let plusBtn = document.getElementById("plus-btn");

let countNum = 1;
count.innerHTML = countNum;

minusBtn.addEventListener("click", () => {
    if(countNum>1) {
        countNum -= 1;
        count.innerHTML = countNum;
    }
});

plusBtn.addEventListener("click", () => {
    if(countNum<10){
        countNum += 1;
        count.innerHTML = countNum;
    }
});
let title = document.querySelectorAll(".chat-list-header");
let totalHeight = 0;

for(let i = 0; i < title.length; i++){
    let totalHeight = 0;
    title[i].addEventListener("click", function(){
        let result = this.nextElementSibling;
        let activeSibling = this.nextElementSibling.classList.contains('active');
        this.classList.toggle('active');
        result.classList.toggle("active");
        if(!activeSibling) {
            for( i= 0; i < result.children.length; i++) {
                totalHeight = totalHeight +  result.children[i].scrollHeight + 40;
            }
        } else {
            totalHeight = 0;
        }
        result.style.maxHeight =  totalHeight + "px";
    });
}

const themeColors = document.querySelectorAll('.theme-color');

themeColors.forEach(themeColor => {
    themeColor.addEventListener('click', (e) => {
        themeColors.forEach(c => c.classList.remove('active'));
        const theme = themeColor.getAttribute('data-color');
        document.body.setAttribute('data-theme', theme);
        themeColor.classList.add('active');
    });
});

ConversaLink.addEventListener("click", function() {
    if (Conversa_selctor.style.display === 'block') {
        removerAlojamento.style.display = 'none';
        AdicionarAlojamento.style.display = 'none';
        Conversa_selctor.style.display = 'none';
        prencipal.style.display = 'block';
    } else {
        Conversa_selctor.style.display = 'block';
        removerAlojamento.style.display = 'none';
        prencipal.style.display = 'none';
        AdicionarAlojamento.style.display = 'none';
    }
});
document.getElementById("searchInput").addEventListener("input", function() {
    var input, filter, ul, li, name, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    ul = document.querySelector('.chat-list');
    li = ul.getElementsByTagName('li');

    for (i = 0; i < li.length; i++) {
        name = li[i].querySelector('.name');
        if (name) {
            txtValue = name.textContent || name.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = '';
            } else {
                li[i].style.display = 'none';
            }
        }
    }
});
