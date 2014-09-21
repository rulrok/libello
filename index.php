<?php
ob_start();
//Ignora a verificação do javascript caso uma requisição ajax esteja sendo feita via AJAX
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) :
    ?>
    <!DOCTYPE html>
    <noscript>
    <meta http-equiv="refresh" content="0;url=no-js.php" />
    </noscript>
<?php endif; ?>

<?php
require_once 'biblioteca/configuracoes.php';
require_once 'biblioteca/Mvc/CarregadorAutomatico.php';
require_once 'biblioteca/Mvc/Mvc.php';

if (file_exists(ROOT . 'manutencao.php')) {
    //Modo de manutenção ativo
    $adminLogando = false;
    if (sessaoIniciada()) {
        $usuario = obterUsuarioSessao();
        require_once APP_DIR . 'modelo/enumeracao/Papel.php';
        if ($usuario->get_idPapel() == \app\modelo\Papel::ADMINISTRADOR) {
            $adminLogando = true;
        } else {
            encerrarSessao();
        }
    }
    if (!$adminLogando) {
        require ROOT . 'manutencao/index.php';
        exit;
    }
}

app\controlador\CarregadorAutomatico::registrar();

app\controlador\Mvc::pegarInstancia()->rodar();
ob_end_flush();

