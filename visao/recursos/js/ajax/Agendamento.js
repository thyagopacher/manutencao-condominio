function imprimirCalendario(){
    // save current calendar width
    w = $('#calendar').css('width');

    // prepare calendar for printing
    $('#calendar').css('width', '100%');
    $('.fc-header').hide();  
    $('#calendar').fullCalendar('render');

    window.print();

    // return calendar to original, delay so the print processes the correct width
    window.setTimeout(function() {
        $('.fc-header').show();
        $('#calendar').css('width', '100%');
        $('#calendar').fullCalendar('render');
    }, 1000);
}

function escolheEquipamento(){
    var periodo = $("#codequipamento option:selected").attr("periodo");
    var servico = $("#codequipamento option:selected").attr("codservico");
    var imagem  = $("#codequipamento option:selected").attr("imagem");
    if(periodo != "1"){
        $("#div_data_final").show();
        $("#datafim").attr("required", true);
    }else{
        $("#div_data_final").hide();
        $("#datafim").attr("required", false);
    }
    if(servico != null && servico != "" && $("#codmanutencao").val() == ""){
        var array_separa = servico.split(',');
        $('.selectpicker').selectpicker('val', array_separa);
    }
    if($("#div_imagem").length){
        $("#div_imagem").remove();
    }
    if(imagem != null && imagem != ""){
        $("#div_form").append('<div id="div_imagem" class="form-group"><img style="width: 150px;" src="/arquivos/'+imagem+'" alt="img sistema"/></div>');
    }else{
        $("#div_form").append('<div id="div_imagem" class="form-group"><img style="width: 150px;" src="/visao/recursos/img/sem_imagem.png" alt="img sistema"/></div>');
    }
}

$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        // put your options and callbacks here
        lang: 'pt-br',
        locale: 'pt-br',
        events: '/control/EventosManutencao.php'
    });
    
    $("#codequipamento").change(function(){
        escolheEquipamento();
    });

    
    var progress = $(".progress");
    var progressbar = $("#progressbar");
    var sronly = $("#sronly");    

    $("#fagendamento").submit(function () {
        progress.css("visibility", "visible");
    });

    $('#fagendamento').ajaxForm({
        beforeSend: function () {
            progress.show();
            var percentVal = '0%';
            progressbar.width(percentVal);
            sronly.html(percentVal + ' Completo');        
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            progressbar.width(percentVal);
            sronly.html(percentVal + ' Completo');              
        },
        success: function () {
            var percentVal = '100%';
            progressbar.width(percentVal);
            sronly.html(percentVal + ' Completo');            
        },
        complete: function (xhr) {
            var data = JSON.parse(xhr.responseText);
            if (data.situacao === true) {
                swal("Cadastro", data.mensagem, "success");
                setTimeout('location.href = "Agendamento.php"', 3000);
                //setTimeout('location.reload();', 1500);
            } else if (data.situacao === false) {
                swal("Erro", data.mensagem, "error");
            }else{
                swal("Erro", "Ocorreu algum erro na requisição da chamada!", "error");
            }
            progressbar.hide();
        }
    });
});