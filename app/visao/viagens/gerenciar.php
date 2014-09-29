<title>Gerenciar viagens</title>
<!-- Início da páginas -->
<span></span>
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
                    echo '<td align="center">';
                }
                if($i == 5){
                    echo '<select class="status">';
                    echo $value[$i] == 'Planejada'? '<option selected="selected" value="Planejada">Planejada</option>':'<option value="Planejada">Planejada</option>';
                    echo $value[$i] == 'Confirmada'? '<option selected="selected" value="Confirmada">Confirmada</option>':'<option value="Confirmada">Confirmada</option>';
                    echo $value[$i] == 'Executada'? '<option selected="selected" value="Executada">Executada</option>':'<option value="Executada">Executada</option>';
                    echo $value[$i] == 'Cancelada'? '<option selected="selected" value="Cancelada">Cancelada</option>':'<option value="Cancelada">Cancelada</option>';
                    echo '</select>';
                }else{
                    echo $value[$i];
                }
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
        
        $('.status').change(function(){
                    var id = $('.campoID', $(this).parent().parent()).text();
                    var estado = $('option:selected',$(this)).val();
                     $.getJSON("index?c=viagens&a=acoes&alterar=alterarEstado&idViagem="+id+"&estadoViagem="+estado,
                                    function(data) {
                                        document.paginaAlterada = false;
                                        exibirPopup('Estado alterado com sucesso!', 'sucesso');
                                    }
                            );
        });
        
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
//        exibirPopup("Duplo clique nas linhas <br/>mostra a descrição<br/>do viagem","Info")
    });

</script>