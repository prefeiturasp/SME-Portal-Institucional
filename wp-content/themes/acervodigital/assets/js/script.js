//search hide and show
jQuery(document).ready(function(){
  jQuery("#hide").click(function(){
	  jQuery("#simpleform").show();
	  jQuery("#advancedform").hide();
  });
  jQuery("#show").click(function(){
	  jQuery("#simpleform").hide();
	  jQuery("#advancedform").show();
  });
});


//remove duplicados da lista de ano de publicação
var code = {};
jQuery("select[id='ano_select'] > option").each(function () {
    if(code[this.text]) {
        jQuery(this).remove();
    } else {
        code[this.text] = this.value;
    }
});
var code2 = {};
jQuery("select[id='ano_select_box'] > option").each(function () {
    if(code2[this.text]) {
        jQuery(this).remove();
    } else {
        code2[this.text] = this.value;
    }
});