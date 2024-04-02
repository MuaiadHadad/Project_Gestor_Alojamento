//------------------------------------------edit profil--------------------------------------------------
function toggleEdit() {
    var divProfile = document.getElementById("div_profile");
    var divEdit = document.getElementById("div_edit");
    var divEditPart2 = document.getElementById("div_edit_part2");
    var foto = document.getElementById("foto");
    var uploadfoto = document.getElementById("upload_foto");
    if (divProfile.style.display === "block") {
        divProfile.style.display = "none";
        foto.style.display = "none";
        divEdit.style.display = "block";
        divEditPart2.style.display = "block";
        uploadfoto.style.display = "block";
    } else {
        divProfile.style.display = "block";
        foto.style.display = "block";
        divEdit.style.display = "none";
        divEditPart2.style.display = "none";
        uploadfoto.style.display = "none";
    }
}

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
}
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
