var quantidadePatrimonios = 1;
var codigoHtml = "";

function adicionarNovoPatrimonio() {
    quantidadePatrimonios++;
    $("#removerPatrimonio").removeClass("disabled");
    $("#removerPatrimonio").prop("disabled", false);
    $("#quantidadePatrimonios").text(quantidadePatrimonios);

    $("span.patrimonio-" + (quantidadePatrimonios - 1)).after(novoCodigoHtml());
    varrerCampos();
}

function removerPatrimonioAdicionado() {
    if (quantidadePatrimonios > 1) {
        $("span.patrimonio-" + (quantidadePatrimonios)).remove();
        quantidadePatrimonios--;
        $("#quantidadePatrimonios").text(quantidadePatrimonios);
    }
    if (quantidadePatrimonios <= 1) {
        quantidadePatrimonios = 1;
        $("#removerPatrimonio").addClass("disabled");
        $("#removerPatrimonio").prop("disabled", true);
    }
}

function novoCodigoHtml() {
    return codigoHtml.
            replace(/<n>/g, quantidadePatrimonios);

}

function botaoLimpar() {
    $("span.patrimonio-2").nextAll().andSelf().remove();
    quantidadePatrimonios = 1;
    $("#quantidadePatrimonios").text(quantidadePatrimonios);
    removerPatrimonioAdicionado();
    liberarCadastro();
    $("#chars").text("1000");
}

$(document).ready(function() {
    $("#custeio").on("click", function() {
        if (!$(this).hasClass("btn-info")) {
            $(this).toggleClass("btn-info");
            $("#patrimonio").toggleClass("btn-info");
        }

        $("input[id^=numeroPatrimonio]").prop("required", false);
        $("input[id^=numeroPatrimonio]").prop("readonly", true);
        $(".patrimonios").prop("hidden", true);
        $(".patrimonios").addClass("hidden");
        $(".custeio").removeClass("hidden");
        $(".custeio input").prop("required", true);
        $(".patrimonios input").prop("required", false);
        $("input[id^=numeroPatrimonio]").removeClass("campoErrado");
//                                $(".obrigatorio").remove(); //remove a imagem do asterisco de todos os campos

        $("#radioCusteio").click();
        liberarCadastro();
    });

    $("#patrimonio").on("click", function() {

        if (!$(this).hasClass("btn-info")) {
            $(this).toggleClass("btn-info");
            $("#custeio").toggleClass("btn-info");
        }

        $("input[id^=numeroPatrimonio]").prop("required", true);
        $("input[id^=numeroPatrimonio]").prop("readonly", false);
        $(".patrimonios").prop("hidden", false);
        $(".patrimonios").removeClass("hidden");
        $(".custeio").addClass("hidden");
        $(".custeio input").prop("required", false);
        $(".patrimonios input").prop("required", true);
        $("input[id^=numeroPatrimonio]").removeClass("campoErrado");
//                                if ($(".obrigatorio").length === 0) {
//                                    $("input[id^=numeroPatrimonio]").after("<img class=\"obrigatorio\" src=\"publico/imagens/icones/campo_obrigatorio.png\">");
//                                }
        if (codigoHtml === "") {
            codigoHtml = $("#linhasPatrimonios").last().html().replace(/-1/g, "-<n>"); //Substitui todas as ocorrências
            varrerCampos();
        }

        $("#radioPatrimonio").click();
        $("#submit").prop("disabled", true);
    });
})