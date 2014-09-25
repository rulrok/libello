<title>Gerenciar descritores</title>
<!-- Início da páginas -->
<br/>
<div class="blocoBranco">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <!--<a class="brand" href="#"></a>-->
                <span><i class="icon-tags"></i></span>
                <span class="divider-vertical"></span>
                <span class="input-append fix_position">
                    <input type="text" autofocus autocomplete="off" class="ignorar input-xxlarge fix_position search-query" id="busca_descritor" placeholder="Procure pelo nome do descritor..." >
                    <button id="botao_buscar_imagem" class="fix_position btn-buscainterna" type="button" ><i class="icon-search"></i></button>
                    <button id="botao_limpar" class="fix_position btn-buscainterna" type="button" data-toggle="Limpar" title="Limpar campo de busca" style=""><i class="icon-remove"></i></button>
                </span>
                <span class=" pull-right nav-collapse collapse navbar-responsive-collapse">
                    <ul class="nav">
                        <li class="divider-vertical fix_position"></li>
                        <li class="fix_position">
                            <button class="btn" id="mostrar_todos"  >Expandir todos <i class="icon-chevron-down"></i> </button>
                            <button class="btn hidden" id="ocultar_todos"  >Contrair todos <i class="icon-chevron-up"></i></button>
                        </li>
                    </ul>
                </span><!-- /.nav-collapse -->
            </div>
        </div><!-- /navbar-inner -->
    </div>
    <hr>
    <div id="jstree_div" class="span5"></div>
    <div id="wrap_aux" class="hidden">
        <div id="jstree_div_aux" class="span5"></div>
        <div class="span5">
            <p>Indique para onde as imagens com o atual descritor devem ser movidas</p>
            <input id="botao_cancelar" type="button" class="btn" value="Cancelar" />
            <input id="botao_confirmar" type="button" class="btn btn-primary" disabled value="Confirmar" />
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function () {


        $("#botao_limpar").tooltip({placement: 'top'});
        $("#botao_limpar").on('click', function () {
            $('#busca_descritor').val('').trigger('keyup');
        });

        $("#mostrar_todos").on('click', function () {
            $(this).addClass("hidden");
            $("#ocultar_todos").removeClass("hidden");
            arvoreAtual.jstree(true).open_all(undefined, false);
        });

        $("#ocultar_todos").on('click', function () {
            $(this).addClass("hidden");
            $("#mostrar_todos").removeClass("hidden");
            arvoreAtual.jstree().close_all();
            arvoreAtual.jstree(true).open_node(arvoreAtual.jstree(true).get_json('#'), undefined, false);
        });

        $.ajax({
            async: true,
            type: "GET",
            url: "index.php?c=imagens&a=arvoredescritores",
            success: function (json) {
                criarArvore(obterResposta('img_arvore', true));
                configurarBarraFerramentas('#jstree_div');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
                //TODO fazer algo indicando que houve um erro
            }
        });
    });

    //Variável para auxiliar na hora de configurar as ações da barra de ferramentas,
    //indicando qual árvore está sendo trabalhada atualmente, se a principal ou
    //a auxiliar para remoção de descritores.
    arvoreAtual = $("#jstree_div");

    //Variável para auxiliar na atualização da jsTree quando um descritor é criado.
    //Quando ele é criado com sucesso, o servidor informa com true e também responde
    //com o ID no banco do novo descritor. Sem esse ID, o descritor na jstree
    //não teria utilidade, pois ações como renomeá-lo ou removê-lo não surtiriam
    //nenhum efeito no banco de dados por não haver um ID válido associado a ele
    //na jstree.
    //O objeto Descritor deixa mais fácil a manipulação do retorno que consiste em
    //um ID, nome e nível do elemento na árvore
    function Descritor(id, nome, nivel) {
        this.id = id;
        this.nome = nome;
        this.nivel = nivel;
    }
    ultimoDescritorCriado = undefined;

    function configurarBarraFerramentas(elemento) {
        $("#mostrar_todos").removeClass("hidden");
        $("#ocultar_todos").addClass("hidden");
        arvoreAtual = $(elemento);
        configurarCampoBusca();
    }

    function configurarCampoBusca() {
        $('#busca_descritor').val('');
        arvoreAtual.jstree(true).search();
        var to = false;
        $('#busca_descritor').off('keyup');
        $('#busca_descritor').keyup(function () {
            if (to) {
                clearTimeout(to);
            }
            to = setTimeout(function () {
                var v = $('#busca_descritor').val();
                arvoreAtual.jstree(true).search(v);
            }, 250);
        });
    }
    //Exibe a nova árvore de descritores atualizada para o usuário indicar o
    //novo descritor que irá substituir o atual descritor removido.
    function escolherSubstituto() {

        $("#botao_cancelar").on('click', function () {
            configurarBarraFerramentas('#jstree_div');
            $('#wrap_aux').addClass('hidden');
            $('#jstree_div').removeClass('hidden', 200);
            setTimeout(function () {
                $('#jstree_div_aux').jstree(true).destroy();
                $("#botao_cancelar,#botao_confirmar").off('click');
            }, 400);
        });
        $("#botao_confirmar").on('click', function () {
            confirmadoRemocao = true;
            configurarBarraFerramentas('#jstree_div');
            $('#jstree_div').jstree(true).delete_node($('#jstree_div').jstree(true).get_selected());
            $('#jstree_div').removeClass('hidden', 200);
            $("#botao_cancelar,#botao_confirmar").off('click');
        });
    }

    //======================================================================
    //  Callbacks utilizados para realizar as ações no servidor
    //======================================================================
    function renomearDescritor(id, novoNome) {
        var sucesso;
        $.ajax({
            async: false
            , type: "POST"
            , url: "index.php?c=imagens&a=renomearDescritor"
//            , dataType: "json"
            , data: {'id': id, 'novoNome': novoNome}
            , success: function (json) {
                sucesso = obterResposta("msg_renomeardescritor", true);
            }
            , error: function (xhr, ajaxOptions, thrownError) {
                sucesso = false;
            }
        });
        return sucesso;
    }

    function criarDescritor(pai, novoDescritor) {
        var sucesso;
        $.ajax({
            async: false
            , type: "POST"
            , url: "index.php?c=imagens&a=criarDescritor"
//            , dataType: "json"
            , data: {'idPai': pai.id, 'nome': novoDescritor.text}
            , success: function (json) {
                if (obterStatusOperacao() == Mensagem.prototype.Tipo.SUCESSO) {
                    var descritorCriado = obterResposta("img_novodescritor", true);
                    ultimoDescritorCriado = new Descritor(descritorCriado.id, descritorCriado.nome, descritorCriado.nivel);
                    sucesso = true;
                } else {
                    sucesso = false;
                    ultimoDescritorCriado = undefined;
                }
//                return json;
            }
            , error: function (xhr, ajaxOptions, thrownError) {
                sucesso = false;
                return false;
            }
        });
        return sucesso;
    }
    function moverDescritor(descritor, idNovoPai, idAntigoPai) {
        var sucesso;
        $.ajax({
            async: false
            , type: "POST"
            , url: "index.php?c=imagens&a=moverDescritor"
//            , dataType: "json"
            , data: {'idDescritor': descritor.id, nivel: descritor.original.nivel, 'idNovoPai': idNovoPai, 'idAntigoPai': idAntigoPai}
            , success: function (json) {
                if (obterStatusOperacao() == Mensagem.prototype.Tipo.SUCESSO) {
                    sucesso = true;
                } else {
                    sucesso = false;
                }
//                return json;
            }
            , error: function (xhr, ajaxOptions, thrownError) {
                sucesso = false;
                return false;
            }
        });
        return sucesso;
    }
    function removerDescritor(idDescritor, idDescritorSubstituto) {
        var sucesso;
        $.ajax({
            async: false
            , type: "POST"
            , url: "index.php?c=imagens&a=removerDescritor"
//            , dataType: "json"
            , data: {'idDescritor': idDescritor, 'idDescritorSubstituto': idDescritorSubstituto}
            , success: function (json) {
                if (obterStatusOperacao() == Mensagem.prototype.Tipo.SUCESSO) {
                    sucesso = true;
                } else {
                    sucesso = false;
                }
                return sucesso;
            }
            , error: function (xhr, ajaxOptions, thrownError) {
                sucesso = false;
                return false;
            }
        });
    }

    //Monta a nova árvore de descritores para o usuário indicar o novo descritor
    //que deve substituir o descritor que será excluído do banco de imagens.
    //Observar que a árvore retornada é uma árvore completa, contendo apenas
    //descritores que vão até as folhas da árvore, já ignorando o atual ramo
    //que deverá ser excluído pelo usuário.
    function montarArvoreAuxiliar(idIgnorar) {
        $.ajax({
            async: false,
            type: "GET",
            url: "index.php?c=imagens&a=arvoredescritores&completa=true&descritorExcluir=" + idIgnorar,
//            dataType: "json",
            success: function (jsonData) {
                $('#jstree_div_aux').jstree({
                    core: {
                        data: function (node, callback) {
                            var jsonAux = obterResposta("img_arvore_completa_semdescritor", true);

                            //TODO A partir da versão beta-10 do jsTree, duas árvore diferentes com o mesmo ID são possíveis.
                            //Quando for estável o sulficiente, atualizar para essa versão ou maior para não precisar adicionar a_ ao id dos componentes
                            //Isso é uma sugestão, visto que funciona bem atualmente @Reuel
                            for (var i = 0; i < jsonAux.length; i++) {
                                jsonAux[i].id = jsonAux[i].id != "#" ? "a_" + jsonAux[i].id : "#";
                                jsonAux[i].parent = jsonAux[i].parent != "#" ? "a_" + jsonAux[i].parent : "#";
                            }
                            callback(jsonAux);
                        }
                        , "themes": {
                            "stripes": true
                            , icons: false
                        }
                        , "multiple": false
                    }
                    , "plugins": ["unique", "json_data", "search", "sort"]
                });

                $('#jstree_div').addClass('hidden', 200);
                $('#wrap_aux').removeClass('hidden', 200);
                configurarBarraFerramentas('#jstree_div_aux');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Erro. Recarregue a página!");
            }
        });
        $('#jstree_div_aux').on("changed.jstree", function (e, data) {
            if (data.action == "select_node") {
                if (data.node.original.nivel != 4) {
                    $("#botao_confirmar").addClass('disabled');
                    $("#botao_confirmar").prop('disabled', true);
                } else {
                    $("#botao_confirmar").removeClass('disabled');
                    $("#botao_confirmar").prop('disabled', false);
                }
            }
        });
        $("#busca_descritor").focus();
    }

    //======================================================================
    //  Menus que irão compor o context menu, ou seja, as opções que irão 
    // aparecer quando um descritor for clicado com o botão direito do mouse
    //======================================================================
    var menuCriar = {
        "separator_before": false,
        "separator_after": true,
        "_disabled": false, //(this.check("create_node", data.reference, {}, "last")),
        "label": "Criar descritor",
        "action": function (data) {
            var nomebase = "Novo descritor";
            var inst = $.jstree.reference(data.reference),
                    obj = inst.get_node(data.reference);
            var child = inst.get_children_dom(data.reference);

            var maiorNumero = -1;
            $(child).each(function (index, data) {
                var nomeDescritor = inst.get_node(data).text;
                if (nomebase == nomeDescritor.substr(0, nomebase.length)) {
                    var numeroEncontrado = parseInt(nomeDescritor.substr(nomebase.length, nomeDescritor.length));
                    if (isNaN(numeroEncontrado)) {
                        numeroEncontrado = 0;
                    }
                    if (maiorNumero < numeroEncontrado) {
                        maiorNumero = numeroEncontrado;
                    }
                }
            });

            maiorNumero++;

            if (maiorNumero > 0) {
                nomebase = nomebase + " " + maiorNumero;
            }

            inst.create_node(obj, {text: nomebase}, "last", function (new_node) {
                setTimeout(function () {
                    inst.edit(new_node);
                }, 0);
            });
        }
    };
    var menuRenomear = {
        "separator_before": false,
        "separator_after": false,
        "_disabled": false, //(this.check("rename_node", data.reference, this.get_parent(data.reference), "")),
        "label": "Renomear",
        /*
         "shortcut"			: 113,
         "shortcut_label"	: 'F2',
         "icon"				: "glyphicon glyphicon-leaf",
         */
        "action": function (data) {
            var inst = $.jstree.reference(data.reference),
                    obj = inst.get_node(data.reference);
            inst.edit(obj);
        }
    };
    var menuRemover = {
        "separator_before": false,
        "icon": false,
        "separator_after": false,
        "_disabled": false, //(this.check("delete_node", data.reference, this.get_parent(data.reference), "")),
        "label": "Remover",
        "action": function (data) {
            var inst = $.jstree.reference(data.reference),
                    obj = inst.get_node(data.reference);
            if (inst.is_selected(obj)) {
                inst.delete_node(inst.get_selected());
            }
            else {
                inst.delete_node(obj);
            }
        }
    };

    //  Variável para auxiliar na decisão do que fazer quando um usuário quer 
    //remover um descritor.
    //  Quando um nó é escolhido para ser removido, ele ativará o evento "delete_node"
    //e quando esse evento é disparado, é preciso saber por que ele está sendo ativado.
    //Ou é por causa do usuário clicar em remover e uma nova árvore deve ser exibida
    //perguntando para onde mover as imagens com o atual descritor, ou então
    //deletando da árvore principal o descritor - quando o usuário confirmou
    // a exclusão.
    confirmadoRemocao = false;

    //Cria a árvore principal para gerência dos descritores
    function criarArvore(jsonData) {

        $('#jstree_div').jstree({
            "core": {//Configurações básicas
                data: jsonData
                , "themes": {
                    "stripes": true
                    , icons: false
                }
                , "multiple": false
                , "check_callback": function (operation, node, node_parent, node_position) {
                    var check_passed = false;
                    switch (operation) {
                        case "move_node":
                            if (node.original !== undefined && node_parent.original != undefined && node.original.nivel - 1 == node_parent.original.nivel) {
                                check_passed = true;
                            }
                            break;
                        case "delete_node":
                            if (!confirmadoRemocao) {
                                montarArvoreAuxiliar(node.id);
                                escolherSubstituto();
                                check_passed = false;
                            } else {
                                var idDescritor = $('#jstree_div').jstree(true).get_selected().toString();
                                var idDescritorSubs = $('#jstree_div_aux').jstree(true).get_selected().toString().substr(2);
                                check_passed = removerDescritor(idDescritor, idDescritorSubs);
                                confirmadoRemocao = false;
                            }
                            break;
                        case "create_node":
                            check_passed = criarDescritor(node_parent, node);
                            break;
                        case "rename_node":
                            check_passed = renomearDescritor(node.id, node_position);
                            break;
                    }
                    return check_passed;
                }
            }
            , contextmenu: {//Menu com clique direito
                items: function (node) {
                    if (node.parent == "#") {
                        return {
                            "create": menuCriar
                        };
                    } else if (node.original.nivel < 4) {
                        return {
                            "create": menuCriar,
                            "rename": menuRenomear,
                            "remove": menuRemover
                        };
                    } else {
                        return {
                            "rename": menuRenomear,
                            "remove": menuRemover
                        };
                    }
                }

            }
            , dnd: {//Drag 'n' Drop
                is_draggable: function (node) {
                    if (node.parent == "#" || node.original.nivel == 1) {
                        return false;
                    }
                    return true;
                }
            }
            , "plugins": ["contextmenu", "unique", "json_data", "dnd", "search", "sort"]
        });




        //==================================================================
        //  Eventos que serão ativados após os eventos no "check_callback"
        // da jstree ocorrerem.
        //==================================================================

//            $('#jstree_div').on("changed.jstree", function(e, data) {
//                console.log(data);
//            });
//            $('#jstree_div').on("rename_node.jstree", function(e, data) {
//                console.log("Renomeado...");
//                console.log(data);
//            });

        $('#jstree_div').on("move_node.jstree", function (e, data) {
            if (!moverDescritor(data.node, data.parent, data.old_parent)) {
                showPopUp("Falha ao mover.<br/>Recarregue a página.", "erro");
                return false;
            } else {
                return true;
            }
        });

        $('#jstree_div').on("delete_node.jstree", function (e, data) {
            configurarBarraFerramentas('#jstree_div');
            $('#wrap_aux').toggleClass('hidden', 200);
            $('#jstree_div').removeClass('hidden', 200);
            $('#jstree_div_aux').jstree(true).destroy();
            $("#botao_cancelar,#botao_confirmar").off('click');
        });

        $('#jstree_div').on("create_node.jstree", function (e, data) {
            if (ultimoDescritorCriado !== undefined) {
                var $tree = $("#jstree_div").jstree(true);
                $tree.set_id(data.node, ultimoDescritorCriado.id);
                $tree.set_text(data.node, ultimoDescritorCriado.nome);
                data.instance.get_node(data.node).original.nivel = ultimoDescritorCriado.nivel;
                console.log(data.instance.get_node(data.node))
                ultimoDescritorCriado = undefined;
            }
        }).jstree("refresh");
    }
</script>