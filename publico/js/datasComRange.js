function configurarCamposDataHora(campoInicial, campoFinal) {
    // Datepick script adaptado

    if ((campoFinal === undefined && campoFinal === null) || (campoInicial === undefined && campoInicial === null)) {
        return undefined;
    }
    var startDateTextBox = $(campoInicial);
    var endDateTextBox = $(campoFinal);


    startDateTextBox.datetimepicker({
        altField: "#horaIda",
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() == '') {
                return;
            }
            if (endDateTextBox.val() != '') {
                var testStartDate = obterHoraIda();
                var testEndDate = obterHoraVolta();
                if (testStartDate !== null && testEndDate !== null && testStartDate > testEndDate)
                    endDateTextBox.datetimepicker('setDate', testStartDate);
            }
            else {
                var horaIda = obterHoraIda();
                if (horaIda !== null)
                    endDateTextBox.datetimepicker('setDate', horaIda);
            }
        },
        onSelect: function(selectedDateTime) {
            var horaIda = obterHoraIda();
            if (horaIda !== null)
                endDateTextBox.datetimepicker('option', 'minDate', horaIda);
        }
    });

    endDateTextBox.datetimepicker({
        altField: "#horaVolta",
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() == '') {
                return;
            }
            if (startDateTextBox.val() != '') {
                var testStartDate = obterHoraIda();
                var testEndDate = obterHoraVolta();
                if (testStartDate !== null && testEndDate !== null && testStartDate > testEndDate)
                    startDateTextBox.datetimepicker('setDate', testEndDate);
            }
            else {
                var horaVolta = obterHoraVolta();
                if (horaVolta !== null)
                    startDateTextBox.datetimepicker('setDate', horaVolta);
            }
        },
        onSelect: function(selectedDateTime) {
            var data = obterHoraVolta();
            startDateTextBox.datetimepicker('option', 'maxDate', data);
        }
    });

    function obterHoraIda() {
        var testStartDate = startDateTextBox.datetimepicker('getDate');
        try {
            testStartDate.setHours($("#horaIda").val().split(":")[0]);
            testStartDate.setMinutes($("#horaIda").val().split(":")[1]);
            return testStartDate;
        } catch (e) {
            return null;
        }
    }
    function obterHoraVolta() {
        var testEndDate = endDateTextBox.datetimepicker('getDate');
        try {
            testEndDate.setHours($("#horaVolta").val().split(":")[0]);
            testEndDate.setMinutes($("#horaVolta").val().split(":")[1]);
            return testEndDate;
        } catch (e) {
            return null;
        }
    }
    //Fim datepick script adaptado
}