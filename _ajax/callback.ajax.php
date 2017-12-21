<?php

ob_start();
session_start();

require '../config.inc.php';

$jSON = null;
$POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
unset($POST['user_level']);

if ($POST && $POST['callback']):

    //STRIP SCRIPTS
    $DataStrip = array_map("strip_tags", $POST);

    //REMOVE W SPACES
    $DataTrim = array_map("trim", $DataStrip);
    $DataRTrim = array_map("rtrim", $DataTrim);

    //MAKE Callback
    $Callback = $DataRTrim['callback'];
    unset($DataRTrim['callback']);

    //MAKE DATA
    $PostData = $DataRTrim;

    switch ($Callback):
        //Valida dados e envia para API
        case "valideCard":

            if (empty($PostData['cardCPF'])):
                $jSON['alert'] = ['yellow', 'warning', 'Informações imcompletas', '<p><b>Opppssss:</b> Acreditamos que você não informou um CPF!</p>'];
            else:
                //Var Validate
                $parcelas = explode("/", $PostData['cardInstallmentQuantity']);
                $MyAP_KEY = (PAGARME_SANDBOX ? PAGARME_SANDBOX_API_KEY : PAGARME_API_KEY); //Realiza o Balanço para Sandbox e Produção

                $pagarMe = new \PagarMe\Sdk\PagarMe($MyAP_KEY);

                $amount = $parcelas[0];
                $installments = $parcelas[1];
                $capture = true;
                $postbackUrl = 'http://requestb.in/pkt7pgpk';
                $metadata = ['idProduto' => 13933139];

                //TRANSAÇÃO DE CARTÃO DE CRÉDITO
                $customer = new \PagarMe\Sdk\Customer\Customer(
                        [
                    'name' => $PostData['card_holder_name'],
                    'email' => 'john@site.com',
                    'document_number' => $PostData['cardCPF'],
                    'address' => [
                        'street' => 'rua teste',
                        'street_number' => 42,
                        'neighborhood' => 'centro',
                        'zipcode' => '01227200',
                        'complementary' => 'Apto 42',
                        'city' => 'São Paulo',
                        'state' => 'SP',
                        'country' => 'Brasil'
                    ],
                    'phone' => [
                        'ddd' => "15",
                        'number' => "987523421"
                    ],
                    'born_at' => '15021994',
                    'sex' => 'M'
                        ]
                );
                $card = $pagarMe->card()->createFromHash(
                        $PostData['cardhash']
                );
                $transaction = $pagarMe->transaction()->creditCardTransaction(
                        $amount, $card, $customer, $installments, $capture, $postbackUrl, $metadata
                );

                if ($transaction->getId()):
                    $jSON['alert'] = ['green', 'checkmark', 'Transação Realiza com Sucesso', '<p><b>Que lindo!!</b> Viu como é simples realizar uma tranzação por cartão de credito!</p>'];
                endif;
            endif;
            break;

        case "paymentBillet":
            //Pagar por boleto bancario
             $jSON['alert'] = ['blue', 'happy', 'Agora é com vocês', '<p>Criem sua aplicação de pagamento com boleto levando em consideração o conteudo que aprendeu na aula!</p>'];
                
            break;
    endswitch;
endif;

if ($jSON):
    echo json_encode($jSON);
else:
    $jSON['alert'] = ['red', 'warning', 'Erro inesperado!', '<p><b>Opppssss:</b> Um erro inesperado foi encontrado no sistema. Favor atualize a página e tente novamente!</p><p>Caso o erro persista, não deixe de nos avisar enviando um e-mail para atendimento@v8design.com.br'];
    echo json_encode($jSON);
endif;

ob_end_flush();
