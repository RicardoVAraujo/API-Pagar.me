<?php

require __DIR__ . '/config.inc.php'; //Obtem Parametros de configuração

$MyAP_KEY = (PAGARME_SANDBOX ? PAGARME_SANDBOX_API_KEY : PAGARME_API_KEY); //Realiza o Balanço para Sandbox e Produção

$pagarMe = new \PagarMe\Sdk\PagarMe($MyAP_KEY); //inicializa a API

$amount = 2590; // R$ 10,00

$postbackUrl = 'https://requestb.in/p9rdpxp9'; //Link de URL

$metadata = ['idProduto' => 13933139, 'nameProduto' => "Nome do produto", 'quantProdnto' => 10]; //Descrições adicionais sobre o Produto

//Informações sobre a pessoa que vai pagar
$customer = new \PagarMe\Sdk\Customer\Customer([
    'name' => 'Vinicios Oliveira',
    'document_number' => '45826530570'
        ]); 

//Realiza a transação
$transaction = $pagarMe->transaction()->boletoTransaction(
        $amount, $customer, $postbackUrl, $metadata, ['async' => 'false', 'boleto_expiration_date' => '2018/02/22']
);

//Exibe Retorno
var_dump($transaction);
