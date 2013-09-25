function b() {
    // Datepick script adaptado
    var startDateTextBox = $('#dataIda');
    var endDateTextBox = $('#dataVolta');

    $.datepicker.regional['pt-BR'] = $.datepick.regional['pt-BR'];
    $.datepicker.setDefaults({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior',
        timeOnlyTitle: 'Apenas tempo',
        timeText: 'Tempo',
        hourText: 'Hora',
        minuteText: 'Minuto',
        secondText: 'Segundo',
        millisecText: 'Milisegundo',
        timezoneText: 'Região',
        timeFormat: 'HH:mm',
        amNames: ['AM', 'A'],
        pmNames: ['PM', 'P'],
        isRTL: false
    });

    startDateTextBox.datetimepicker({
        altField: "#horaIda",
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = obterHoraIda();
                var testEndDate = obterHoraVolta();
                if (testStartDate > testEndDate)
                    endDateTextBox.datetimepicker('setDate', testStartDate);
            }
            else {
                endDateTextBox.datetimepicker('setDate', obterHoraIda());
            }
        },
        onSelect: function(selectedDateTime) {
            var data = obterHoraIda();
            endDateTextBox.datetimepicker('option', 'minDate', data);
        }
    });

    endDateTextBox.datetimepicker({
        altField: "#horaVolta",
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = obterHoraIda();
                var testEndDate = obterHoraVolta();
                if (testStartDate > testEndDate)
                    startDateTextBox.datetimepicker('setDate', testEndDate);
            }
            else {
                startDateTextBox.datetimepicker('setDate', obterHoraVolta());
            }
        },
        onSelect: function(selectedDateTime) {
            var data = obterHoraVolta();
            startDateTextBox.datetimepicker('option', 'maxDate', data);
        }
    });

    function obterHoraIda() {
        var testStartDate = startDateTextBox.datetimepicker('getDate');
        testStartDate.setHours($("#horaIda").val().split(":")[0]);
        testStartDate.setMinutes($("#horaIda").val().split(":")[1]);
        return testStartDate;
    }
    function obterHoraVolta() {
        var testEndDate = endDateTextBox.datetimepicker('getDate');
        testEndDate.setHours($("#horaVolta").val().split(":")[0]);
        testEndDate.setMinutes($("#horaVolta").val().split(":")[1]);
        return testEndDate;
    }
    //Fim datepick script adaptado
}