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
            var_dump($PostData);
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
