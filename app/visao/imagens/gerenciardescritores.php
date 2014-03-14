<title>Gerenciar descritores</title>
<!-- Início da páginas -->
<div class="blocoBranco container">
    <label for="busca_descritor">Buscar: </label>
    <input type="text" id="busca_descritor" class="input-large ignorar"/>
    <hr>
    <div id="jstree_div" class="span5"></div>
    <div id="wrap_aux" class="hidden">
        <div id="jstree_div_aux" class="span5"></div>
        <div class="span5" style="clear:left;min-height: 1px;margin-left: 220px;">
            <input id="botao_cancelar" type="button" class="btn" value="Cancelar" />
            <input id="botao_confirmar" type="button" class="btn btn-primary" value="Confirmar" />
        </div>
    </div>
</div>

<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {


        $(function() {
            $.ajax({
                async: true,
                type: "GET",
                url: "index.php?c=imagens&a=arvoredescritores",
                dataType: "json",
                success: function(json) {
                    criarArvore(json);
                    var to = false;
                    $('#busca_descritor').keyup(function() {
                        if (to) {
                            clearTimeout(to);
                        }
                        to = setTimeout(function() {
                            var v = $('#busca_descritor').val();
                            $('#jstree_div').jstree(true).search(v);
                        }, 250);
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });


        $("#botao_cancelar").on('click', function() {
            $('#jstree_div').toggle(200);
            $('#jstree_div_aux').jstree(true).destroy();
            $('#wrap_aux').toggleClass('hidden', 200);
        });

        function renomearDescritor(id, novoNome) {
            var sucesso;
            return $.ajax({
                async: false
                , type: "POST"
                , url: "index.php?c=imagens&a=renomearDescritor"
                , dataType: "json"
                , data: {'id': id, 'novoNome': novoNome}
                , success: function(json) {
                    sucesso = json;
                    return json;
                }
                , error: function(xhr, ajaxOptions, thrownError) {
                    sucesso = false;
                    return false;
                }
            });
            return sucesso;
        }

        function criarDescritor(idPai, nome) {
            var sucesso;
            $.ajax({
                async: false
                , type: "POST"
                , url: "index.php?c=imagens&a=criarDescritor"
                , dataType: "json"
                , data: {'idPai': idPai, 'nome': nome}
                , success: function(json) {
                    sucesso = json;
                    return json.resposta;
                }
                , error: function(xhr, ajaxOptions, thrownError) {
                    sucesso = false;
                    return false;
                }
            });
            return sucesso;
        }

        function moverDescritor(idDescritor, idNovoPai, idAntigoPai) {
            var sucesso;
            $.ajax({
                async: false
                , type: "POST"
                , url: "index.php?c=imagens&a=moverDescritor"
                , dataType: "json"
                , data: {'idDescritor': idDescritor, 'idNovoPai': idNovoPai, 'idAntigoPai': idAntigoPai}
                , success: function(json) {
                    sucesso = json;
                    return json;
                }
                , error: function(xhr, ajaxOptions, thrownError) {
                    sucesso = false;
                    return false;
                }
            });
            return sucesso;
        }

        function montarArvoreAuxiliar(idIgnorar) {
            $.ajax({
                async: true,
                type: "GET",
                url: "index.php?c=imagens&a=arvoredescritores&completa=true&descritorExcluir=" + idIgnorar,
                dataType: "json",
                success: function(jsonData) {
                    $('#jstree_div_aux').jstree({
                        core: {
                            data: function(node, callback) {
                                var jsonAux = jsonData;

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
                    });

                    $('#jstree_div').toggle(200);
                    $('#wrap_aux').toggleClass('hidden', 200);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert("Erro. Recarregue a página!");
                }
            });
        }

        var menuCriar = {
            "separator_before": false,
            "separator_after": true,
            "_disabled": false, //(this.check("create_node", data.reference, {}, "last")),
            "label": "Criar",
            "action": function(data) {
                var inst = $.jstree.reference(data.reference),
                        obj = inst.get_node(data.reference);
                inst.create_node(obj, {}, "last", function(new_node) {
                    setTimeout(function() {
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
            "action": function(data) {
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
            "action": function(data) {
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
        function criarArvore(jsonData) {

            $('#jstree_div').jstree({
                "core": {//Configurações básicas
                    data: jsonData
                    , "themes": {
                        "stripes": true
                        , icons: false
                    }
                    , "multiple": false
                    , "check_callback": function(operation, node, node_parent, node_position) {
                        var check_passed = false;
                        switch (operation) {
                            case "move_node":
                                if (node.original !== undefined && node_parent.original != undefined && node.original.nivel - 1 == node_parent.original.nivel) {
//                                    console.log("movendo...");
                                    check_passed = true;
                                }
                                break;
                            case "delete_node":
//                                console.log(node.id)
                                montarArvoreAuxiliar(node.id);
                                check_passed = false;
                                break;
                            case "create_node":
//                                check_passed = criarDescritor(node_parent.id,node.text);
                                console.log("Criando descritor...");
                                check_passed = true;
                                break;
                            case "rename_node":
                                check_passed = renomearDescritor(node.id, node_position);
                                if (!check_passed) {
                                    showPopUp("Não foi possível renomear. Verifique se o nome já não existe.", "erro");
                                }
                                break;
                        }
                        return check_passed;
                    }
                }
                , contextmenu: {//Menu com clique direito
                    items: function(node) {
                        if (node.parent == "#") {
                            return {
                                //"create": menuCriar
                            };
                        } else if (node.original.nivel < 4) {
                            return {
                                //"create": menuCriar,
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
                    is_draggable: function(node) {
                        if (node.parent == "#" || node.original.nivel == 1) {
                            return false;
                        }
                        return true;
                    }
                }
                , "plugins": ["contextmenu", "unique", "json_data", "dnd", "search"]
            });



//            $('#jstree_div').on("changed.jstree", function(e, data) {
//                console.log(data);
//            });
//            $('#jstree_div').on("rename_node.jstree", function(e, data) {
//                console.log("Renomeado...");
//                console.log(data);
//            });
            $('#jstree_div').on("move_node.jstree", function(e, data) {
                if (!moverDescritor(data.node.id, data.parent, data.old_parent)) {
                    showPopUp("Falha ao mover", "erro");
                    return false;
                } else {
                    return true;
                }
            });
//            $('#jstree_div').on("delete_node.jstree", function(e, data) {
////                window.alert("Deletado");
////                console.log(data);
//            });
//            $('#jstree_div').on("create_node.jstree", function(e, data) {
//                console.log("Descritor criado")
////                criarDescritor(data.parent,data.original.text);
//            });

        }

    });

</script>