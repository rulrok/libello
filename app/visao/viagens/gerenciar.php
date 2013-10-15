<title>Gerenciar viagens</title>
<!-- Início da páginas -->
<div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!viagens|nova" class="btn btn-adicionar"><i class="icon-plane"></i> Adicionar nova</a>
        <button class="btn btn-editar disabled" href="#"><i class="icon-edit"></i> Editar</button>
        <!--<button class="btn btn-danger disabled btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>-->
    </div>
</div>
<table id="gerenciar_viagem" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Curso Vinculado</th>
            <th>Ida</th>
            <th>Volta</th>
            <th>Motivo</th>
            <th>Estado</th>
            <th>Diárias</th>
            <th>Destino</th>
            <!--<th>Destino</th>-->
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->viagens as $value) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($value) / 2; $i++) {
                if ($i == 0) {
                    echo '<td hidden class="campoID">';
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
        <a href="#!viagens|nova" class="btn btn-adicionar"><i class="icon-plane"></i> Adicionar nova</a>
        <button class="btn btn-editar disabled" href="#"><i class="icon-edit"></i> Editar</button>
        <!--<button class="btn btn-deletar disabled btn-danger" href="#"><i class="icon-remove"></i> Excluir</button>-->
    </div>
</div>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {

        configurarTabela({
            idTabela: 'gerenciar_viagem',
            editar: '#!viagens|editar&viagemID=',
            deletar: 'index.php?c=viagens&a=remover&viagemID=',
//            detalhes: true,
//            detalhesIndice: "6",
            defs: {
                "aoColumnDefs": [
                    {"bSortable": false, "aTargets": [0]},
                    {"bSearchable": false, "aTargets": [0, 1]}
                ],
                "aaSorting": [[1, 'asc']]
            }
        });
//        showPopUp("Duplo clique nas linhas <br/>mostra a descrição<br/>do viagem","Info")
    });

</script>