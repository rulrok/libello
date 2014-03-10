<title>Gerenciar descritores</title>
<!-- Início da páginas -->
<!--<div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!imagens|novoDescritor" class="btn btn-adicionar"><i class="icon-headphones"></i> Adicionar novo</a>
        <button class="btn btn-editar disabled" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger disabled btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>-->
<!--<table id="gerenciar_descritores" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Nome</th>
            <th>Qtd</th>
            <th>Data de entrada</th>
            <th>Patrimônio</th>
            <th hidden>Descrição</th>
        </tr>
    </thead>
    <tbody>
<?php
//        foreach ($this->descritores as $value) {
//            echo '<tr>';
//            for ($i = 0; $i < sizeof($value) / 2; $i++) {
//                if ($i == 0) {
//                    echo '<td hidden class="campoID">';
//                } else {
//                    echo '<td>';
//                }
//                echo $value[$i];
//                echo '</td>';
//            }
//            echo '</tr>';
//        }
?>
    </tbody>
</table>-->
<!--<div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!imagens|novoDescritor" class="btn btn-adicionar"><i class="icon-headphones"></i> Adicionar novo</a>
        <button class="btn btn-editar disabled" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger disabled btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>-->

<div id="jstree_div"></div>

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
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });

        function criarArvore(jsonData) {
            $('#jstree_div').jstree({
                "core": {
                    data: jsonData
                    , "themes": {"stripes": true}
                    , "multiple": false
                }
                , "types": {
                    "#": {
                        "max_children": 1
                        , "max_depth": 4
                        , "valid_children": ["root"]
                    }
                    , "root": {
                        "icon": "/static/3.0.0-beta9/assets/images/tree_icon.png",
                        "valid_children": ["default"]
                    }
                    , "default": {
                        icon: "glyphicon glyphicon-file"
                        , "valid_children": ["default", "file"]
                    }
                    , "file": {
                        "icon": "glyphicon glyphicon-file",
                        "valid_children": []
                    }
                }
                , "plugins": [
                    "contextmenu"
                ]
            });
        }

//    $(function() {
//        configurarTabela({
//            idTabela: 'gerenciar_descritores'
//            , editar: '#!imagens|editarDescritor&descritorID='
//            , deletar: 'index.php?c=imagens&a=removerDescritor&descritorID='
//            , detalhes: true
//            , detalhesIndice: "6"
//            , defs: {
//                "aoColumnDefs": [
//                    {"bSortable": false, "aTargets": [0, 1]},
//                    {"bSearchable": false, "aTargets": [0, 1]}
//                ]
//                , "aaSorting": [[2, 'asc']]
//            }
//        });

    });

</script>