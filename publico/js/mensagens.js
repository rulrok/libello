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

document.ultimaresposta = new RespostaServidor();

/*
 * Função muito importante que está encarregada de pré-processar as respostas
 * enviadas por páginas após requisições Ajax. A função procurará pela resposta
 * padronizada do servidor, irá filtrá-la, e retornará o restante da resposta
 * que não faz parte da resposta padronizada. Para mais detalhes, consulte a wiki
 * do projeto.
 */
$.ajaxSetup({
    dataFilter: function (resposta, dataType) {
        var regex = /\[(\[\"sys_msgs\"\]).*}\]/g;
        var match = regex.exec(resposta);
        var dadosFiltrados = resposta.replace(regex, "");
        if (match !== null) {
            var mensagens = filtrarJSON(match[0]);
            document.ultimaresposta = mensagens;
            _processarMensagens(mensagens);
        }
        return  dadosFiltrados;
    }
});

/**
 * Função que irá procurar por alguma mensagem específica retornada pelo servidor.
 * A busca será feita apenas na última resposta do servidor. Respostas prévias 
 * por outras ações ajax serão sobreescritas.
 * 
 * <b>Obs:</b> A função apenas fará a busca nas mensagens personalizadas recebidas
 * após a chamada ajax de alguma página. Caso nenhuma mensagem personalizada tenha
 * sido enviada, <code>null</code> será retornado. Caso não exista nenhuma mensagem
 * personalizada que case com o identificador passado, <code>null</code> será retornado.
 * 
 * @param {type} identificador String com o nome do identificador definido no servidor.
 * @param {type} codificarObjeto As vezes a resposta recebida é uma string em formato
 * JSON. <code>True</code> fará a função retornar o objeto correspondente, <code>false</code>
 * retornará o texto puro. Caso o objeto não consiga ser interpretado como um JSON,
 * o texto puro será retornado.
 * 
 * @returns {Array|Object|RespostaServidor@arr;mensagensPersonalizadas@pro;mensagem}
 */
function obterResposta(identificador, codificarObjeto) {
    if (codificarObjeto !== undefined && codificarObjeto === true) {
        var objeto;
        try {
            objeto = JSON.parse(document.ultimaresposta.getMensagemPersonalizada(identificador));
        } catch (e) {
            return document.ultimaresposta.getMensagemPersonalizada(identificador);
        }
        return objeto;
    } else {
        return document.ultimaresposta.getMensagemPersonalizada(identificador);
    }
}

/**
 * Retorna o estado da última operação após uma chamada AJAX baseada na resposta
 * enviada pela página invocada.
 * 
 * <b>Obs:</b> Não confundir com o estado da operação AJAX em si. O estado descrito
 * aqui é enviado pela página chamada.
 * 
 * @returns {String}
 */
function obterStatusOperacao() {
    return document.ultimaresposta.status;
}
/**
 * Procura por respostas padronizadas do servidor. Quando identificadas, a função
 * filtra elas por tipo. Elas podem ser mensagens de pop-up para sucesso, erro,
 * aviso simples ou alerta. Além disso, a mensagem de status da operação, identificada
 * por <code>sys_status</code>. Finalmente, também serão armazenadas as mensagens
 * personalizadas enviadas pela página invocada para o cliente que a invocou.
 * Essas mensagens podem ser qualquer string que deverá ser tratata pelo desenvolvedor
 * na página que a invocou. <b>Para mais detalhes, por favor consulte a wiki na
 * página bitbucket do projeto</b>
 * 
 * @author Reuel
 *  
 * @param {String} string Retorno de uma chamada AJAX. Qualquer que seja o retorno, o código
 * tentará identificar uma mensagem de resposta padronizada.
 * @returns {RespostaServidor} Um objeto <code>RespostaServidor</code> preenchido
 * com todas as mensagens encontradas além do status da operação. Caso nenhuma mensagem
 * tenha sido retornada, esse objeto apenas estará sem nenhuma informação.
 */
function filtrarJSON(string) {
//    console.log(string);
    $(".debug_div").empty();
    $(".debug_div").append(string);
    var data = new RespostaServidor();

    var regex = /\[(\[\"sys_msgs\"\]).*?}\]/g;
    var match = regex.exec(string);

    if (match != undefined) {
        var resultados = JSON.parse(match.input);
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
function _processarMensagens(data) {

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
}

Mensagem.prototype.setTipo = function (tipo) {
    this.tipo = tipo;
};
Mensagem.prototype.getTipo = function () {
    return this.tipo;
};
Mensagem.prototype.setMensagem = function (mensagem) {
    this.mensagem = mensagem;
};

Mensagem.prototype.getMensagem = function () {
    return this.mensagem;
};

Mensagem.prototype.Tipo = {
    SUCESSO: "sucesso"
    , ERRO: "erro"
    , INDEFINIDO: "indefinido"
    , POP_SUCESSO: "pop_sucesso"
    , POP_SUCESSO_FIXO: "pop_sucesso_fixo"
};

/**
 * Definição do objeto RespostaJSON.
 * 
 * Esse objeto armazenara respostas enviadas pelo servidor para o cliente.
 * Tais respostas podem ser mensagens para exibição de popups ou outras mensagens
 * personalizadas definidas pelo servidor. Para mais detalhes, por favor consultar
 * a wiki na página do projeto do bitbucket sobre mensagens.
 * 
 * @returns {RespostaServidor}
 */
function RespostaServidor() {
    this.status = "indefinido";
    this.mensagensSucesso = [];
    this.mensagensErro = [];
    this.mensagensInfo = [];
    this.mensagensAlerta = [];
    this.mensagensPersonalizadas = [];

    //GETs
    /**
     * Obtém todas as mensagens de sucesso recebidas pela última invocação de 
     * uma página ajax.
     * 
     * @returns {Array} Array de objetos Mensagem. Um vetor vazio será retornado
     * caso não existam mensagens.
     */
    this.getMensagensSucesso = function () {
        return this.mensagensSucesso;
    };

    /**
     * Obtém todas as mensagens de erro recebidas pela última invocação de 
     * uma página ajax.
     * 
     * @returns {Array} Array de objetos Mensagem. Um vetor vazio será retornado
     * caso não existam mensagens.
     */
    this.getMensagensErro = function () {
        return this.mensagensErro;
    };

    /**
     * Obtém todas as mensagens de informação recebidas pela última invocação de 
     * uma página ajax.
     * 
     * @returns {Array} Array de objetos Mensagem. Um vetor vazio será retornado
     * caso não existam mensagens.
     */
    this.getMensagensInfo = function () {
        return this.mensagensInfo;
    };

    /**
     * Obtém todas as mensagens de alerta recebidas pela última invocação de 
     * uma página ajax.
     * 
     * @returns {Array} Array de objetos Mensagem. Um vetor vazio será retornado
     * caso não existam mensagens.
     */
    this.getMensagensAlerta = function () {
        return this.mensagensAlerta;
    };

    /**
     * Obtém todas as mensagens personalizadas recebidas pela última invocação de 
     * uma página ajax.
     * 
     * @returns {Array} Array de objetos Mensagem. Um vetor vazio será retornado
     * caso não existam mensagens.
     */
    this.getMensagensPersonalizadas = function () {
        return this.mensagensPersonalizadas;
    };

    /**
     * Procura e recupera alguma mensagem personalizada específica retornada
     * pela última resposta de uma página chamada via AJAX.
     * 
     * @param {type} identificador Nome da mensagem
     * @returns {String} Valor associado ao identificador. Caso o identificador
     * não seja encontrado, <code>null</code> será retornado.
     */
    this.getMensagemPersonalizada = function (identificador) {
        for (var i = 0; i < this.mensagensPersonalizadas.length; i++) {
            if (this.mensagensPersonalizadas[i].tipo == identificador) {
                return this.mensagensPersonalizadas[i].mensagem;
                break;
            }
        }
        return null;
    }
    //SETs
    this.addMensagemSucesso = function (mensagem) {
        this.mensagensSucesso.push(mensagem);
    };
    this.addMensagemErro = function (mensagem) {
        this.mensagensErro.push(mensagem);
    };
    this.addMensagemInfo = function (mensagem) {
        this.mensagensInfo.push(mensagem);
    };
    this.addMensagemAlerta = function (mensagem) {
        this.mensagensAlerta.push(mensagem);
    };
    this.addMensagemPersonalizada = function (mensagem) {
        this.mensagensPersonalizadas.push(mensagem);
    };
}