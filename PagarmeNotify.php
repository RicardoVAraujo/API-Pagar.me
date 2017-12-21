<?php

$Notification = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if ($Notification):
    require './config.inc.php';

    $TransactionId = $Notification['id'];
    $TransactionStatus = $Notification['current_status'];

    if ($TransactionId || $TransactionStatus):

        if ($TransactionStatus == "processing"):
            /*
             * AGUARDANDO PAGAMENTO
             */
            echo "Tudo Certo <b>processing</b>";

        elseif ($TransactionStatus == "waiting_payment"):
            /*
             * EM ANÁLISE
             */
            echo "Tudo Certo <b>waiting_payment</b>";

        elseif ($TransactionStatus == "paid"):
            /*
             * PAGO
             */
            echo "Tudo Certo <b>paid</b>";

        elseif ($TransactionStatus == "refused"):
            /*
             * CANCELADO
             */

            echo "Tudo Certo <b>refused</b>";
        endif;

    endif;


elseif (empty($Notification['id']) || empty($Notification['current_status'])):
    die('Parametros Invalidos!');
else:
    die('Acesso Negado!');  
endif;