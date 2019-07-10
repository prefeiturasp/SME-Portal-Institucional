jQuery(document).ready(function ($) {

    var date = moment().locale('pt-br'); //Get the current date
    var data_formatada = date.format('dddd[,] D [de] MMMM [de] YYYY'); //2014-07-10
    $('.data_agenda').html(data_formatada);
    var data_para_funcao = moment(date).format('YYYYMMDD');

    redebe_data(data_para_funcao);

    $('.calendario-agenda-sec').ionCalendar({
        lang: "pt-br",
        years: "1",

        onClick: function (date) {
            moment.locale('pt-br');
            $('.data_agenda').html(moment(date).format('dddd[,] D [de] MMMM [de] YYYY'));
            let data_pt_br = moment(date).format('YYYYMMDD');

            //debugger;

            redebe_data(data_pt_br);
       }
    });

    function redebe_data(data_recebida) {

        var conteudo_a_ser_exibido = $('#mostra_data');

        //console.log('Ollyver ' + data_recebida);

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