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
