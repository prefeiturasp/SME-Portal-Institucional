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

    // Incluir mensagem no Upload de Arquivos
    jQuery(".uploader-inline-content").prepend( '<div class="alert-info grid-mode"><strong>AVISO!</strong> “Este não é um espaço de edição de documentos. Só se deve subir documentos finalizados e públicos. Aqui não serão mantidas diferentes versões de um mesmo documento, portanto, caso seja necessário, mantenha as versões guardadas em seu computador. Não é permitido subir cópias de livros! Respeite os direitos autorais”.</div>' );

    jQuery("#plupload-upload-ui").prepend( '<div class="alert-info media-new"><strong>AVISO!</strong> “Este não é um espaço de edição de documentos. Só se deve subir documentos finalizados e públicos. Aqui não serão mantidas diferentes versões de um mesmo documento, portanto, caso seja necessário, mantenha as versões guardadas em seu computador. Não é permitido subir cópias de livros! Respeite os direitos autorais”.</div>' );
});