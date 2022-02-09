jQuery(document).ready(function ($) {
    // Inclui html tooltip
    $( ".login-username label" ).append( ' <i class="fa fa-question-circle-o" aria-hidden="true"></i>' );
    
    // Ativa o tooltipo
    $(".fa-question-circle-o").tooltip({
        title: "Digite, sem ponto nem traço, os 7 dígitos do RF para Servidor, ou 11 do CPF para usuário não servidor. Caso não possua, procure sua chefia ou a SME",
        //template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner" style="max-width: none;"></div></div>',
    });

    // Inclui placeholder nos inputs de login
    $("#user").attr("placeholder", "Informe o RF do usuário");
    $("#pass").attr("placeholder", "Informe sua senha");

    // Inclui botao hide/show no campo de senha
    $(".login-password").append('<i class="fa fa-eye-slash" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>');

    // Inclui campo de erro
    $(".login-username").append('<span class="login-error">Campo obrigatório</span>');
    $(".login-password").append('<span class="pass-error">Campo obrigatório</span>');

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#pass');
    
    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });

    $('#user').blur(function(){
        if(!$(this).val()){
            $(this).addClass("error");
            $('.login-error').css('display', 'block');
        } else{
            $(this).removeClass("error");
            $('.login-error').hide();
        }
    });

    $('#pass').blur(function(){
        if(!$(this).val()){
            $(this).addClass("error");
            $('.pass-error').css('display', 'block');
        } else{
            $(this).removeClass("error");
            $('.pass-error').hide();
        }
    });

    $( "#wp-submit" ).click(function() {       

        if(!$('#user').val()){
            $('#user').addClass("error");
            $('.login-error').css('display', 'block');
            event.preventDefault();
        } else{
            $('#user').removeClass("error");
            $('.login-error').hide();
        }

        if(!$('#pass').val()){
            $('#pass').addClass("error");
            $('.pass-error').css('display', 'block');
            event.preventDefault();
        } else{
            $('#pass').removeClass("error");
            $('.pass-error').hide();
        }
        
    });
});