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
