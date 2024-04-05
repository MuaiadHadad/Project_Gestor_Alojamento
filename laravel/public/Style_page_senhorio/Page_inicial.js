//----------------------------------------menu---------------------------------------------------------
document.addEventListener("DOMContentLoaded", function() {
    var userDropdown = document.querySelector('.dropdown-menu-user-div-container');
    var dropdownMenu = document.querySelector('.dropdown-menu-user-div');

    userDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('show');
    });

    // Fechar o menu quando clicar fora dele
    document.addEventListener('click', function() {
        dropdownMenu.classList.remove('show');
    });

    // Evitar que o menu feche quando se clica dentro dele
    dropdownMenu.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
//________________________Table #1 Principal_______________________________________
const tabela_Principal= document.getElementById('tabela_List_anuncios');
const search_Principal = document.getElementById('search_tabela_List_anuncios');
const search = search_Principal.querySelector('.input-group input'),
    table_rows = tabela_Principal.querySelectorAll('tbody tr'),
    table_headings = tabela_Principal.querySelectorAll('thead th');


// 1. Searching for specific data of HTML table
search.addEventListener('input', searchTable);

function searchTable() {
    table_rows.forEach((row, i) => {
        let table_data = row.textContent.toLowerCase(),
            search_data = search.value.toLowerCase();

        row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
        row.style.setProperty('--delay', i / 25 + 's');
    })

    document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
        visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
    });
}

// 2. Sorting | Ordering data of HTML table

table_headings.forEach((head, i) => {
    let sort_asc = true;
    head.onclick = () => {
        table_headings.forEach(head => head.classList.remove('active'));
        head.classList.add('active');

        document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
        table_rows.forEach(row => {
            row.querySelectorAll('td')[i].classList.add('active');
        })

        head.classList.toggle('asc', sort_asc);
        sort_asc = head.classList.contains('asc') ? false : true;

        sortTable(tabela_Principal,i, sort_asc);
    }
})


function sortTable(tabela,column, sort_asc) {
    [...table_rows].sort((a, b) => {
        let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
            second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

        return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
    })
        .map(sorted_row => tabela.querySelector('tbody').appendChild(sorted_row));
}
