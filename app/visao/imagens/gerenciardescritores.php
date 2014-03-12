<title>Gerenciar descritores</title>
<!-- Início da páginas -->
<div class="blocoBranco container">
    <label for="busca_descritor">Buscar: </label>
    <input type="text" id="busca_descritor" class="input-large ignorar"/>
    <hr>
    <div id="jstree_div"></div>
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

        function renomearDescritor(id, novoNome) {

            $.ajax({
                async: false
                , type: "POST"
                , url: "index.php?c=imagens&a=renomearDescritor"
                , dataType: "json"
                , data: {'id': id, 'novoNome': novoNome}
                , success: function(json) {
                    return json.resposta;
                }
                , error: function(xhr, ajaxOptions, thrownError) {
                    return false;
                }
            });
        }

        function criarDescritor(idPai, nome) {
            $.ajax({
                async: false
                , type: "POST"
                , url: "index.php?c=imagens&a=criarDescritor"
                , dataType: "json"
                , data: {'idPai': idPai, 'nome': nome}
                , success: function(json) {
                    return json.resposta;
                }
                , error: function(xhr, ajaxOptions, thrownError) {
                    return false;
                }
            });
        }
        function criarArvore(jsonData) {

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

            $('#jstree_div').jstree({
                "core": {
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
                                    check_passed = true;
                                }
                                break;
                            case "delete_node":
                                check_passed = true;
                                break;
                            case "create_node":
//                                check_passed = criarDescritor(node_parent.id,node.text);
                                console.log("Criando descritor...");
                                check_passed = true;
                                break;
                            case "rename_node":
                                check_passed = renomearDescritor(node.id, node_position);
                                break;
                        }
                        return check_passed;
                    }
                }
                , contextmenu: {
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
                , dnd: {
                    is_draggable: function(node) {
                        if (node.parent == "#") {
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
//            $('#jstree_div').on("move_node.jstree", function(e, data) {
//                console.log(e);
//                console.log("Movendo...");
//                console.log(data);
//            });
//            $('#jstree_div').on("delete_node.jstree", function(e, data) {
//                console.log("Deletando...");
//                console.log(data);
//            });
            $('#jstree_div').on("create_node.jstree", function(e, data) {
                console.log("Descritor criado")
//                criarDescritor(data.parent,data.original.text);
            });
        }

    });

</script>