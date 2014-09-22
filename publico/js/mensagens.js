/*
 * Arquivo mensagens.js
 * 
 *      O objetivo desse arquivo é centralizar métodos, objetos e demais coisas
 * relacionadas com o tratamento de mensagens recebidas do servidor. Funções para
 * popups também são inclusos nesse arquivo.
 * 
 * 
 * 
 */

/**
 * Procura por respostas padronizadas do servidor.
 * 
 * @author Reuel
 *  
 * @param {String} string Texto qualquer. Nesse caso, trata-se do retorno das páginas solicitadas via Ajax.
 * @returns {String} 
 */
function filtrarJSON(string) {
    console.log(string);
    $(".debug_div").empty();
    $(".debug_div").append(string);
    var data = new RespostaJSON();

    var regex = /\[(\[\"sys_msgs\"\]).*?}\]/g;
    var match = regex.exec(string);

    if (match != undefined) {
        var resultados = JSON.parse(match[0]);
        if (resultados[0][0] == "sys_msgs") {
            for (var i = 1; i < resultados.length; i++) {
                var mensagem = new Mensagem();
                mensagem.setMensagem(resultados[i]['mensagem']);
                mensagem.setTipo(resultados[i]['tipo']);

                switch (mensagem.getTipo()) {
                    case 'pop_sucesso':
                    case 'pop_sucesso_fixo':
                        data.addMensagemSucesso(mensagem);
                        break;
                    case 'pop_erro':
                    case 'pop_erro_fixo':
                        data.addMensagemErro(mensagem);
                        break;
                    case 'pop_info':
                    case 'pop_info_fixo':
                        data.addMensagemInfo(mensagem);
                        break;
                    case 'pop_alerta':
                    case 'pop_alerta_fixo':
                        data.addMensagemAlerta(mensagem);
                        break;
                    case 'sys_status':
                        data.status = resultados[i]['mensagem'];
                        break;
                    default:
                        data.addMensagemPersonalizada(mensagem);
                        break;
                }
            }
        } else {
            data.status = "indefinido";
        }
    } else {
        data.status = "indefinido";
    }

    return data;
}

/**
 * Recebe um objeto contendo mensagens recebidas pelo servidor.
 * Para todas as mensagens do tipo popup (pop_algumnome) exibe um popup na tela,
 * que pode ser fixo ou esmaecer após alguns segundos.
 * 
 * Identificadores:
 * 
 * pop_tipo - popup temporário
 * pop_tipo_fixo - popup fixo
 * 
 * Para mais detalhes sobre todos os identificadores possíveis, por favor visite
 * a wiki do projeto na página do bitbucket.
 * 
 * @param {RespostaJSON} data
 * @returns {undefined}
 */
function processarMensagens(data) {
    var erros = data.getMensagensErro();
    for (var i = 0; i < erros.length; i++) {
        showPopUp(erros[i].getMensagem(), erros[i].getTipo());
    }

    var sucessos = data.getMensagensSucesso();
    for (var i = 0; i < sucessos.length; i++) {
        showPopUp(sucessos[i].getMensagem(), sucessos[i].getTipo());
    }

    var alertas = data.getMensagensAlerta();
    for (var i = 0; i < alertas.length; i++) {
        showPopUp(alertas[i].getMensagem(), alertas[i].getTipo());
    }

    var infos = data.getMensagensInfo();
    for (var i = 0; i < infos.length; i++) {
        showPopUp(infos[i].getMensagem(), infos[i].getTipo());
    }
}

/**
 * Objeto para mensagens recebidas pelo sistema.
 * @returns {Mensagem}
 */
function Mensagem() {
    this.tipo;
    this.mensagem;

    this.setTipo = function (tipo) {
        this.tipo = tipo;
    };

    this.getTipo = function () {
        return this.tipo;
    };
    this.setMensagem = function (mensagem) {
        this.mensagem = mensagem;
    };

    this.getMensagem = function () {
        return this.mensagem;
    };


}

/**
 * Definição do objeto RespostaJSON.
 * 
 * Esse objeto armazenara respostas enviadas pelo servidor para o cliente.
 * Tais respostas podem ser mensagens para exibição de popups ou outras mensagens
 * personalizadas definidas pelo servidor. Para mais detalhes, por favor consultar
 * a wiki na página do projeto do bitbucket sobre mensagens.
 * 
 * @returns {RespostaJSON}
 */
function RespostaJSON() {
    this.status = "indefinido";
    this.mensagensSucesso = [];
    this.mensagensErro = [];
    this.mensagensInfo = [];
    this.mensagensAlerta = [];
    this.mensagensPersonalizadas = [];

    //GETs
    this.getMensagensSucesso = function () {
        return this.mensagensSucesso;
    };
    this.getMensagensErro = function () {
        return this.mensagensErro;
    };
    this.getMensagensInfo = function () {
        return this.mensagensInfo;
    };
    this.getMensagensAlerta = function () {
        return this.mensagensAlerta;
    };
    this.getMensagensPersonalizadas = function () {
        return this.mensagensPersonalizadas;
    };

    //SETs
    this.addMensagemSucesso = function (mensagem) {
        this.mensagensSucesso[this.mensagensSucesso.length] = mensagem;
    };
    this.addMensagemErro = function (mensagem) {
        this.mensagensErro[this.mensagensErro.length] = mensagem;
    };
    this.addMensagemInfo = function (mensagem) {
        this.mensagensInfo[this.mensagensInfo.length] = mensagem;
    };
    this.addMensagemAlerta = function (mensagem) {
        this.mensagensAlerta[this.mensagensAlerta.length] = mensagem;
    };
    this.addMensagemPersonalizada = function (mensagem) {
        this.mensagensPersonalizadas[this.mensagensPersonalizadas.length] = mensagem;
    };
}