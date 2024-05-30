
function checkImageSize() {
    var fileInput = document.getElementById('PrdImageId');
    var file = fileInput.files[0];
    
    if (file) {
        var fileSize = file.size; 
        var maxSize = 41943039; 

        if (fileSize > maxSize) {

            document.getElementById('erro').innerText = 'Imagem enviada é muito pesada, tamanho maximo de 40mb';

            fileInput.value = '';

            return false;
        }
    }
    return true;
}


document.getElementById('AddPrd').addEventListener('submit', function(event) {
    // Verifica o tamanho da imagem antes de enviar o formulário
    if (!checkImageSize()) {
        // Cancela o envio do formulário se o tamanho da imagem for muito grande
        event.preventDefault();
    }
});
