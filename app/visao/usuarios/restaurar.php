<title>Usuários inativos</title>
<!-- Início da página --><div class="btn-toolbar">
    <div class="btn-group">
        <!--<a href="#!usuarios|novo" class="btn btn-adicionar"><i class="icon-user"></i> Adicionar novo</a>-->
        <!--<button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>-->
        <button class="btn btn-info btn-ativar" href="#"><i class="icon-ok-circle"></i> Ativar</button>
    </div>
</div>
<table id="gerenciar_usuario" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Nome completo</th>
            <th>Email</th>
            <th>Data de nascimento</th>
            <th>CPF</th>
            <th>Papel</th>
            <th>Permissões</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->usuarios as $value) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($value) / 2; $i++) {
                echo $i == 0 ? '<td hidden class="campoID">' : '<td>';
                echo $value[$i];
                echo '</td>';
            }
            echo '<td><center><input class="btn visualizarPermissoes" type="button" value="Ver"/></center></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<div class="btn-toolbar">
    <div class="btn-group">
        <!--<a href="#!usuarios|novo" class="btn btn-adicionar"><i class="icon-user"></i> Adicionar novo</a>-->
        <!--<button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>-->
        <button class="btn btn-info btn-ativar" href="#"><i class="icon-ok-circle"></i> Ativar</button>
    </div>
</div>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'gerenciar_usuario',
//            editar: '#!usuarios|editar&userID=',
            ativar: 'index.php?c=usuarios&a=ativar&userID='
        });
    });


</script>