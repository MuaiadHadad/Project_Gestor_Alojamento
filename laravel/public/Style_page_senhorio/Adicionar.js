document.getElementById('TypeOfRentSlector').addEventListener('change', function() {
    var selecionado = this.value;

    // Oculta todas as listas
    document.getElementById('Casacompleta').style.display = 'none';
    document.getElementById('Porquarto').style.display = 'none';

    // Mostra a lista selecionada
    document.getElementById(selecionado).style.display = 'block';
});
//-------------------------------------------------------------------------------------------------------------
document.getElementById('N_quartos').addEventListener('change', function() {
    var selecionado = this.value;
    var container = document.getElementById("quartos");

    for(i=1;i <= selecionado;i++) {
        var novoHTML = ` <div class="submit_1 clearfix">
            <h4 class="mgt col_1">Dados do quarto #` + i + ` </h4>
            <hr>
            <div class="submit_1i clearfix">
                <div class="col-sm-6 space_right">
                    <div class="submit_1i1 clearfix">
                        <h5>Area M<sub>2</sub></h5>
                        <input class="form-control" placeholder="m2" type="text">
                    </div>
                </div>
            </div>
            <div class="submit_2i clearfix">
                <h5><input type="checkbox"> <span class="span_1">roupa de cama</span></h5>
                <h5><input type="checkbox"> <span class="span_1">cama</span></h5>
                <h5><input type="checkbox"> <span class="span_1">mesa cabeceira</span></h5>
                <h5><input type="checkbox"> <span class="span_1">Candeeiro de mesa do estudo</span></h5>
                <h5><input type="checkbox"> <span class="span_1">Mesa do estudo</span></h5>
                <h5><input type="checkbox"> <span class="span_1">Janelas</span></h5>
                <h5><input type="checkbox"> <span class="span_1">Varanda</span></h5>
                <h5><input type="checkbox"> <span class="span_1">Armário</span></h5>
                <h5><input type="checkbox"> <span class="span_1">Casa de banho privativa</span></h5>
            </div>
            </div>
        `;

        // Inserindo o novo HTML dentro do elemento container
        container.innerHTML += novoHTML;
        document.getElementById("quartos").style.display = 'block';
        document.getElementById("Selector_quartos").style.display = 'none';
        document.getElementById('Porquarto').style.display = 'none';

    }

});
var uploadArea = document.getElementById('uploadAreaQuarto');
var fileInput = document.getElementById('fileInputQuarto');
var fileList = document.getElementById('fileList');

// Evento de clique para abrir o seletor de arquivos
uploadArea.addEventListener('click', function() {
    fileInput.click();
});

// Evento de drop para lidar com os arquivos soltos
uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var files = e.dataTransfer.files;
    handleFiles(files);
});

// Lidar com os arquivos selecionados
fileInput.addEventListener('change', function() {
    var files = this.files;
    handleFiles(files);
});

// Função para lidar com os arquivos
function handleFiles(files) {

    // Para cada arquivo, cria um elemento de imagem e exibe-o
    for (var i = 0; i < files.length; i++) {
        var imgContainer = document.createElement('div');
        var img = document.createElement('img');
        img.src = URL.createObjectURL(files[i]);
        img.width = 150; // Defina a largura da imagem conforme necessário
        img.height = 150; // Defina a altura da imagem conforme necessário
        img.title=files[i].name;
        img.className="img_upload";
        fileList.appendChild(img);

        var removeIcon = document.createElement('i');
        removeIcon.className = 'fa fa-close fa-x2';
        removeIcon.style='padding-top: -50px; padding-bottom: 0px; position: absolute;';
        removeIcon.addEventListener('click', function() {
            fileList.removeChild(img);
            fileList.removeChild(removeIcon);
        });
        fileList.appendChild(removeIcon);

    }
}

// Impedir comportamentos padrão de arrastar e soltar
uploadArea.addEventListener('dragenter', function(e) {
    e.preventDefault();
    e.stopPropagation();
});

uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
});
//----------------------------------------------------------------------------------------------
document.getElementById('slectorDistncia').addEventListener('change', function() {
    var selecionado_dis = this.value;

    // Oculta todas as listas
    document.getElementById('distancia_manual').style.display = 'none';
    document.getElementById('distancia_por_map').style.display = 'none';

    // Mostra a lista selecionada
    document.getElementById(selecionado_dis).style.display = 'block';
});
//----------------------------------------------------------------------------------------------
document.getElementById('slectorDistnciaPorQuarto').addEventListener('change', function() {
    var selecionado_dis_PorQuarto = this.value;

    // Oculta todas as listas
    document.getElementById('distancia_manualPorQuarto').style.display = 'none';
    document.getElementById('distancia_por_mapPorQuarto').style.display = 'none';

    // Mostra a lista selecionada
    document.getElementById(selecionado_dis_PorQuarto).style.display = 'block';
});
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
var uploadAreaPorQuarto = document.getElementById('uploadArea');
var fileInputPorQuarto = document.getElementById('fileInput');
var fileListPorQuarto = document.getElementById('fileListPorQuarto');

// Evento de clique para abrir o seletor de arquivos
uploadAreaPorQuarto.addEventListener('click', function() {
    fileInputPorQuarto.click();
});

// Evento de drop para lidar com os arquivos soltos
uploadAreaPorQuarto.addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var files = e.dataTransfer.files;
    handleFilesPorQuarto(files);
});

// Lidar com os arquivos selecionados
fileInputPorQuarto.addEventListener('change', function() {
    handleFilesPorQuarto(this.files);
});

// Função para lidar com os arquivos
function handleFilesPorQuarto(files) {

    // Para cada arquivo, cria um elemento de imagem e exibe-o
    for (var i = 0; i < files.length; i++) {
        var imgContainer = document.createElement('div');
        var img = document.createElement('img');
        img.src = URL.createObjectURL(files[i]);
        img.width = 150; // Defina a largura da imagem conforme necessário
        img.height = 150; // Defina a altura da imagem conforme necessário
        img.title=files[i].name;
        img.className="img_upload";
        fileListPorQuarto.appendChild(img);

        var removeIcon = document.createElement('i');
        removeIcon.className = 'fa fa-close fa-x2';
        removeIcon.style='padding-top: -50px; padding-bottom: 0px; position: absolute;';
        removeIcon.addEventListener('click', function() {
            fileListPorQuarto.removeChild(img);
            fileListPorQuarto.removeChild(removeIcon);
        });
        fileListPorQuarto.appendChild(removeIcon);

    }
}

// Impedir comportamentos padrão de arrastar e soltar
uploadAreaPorQuarto.addEventListener('dragenter', function(e) {
    e.preventDefault();
    e.stopPropagation();
});

uploadAreaPorQuarto.addEventListener('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
});
