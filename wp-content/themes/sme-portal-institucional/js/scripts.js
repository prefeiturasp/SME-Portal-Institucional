/*Anima Menu
/*Verifico o tamanho da tela, se for maior que 992 crio e add a classe que contem a animação ao hover do li do wp-nav-menu*/
var $s = jQuery.noConflict();

/*Ativacao Hamburger Menu Icons*/
$s(document).ready(function(){
    $s('#nav-icon1, #nav-icon2, #nav-icon3, #nav-icon4').click(function(){
        $s(this).toggleClass('open');
    });
});


/*Scripts para o Botao Voltar ao topo aparecer somente quando tiver rolagem para baixo*/
$s(function() {
    $s(window).scroll(function() {
        if($s(this).scrollTop() != 0) {
            $s('#toTop').fadeIn();
        } else {
            $s('#toTop').fadeOut();
        }
    });
    $s('#toTop').click(function() { $s('body,html').animate({scrollTop:0},800); });
});

function removeBackgroundColor(id_link_atual){
    $s('.container-a-icones-home').each(function (e) {
        var id_li_atual = this.id;
        if (id_li_atual != id_link_atual ){
            $s(this).css('background-color', 'white')
        }
    })
}

$s(document).ready(function(){
    $s( ".a-icones-home" ).each(function( index ) {
        $s(this).click(function (e) {
            var id_link_atual = e.currentTarget.id;
            var elemento_pai = $s(this).parent();
            elemento_pai.css('background-color', '#EAEAEA');
            removeBackgroundColor(id_link_atual);
        });
    });
});


/*Ativação do Tool Tip Bootstrap*/
$s(document).ready(function() {
    $s(function () {
        $s('[data-toggle="tooltip"]').tooltip({html:true})
    });
});

/* Ativacao Wow*/
new WOW().init();
