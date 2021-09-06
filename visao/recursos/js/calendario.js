/* 
 * @author Thyago Henrique Pacher - thyago.pacher@gmail.com
 */
function hoje() {
    var hoje = new Date();
    var mes = hoje.getMonth() + 1;
    if (mes < 10) {
        mes = '0' + mes;
    }
    var dia = hoje.getDay() + 1;
    if (dia < 10) {
        dia = '0' + dia;
    }
    return hoje.getFullYear() + '-' + mes + '-' + dia;
}

function addLeadingZero(num) {
    if (num < 10) {
        return "0" + num;
    } else {
        return "" + num;
    }
}

function LimparReserva() {
    $("input[type=text]").val("");
    $("input[type=number]").val("");
    $("#actVoltarReservas").hide();
    $(":checkbox").each(function () {
        $(this).prop({checked: false})
    });
}

function montaCalendario(eventosData) {
    $(".responsive-calendar").responsiveCalendar({
        //events são os eventos marcados no calendário
        onDayClick: function (events) {
            var data1 = addLeadingZero($(this).data("year")) + '-' + addLeadingZero($(this).data("month")) + '-' + addLeadingZero($(this).data("day"));
            var data2 = addLeadingZero($(this).data("day")) + '/' + addLeadingZero($(this).data("month")) + '/' + addLeadingZero($(this).data("year"));

            var res = verificarDataMaior($("#hoje").val(), data1);
            if (res == false) {
                swal("Atenção", "Reserva não pode ser no passado" , "info");
            } else {

                LimparReserva();
                $("#freserva").css("display", "");
                $("#btVoltarReservas").hide();
                $(".responsive-calendar").css("display", "none");

                $("#dataAmericano").val(data1);
                $("#dataBrasil").val(data2);
                $("#dataEscolhida").val(data1);
                
                valorAmbiente();
            }
        },
        time: hoje(),
        events: JSON.parse(eventosData)
    });
}
