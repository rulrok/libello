<?php

function obterHoraAtual($formato = 'h:i:s') {
    date_default_timezone_set(APP_TIME_ZONE);
    return date($formato);
}

function obterDataAtual($formato = 'Y-m-j') {
    date_default_timezone_set(APP_TIME_ZONE);
    return date($formato);
}
