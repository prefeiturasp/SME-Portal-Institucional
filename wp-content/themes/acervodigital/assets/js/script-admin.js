//alert('Aviso admin');
jQuery(document).ready(function() {

    // Exibe a mensagem se o botao de remover for ativo
    jQuery(".-cancel").click(function() {
        jQuery(".acf-field.hide-message .description").show();
    });

    // Inclui o id no arquivo na url da biblioteca
    var dataId = jQuery("input[data-name='id']").val();
    if (dataId) {
        var href = jQuery('.link-archive').attr('href');
        jQuery(".link-archive").attr("href", href + dataId);
    }
});