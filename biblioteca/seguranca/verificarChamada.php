<?php

//ob_clean();
/**
 * Esse arquivo será incluso ao inicio de todos os demais arquivos carregados,
 * via configuração apache, para evitar que os arquivos da aplicação sejam 
 * chamados diretamente, sem o MVC como intermediário.
 * Basicamente o que é verificado, é se uma requisição AJAX está sendo feita
 * para buscar as páginas e carregar-las.
 * 
 * Muita atenção e cuidado deve ser voltada para esse arquivo, pois, a configuração
 * do arquivo php.ini que permite que isso seja feito é global, ou seja, qualquer
 * outro site também hospedado na mesma máquina, sendo executanda pela mesma
 * instalação PHP, irá também inserir esse arquivo no início de todas as páginas
 * solicitadas.
 * 
 * O arquivo deve portanto apenas fazer as verificações básicas necessárias,
 * evitando qualquer chamada a funções como session_start(), ob_start() e outras
 * que irão influenciar o comportamento de outros sites.
 * 
 * @author Reuel Ramos Ribeiro <a11021@bcc.unifal-mg.edu.br>
 */
require_once __DIR__ . '/seguranca.php';

//  *** Antiga verificação que era feita no php instalado em uma plataforma linux. ***
//print_r($_SERVER);
//if (substr_count($_SERVER['REQUEST_URI'], APP_LOCATION) > 0) {
//    if ($_SERVER['SCRIPT_FILENAME'] == '/var/www' . $_SERVER['PHP_SELF']) {
//        //arquivo está sendo chamado diretamente
//        expulsaVisitante("Chamada indevida ao arquivo.");
//    }
//}
//if (substr_count($_SERVER['REQUEST_URI'], APP_LOCATION) > 0) {
// ***  Nova solução, provavelmente mais robusta e mais portável    ***
//Verifica se foi a aplicação controle-cead que está chamando a página
$uri_requisicao = filter_input(INPUT_SERVER, 'REQUEST_URI');
if (preg_match("#.*" . WEB_SERVER_FOLDER . "?.*#", $uri_requisicao)) {
//    $uri_requisicao = $_SERVER['REQUEST_URI'];
    //Verificamos se é uma das páginas listadas como excessões, as quais não precisamos
    //verificar o acesso.
    $ret = preg_replace("#^/controle-cead(/((index|sair|logar|lembrarSenha)\.php(\?(m|tolken)=.*)?|biblioteca.*)?)?#", "", $uri_requisicao);
    if ($ret !== "") {
        //É uma página que não pertence às excessões, definidas pela REGEX acima.
        //Verifica se uma requisição via AJAX está sendo feita, pois todas as páginas
        //devem ser acessadas por ajax.
        if (!filter_has_var(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
            //arquivo está sendo chamado diretamente
            expulsaVisitante("Chamada indevida ao arquivo.");
        }
    }
}
