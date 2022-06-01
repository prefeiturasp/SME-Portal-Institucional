jQuery( document ).ready(function() {
    jQuery("#parent_id").chosen({
        search_contains: true,
        no_results_text: "Nenhum resultado encontrado para "
    });
});

jQuery(document).ready(function(){
    var valorLoad = jQuery('#acf-field_628fca507d189').val();
    //jQuery('#acf-field_628e4080d3c88').get(0).type = 'hidden';
    jQuery('#acf-field_628e4080d3c88').val(valorLoad);
    jQuery('#acf-field_628d3c7dbd459').attr('disabled', 'disabled');
});

var $s = jQuery.noConflict();

$s('#attachment_alt').each(function() {
    var textbox = $s(document.createElement('textarea')).val(this.value);
    console.log(this.attributes);
    $s.each(this.attributes, function() {
        if (this.specified) {
            textbox.prop(this.name, this.value)
        }
    });
    $s(this).replaceWith(textbox);
});

$s('#attachment-details-two-column-alt-text').each(function() {
    var textbox = $s(document.createElement('textarea')).val(this.value);
    console.log(this.attributes);
    $s.each(this.attributes, function() {
        if (this.specified) {
            textbox.prop(this.name, this.value)
        }
    });
    $s(this).replaceWith(textbox);
});

window.onload = function() {
    var $div = $s("#__wp-uploader-id-0");
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === "class") {

                //var attributeValue = $s(mutation.target).prop(mutation.attributeName);
                //console.log("Class attribute changed to:", attributeValue);

                $s("[aria-controls='alt-text-description']").each(function() {
                    var textbox = $s(document.createElement('textarea')).val(this.value);
                    //console.log(this.attributes);
                    $s.each(this.attributes, function() {
                        if (this.specified) {
                            textbox.prop(this.name, this.value)
                        }
                    });
                    $s(this).replaceWith(textbox);
                });
            }
        });
    });
    observer.observe($div[0], {
        attributes: true
    });
}