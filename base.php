<?php

require __DIR__ . '/config.inc.php';
require __DIR__ . '/_gtw/pagarme/autoload.php'; //LIB PAGAR.ME


$MyAP_KEY = (PAGARME_SANDBOX ? PAGARME_SANDBOX_API_KEY : PAGARME_API_KEY);

$pagarMe = new \PagarMe\Sdk\PagarMe($MyAP_KEY);

$amount = 2590; // R$ 10,00

$postbackUrl = 'https://requestb.in/p9rdpxp9';

$metadata = ['idProduto' => 13933139, 'nameProduto' => "Nome do produto", 'quantProdnto' => 10];

$customer = new \PagarMe\Sdk\Customer\Customer([
    'name' => 'Vinicios Oliveira',
    'document_number' => '45826530570'
        ]);

$transaction = $pagarMe->transaction()->boletoTransaction(
        $amount, $customer, $postbackUrl, $metadata, ['async' => 'false', 'boleto_expiration_date' => '2017/12/11']
);


var_dump($transaction);
