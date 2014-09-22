<?php

require_once __DIR__ . '/seguranca.php';

/**
 * Verificação para proteger páginas de sejem chamadas diretamente pela barra
 * de endereço do navegador.
 * 
 * !!! Atualmente não está em uso !!! @Reuel
 */
function verificarChamada() {

        //Verifica se uma requisição via AJAX está sendo feita, pois todas as páginas
        //devem ser acessadas por ajax.
        if (!filter_has_var(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
            //arquivo está sendo chamado diretamente
            expulsaVisitante("Chamada indevida ao arquivo.");
        }
    }
