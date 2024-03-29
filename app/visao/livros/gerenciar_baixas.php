<title>Gerenciar baixas</title>
<!-- Início da páginas -->
<div class="alert alert-block alert-info" id="aviso"><span class="label label-info">Dica: </span> Duplo clique na linha mostra as observações da baixa<a class="close" data-dismiss="alert" href="#">&times;</a></div>
<div class="btn-toolbar">
    <div class="btn-group">
        <!--<a href="#!livros|novo" class="btn btn-adicionar"><i class="icon-plus"></i> Adicionar novo</a>-->
        <!--<button class="btn btn-editar disabled" href="#"><i class="icon-edit"></i> Editar</button>-->
        <!--<button class="btn btn-saida disabled btn-success" href="#"><i class="icon-arrow-left"></i> Registrar saída</button>-->
        <!--<button class="btn btn-baixa disabled btn-info" href="#"><i class="icon-arrow-down"></i> Registrar Baixa</button>-->
        <button class="btn btn-danger disabled btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<table id="gerenciar_baixas" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Livro</th>
            <th>Data da baixa</th>
            <th>Qtd</th>
            <th>Tipo de baixa</th>
            <th hidden>Descrição</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->baixas as $value) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($value) / 2; $i++) {
                if ($i == 0) {
                    echo '<td hidden class="campoID">';
                } else if ($i == 4) {
                    if (($value[$i] == "")) {
                        echo "<td>livro</td>";
                    } else {
                        echo "<td>Saída</td>";
                    }
                    continue;
                } else if ($i == 5) {
                    echo '<td hidden>';
                    if ($value[$i] == "") {
                        echo "Nenhuma</td>";
                        continue;
                    }
                } else {
                    echo '<td>';
                }
                echo $value[$i];
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<div class="btn-toolbar">
    <div class="btn-group">
        <!--<a href="#!livros|novo" class="btn btn-adicionar"><i class="icon-plus"></i> Adicionar novo</a>-->
        <!--<button class="btn btn-editar disabled" href="#"><i class="icon-edit"></i> Editar</button>-->
        <!--<button class="btn btn-saida disabled btn-success" href="#"><i class="icon-arrow-left"></i> Registrar saída</button>-->
        <!--<button class="btn btn-baixa disabled btn-info" href="#"><i class="icon-arrow-down"></i> Registrar Baixa</button>-->
        <button class="btn btn-deletar disabled btn-danger" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {

        configurarTabela({
            idTabela: 'gerenciar_baixas',
//            editar: '#!livros|editar&livroID=',
            deletar: 'index.php?c=livros&a=remover_baixa&baixaID=',
//            saida: '#!livros|novasaida&livroID=',
//            baixa: "#!livros|novabaixa&livroID=",
            detalhes: true,
            detalhesIndice: "6",
            defs: {
                "aoColumnDefs": [
                    {"bSortable": false, "aTargets": [0, 1]},
                    {"bSearchable": false, "aTargets": [0, 1]}
                ],
                "aaSorting": [[2, 'asc']]
            }
        });
//        exibirPopup("Duplo clique nas linhas <br/>mostra a descrição<br/>do livro","Info")
    });

</script>