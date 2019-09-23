jQuery(document).ready(function ($) {

    var date = moment().locale('pt-br'); //Get the current date
    var data_formatada = date.format('dddd[,] D [de] MMMM [de] YYYY'); //2014-07-10
    $('.data_agenda').html(data_formatada);
    var data_para_funcao = moment(date).format('YYYYMMDD');

    var datas_agendas;
    datas_agendas = JSON.parse($('#array_datas_agenda').val());

    redebe_data(data_para_funcao);

    $('.calendario-agenda-sec').ionCalendar({
        lang: "pt-br",
        years: "1",

        onReady: function(){
            getAnoMesCalendario()
        },

        onClick: function (date) {
            moment.locale('pt-br');
            $('.data_agenda').html(moment(date).format('dddd[,] D [de] MMMM [de] YYYY'));
            let data_pt_br = moment(date).format('YYYYMMDD');
            redebe_data(data_pt_br);
       }
    });

    function getAnoMesCalendario() {
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
            if(jQuery.inArray( data_completa, datas_agendas) >= 0 ){
                this.innerHTML = '<span class="destaque-evento-agenda">'+this.textContent+'</span>';
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
            },
        });
    }
});