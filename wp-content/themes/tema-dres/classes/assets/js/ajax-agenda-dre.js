jQuery(document).ready(function ($) {

    var primeiro_clique = false;

    var date = moment().locale('pt-br'); //Get the current date
    var data_formatada = date.format('dddd[,] D [de] MMMM [de] YYYY'); //2014-07-10
    $('.data_agenda').html(data_formatada);
    var data_para_funcao = moment(date).format('YYYYMMDD');

    var div_com_array_datas = $('#array_datas_agenda');

    // Para input
    var array_datas_agenda = div_com_array_datas.val();

    //Para Div
    //var array_datas_agenda = div_com_array_datas.text();
	
    if (array_datas_agenda) {
        var datas_agendas = JSON.parse(array_datas_agenda);
		
        div_com_array_datas.remove();
    }
	
datas_agendas
    redebe_data(data_para_funcao);
	

    $('.calendario-agenda-sec').ionCalendar({
        lang: "pt-br",
        years: "1",

        onReady: function(){
            getAnoMesCalendario()
        },

        onClick: function (date) {
            primeiro_clique = true;
            moment.locale('pt-br');
            $('.data_agenda').html(moment(date).format('dddd[,] D [de] MMMM [de] YYYY'));
            let data_pt_br = moment(date).format('YYYYMMDD');
			var data = new Date();
			var data_atual = moment(data).format('YYYYMMDD');
			var data_clicada = moment(date).format('YYYYMMDD');

            if (data_atual === data_clicada){
                primeiro_clique = false;
            }

			$(".agenda-ordenada").html("");
			
            redebe_data(data_pt_br);
        }
    });

    function getAnoMesCalendario() {
		
        if (primeiro_clique){
            $( ".ic__day_state_current" ).each(function( index ) {
                $( this ).removeClass("ic__day_state_current");
                $(".pagination").html("");
            });
        }

        var selectedAno= $('.ic__year-select').children("option:selected").val();

        var selectedMes= $('.ic__month-select').children("option:selected").val();
        var selectedMes= parseInt(selectedMes)+1;
        if (selectedMes <= 9){
            var selectedMes= '0'+selectedMes;
        }else {
            var selectedMes= selectedMes.toString();
        }

        $('.ic__day').each(function (e) {

            var dia_corrente = parseInt(this.textContent);
            if (dia_corrente <= 9) {
                dia_corrente = '0' + dia_corrente;
            }else {
                dia_corrente = dia_corrente.toString();
            }
            var data_completa = dia_corrente+'/'+selectedMes+'/'+selectedAno;

            var classe_css = '';
            if (dia_corrente <= '09'){
                classe_css = 'destaque-evento-agenda-menor-que-10';
				//this.innerHTML = '<span class="'+ classe_css +'">'+this.textContent+'</span>';
            }else{
                classe_css = 'destaque-evento-agenda';
				//this.innerHTML = '<span class="'+ classe_css +'">'+this.textContent+'</span>';
            }

            if(jQuery.inArray( data_completa, datas_agendas) >= 0 ){
                this.innerHTML = '<span class="'+ classe_css +'">'+this.textContent+'</span>';
            }
        });
    }

    function redebe_data(data_recebida) {
        var conteudo_a_ser_exibido = $('#mostra_data');

        jQuery.ajax({
            url: bloginfo.ajaxurl,
            type: 'post',
            data: {
                // você sempre deve passar o parâmetro 'action' com o nome da função que você criou no seu functions.php ou outro que você esteja incluindo nele
                action: 'montaHtmlListaEventos',
                data_pt_br: data_recebida,
            },

            success: function (data) {
                var $data = $(data);
                conteudo_a_ser_exibido.html($data);
				var atual = new Date();
				var data_atual = moment(atual).format('YYYYMMDD');
				//////////////////////////////////
				//////////////////////////////////
				//////////////////////////////////
				//////////////////////////////////
				//verifica se já tem evento listado
				if ( $("#eventos-agenda").length ){
					//conta a quantidade de eventos listados
					$('.agenda-ordenada').each(function(){
                        $(this).data('childs', $(this).children('.agenda').size());
					})
                    //verifica se tem conteudo
					if(($('.agenda-ordenada:eq(0)').data('childs'))>1){

                        pageSize = 2;

                        var pageCount = $('.agenda-ordenada:eq(0)').data('childs');
                        var pagTotal = Math.ceil(pageCount / pageSize ) ;
                        for(var i = 0 ; i<pagTotal;i++){
                           $("#pagin").append('<li class="page-item"><a class="page-link" href="#">'+(i+1)+'</a></li> ');
                        }
                        $("#pagin li").first().addClass("active")
                        showPage = function(page) {
                            $(".agenda").hide();
                            $(".agenda").each(function(n) {
                                if (n >= pageSize * (page - 1) && n < pageSize * page)
                                    $(this).show();
                            });
                        }
                        showPage(1);

                        $("#pagin li").click(function() {
                            $("#pagin li").removeClass("active");
                            $(this).addClass("active");
                            showPage(parseInt($(this).text()))
                        });

					}
				}
				//////////////////////////////////
				//////////////////////////////////	
				//////////////////////////////////	
				//////////////////////////////////	
            },
        });
    }
});