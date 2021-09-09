window.onload = function() {
	gridify.init();
};

var $s = jQuery.noConflict();

function validaNome(){
    var name = document.getElementById('name').value;
    const [first, last] = name.split(' ');

    if(first && last){
        if(first.length < 3 || last.length < 3 ) {
            $s('#name').removeClass('is-valid');
            $s('#name').addClass('is-invalid');
            event.preventDefault();
        } else {
            $s('#name').removeClass('is-invalid');
            $s('#name').addClass('is-valid');
            return true;
        }
    } else {
        $s('#name').removeClass('is-valid');
        $s('#name').addClass('is-invalid');
        event.preventDefault();
    }
    
}

function validaTelefone(){
    var tel = $s('#inputTelefone').val().length;
    if(tel < 15){
        $s('#inputTelefone').removeClass('is-valid');
        $s('#inputTelefone').addClass('is-invalid');
        event.preventDefault();
    } else {
        $s('#inputTelefone').removeClass('is-invalid');
        $s('#inputTelefone').addClass('is-valid');
        return;
    }
}

function validaTitulo(){
    var tel = $s('#inputTitulo').val().length;
    if(tel < 5){
        $s('#inputTitulo').removeClass('is-valid');
        $s('#inputTitulo').addClass('is-invalid');
        event.preventDefault();
    } else {
        $s('#inputTitulo').removeClass('is-invalid');
        $s('#inputTitulo').addClass('is-valid');
        return;
    }
}

function validaLink(){
    var link = $s('#inputLink').val();
    if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(link)){
        $s('#inputLink').removeClass('is-invalid');
        $s('#inputLink').addClass('is-valid');
        return;
    } else {
        $s('#inputLink').removeClass('is-valid');
        $s('#inputLink').addClass('is-invalid');
        event.preventDefault();
    }
}

function validaCategoria(){
    var categoria = $s('#inputCategoria').val().length;
    if(categoria == 0){
        $s('#inputCategoria').removeClass('is-valid');
        $s('#inputCategoria').addClass('is-invalid');
        event.preventDefault();
    } else {
        $s('#inputCategoria').removeClass('is-invalid');
        $s('#inputCategoria').addClass('is-valid');
    }
}

function validaConteudo(){
    var content = $s('#quebradaDescri').val().length;
    if(content < 10 || content > 300){
        $s('#quebradaDescri').removeClass('is-valid');
        $s('#quebradaDescri').addClass('is-invalid');
        event.preventDefault();
    } else {
        $s('#quebradaDescri').removeClass('is-invalid');
        $s('#quebradaDescri').addClass('is-valid');
    }
}

function validaTermos(){
    
    if($s('#gridCheck:checked').length <= 0) {
        $s('#gridCheck').removeClass('is-valid');
        $s('#gridCheck').addClass('is-invalid');
        event.preventDefault();
    } else {
        $s('#gridCheck').removeClass('is-invalid');
        $s('#gridCheck').addClass('is-valid');
        return;
    }
        
}

function validaFormato(){
    var campo = $s('#validatedCustomFile').val();
    if(campo == ''){
        $s('#alert').html('Insira um arquivo.');
        $s('#validatedCustomFile').removeClass('is-valid');
        $s('#validatedCustomFile').addClass('is-invalid');
        event.preventDefault();
    } else {
        var numb = $s('#validatedCustomFile')[0].files[0].size/1024/1024; //count file size
        var resultid = $s('#validatedCustomFile').val().split(".");
        var gettypeup  = resultid [resultid.length-1]; // take file type uploaded file
        var filetype = $s('#validatedCustomFile').attr('data-file_types'); // take allowed files from input
        var allowedfiles = filetype.replace(/\|/g,', '); // string allowed file
        var tolovercase = gettypeup.toLowerCase();
        var filesize = 25; //25MB
        var onlist = $s('#validatedCustomFile').attr('data-file_types').indexOf(tolovercase) > -1;
        var checkinputfile = $s('#validatedCustomFile').attr('type');
        numb = numb.toFixed(2);

        if (onlist && numb <= filesize) {
                $s('#alert').html('The file is ready to upload'); //file OK
                $s('#validatedCustomFile').removeClass('is-invalid');
                $s('#validatedCustomFile').addClass('is-valid');
        } else {

            if(numb >= filesize && onlist){

                $s('#validatedCustomFile').val(''); //remove uploaded file
                $s('#alert').html('Tamanho de arquivo inválido \(' + numb + ' MB\) - Tamanho máximo permitido '+ filesize +' MB'); //alert that file is too big, but type file is ok
                $s('#validatedCustomFile').removeClass('is-valid');
                $s('#validatedCustomFile').addClass('is-invalid');
                event.preventDefault();

            } else if(numb < filesize && !onlist) {

                $s('#validatedCustomFile').val(''); //remove uploaded file
                $s('#alert').html('Formato de arquivo inválido \('+ gettypeup +') - Formatos permitidos: ' + allowedfiles); //wrong type file
                $s('#validatedCustomFile').removeClass('is-valid');
                $s('#validatedCustomFile').addClass('is-invalid');
                event.preventDefault();

            } else if(!onlist) {

                $s('#validatedCustomFile').val(''); //remove uploaded file
                $s('#alert').html('Formato de arquivo inválido \('+ gettypeup +') - Formatos permitidos: ' + allowedfiles); //wrong type file
                $s('#validatedCustomFile').removeClass('is-valid');
                $s('#validatedCustomFile').addClass('is-invalid');
                event.preventDefault();

            }
        }
    }
    
    
}

$s(function() {
       
    // Validar nome e sobrenome
    $s('#name').focusout( function(){
        validaNome();
    } );

    // Validar telefone
    $s('#inputTelefone').focusout(function() {
        validaTelefone();
    });

    // mascara telefone
    $s('#inputTelefone').mask('(00) 00000-0000');

    // Validar titulo
    $s('#inputTitulo').focusout(function() {
        validaTitulo();
    });

    // Validar link
    $s('#inputLink').focusout(function() {
        var link = $s('#inputLink').val().length;
        if(link == 0){
            $s('#inputLink').removeClass('is-invalid');
        } else {
            validaLink();            
        }
    });

    // Validar Categoria
    $s('#inputCategoria').blur(function() {
        validaCategoria();
    });

    $s('#quebradaDescri').focusout(function() {
        validaConteudo();
    });

    // Validar Formato
    $s('#validatedCustomFile').on('change', function() {
        validaFormato();
    });
});

function validate(){
    
    validaCategoria(); // Validar Categoria
    validaNome(); // Validar Nome
    validaTelefone(); // Validar Telefone
    validaTitulo(); // Validar Titulo
    validaFormato(); // Validar Formato
    validaConteudo(); // Validar Conteudo
    validaTermos();
    var linkValidar = $s('#inputLink').val().length;
    if(linkValidar == 0){
        $s('#inputLink').removeClass('is-invalid');
    } else {
        validaLink();            
    }

    //event.preventDefault();
}