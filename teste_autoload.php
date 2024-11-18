<?php

require_once __DIR__ . '/vendor/autoload.php';

if (class_exists('MercadoPago\SDK')) {
    echo "A classe MercadoPago\SDK foi carregada com sucesso.";
} else {
    echo "Erro: A classe MercadoPago\SDK não foi encontrada.";
}
