<?php

class PagarmeBS {

    private $PagarmeUrl; //API URL
    private $PagarmeKey; //API KEY
    private $PagarmeAction; //API AÇÂO
    private $PagarmeActionValue; //API AÇÂO VALOR
    private $PagarmeAPI; //LINK FINAL
    private $PagarmeData; //DADOS RECEBIDOS
    private $PagarmeResult; //MANDA RESULTADOS
    private $PagarmeError; //MANDA ERRO

    /**
     * Método construtor 
     * 
     * Verifica se existem as funções curl_init() e json_decode() 
     *  utilizadas pela classe 
     */

    public function __construct() {
        $this->PagarmeKey = "?api_key=" . (PAGARME_SANDBOX ? PAGARME_SANDBOX_API_KEY : PAGARME_API_KEY);
        $this->PagarmeUrl = 'https://api.pagar.me/1/';
    }

    public function getResult() {
        return $this->PagarmeResult;
    }

    public function getError() {
        return $this->PagarmeError;
    }

    public function ObterParcelas($valorFinal) {
        $this->PagarmeActionValue = "&interest_rate=" . PAGARME_TX_JUROS . "&amount=" . $valorFinal;

        $this->Conect("transactions/calculate_installments_amount", $this->PagarmeActionValue);
        $Data = $this->GetCurl();

        $Result = [];
        $i = 0;
        foreach ($Data['installments'] as $P):
            $VL = $P['amount'];
            $P['amount'] = $P['amount'] * 0.01;
            $VF = number_format($P['amount'], '2', ',', '.');
            $VM = number_format($P['amount'] / $P['installment'], '2', ',', '.');
            if ($i <= PAGARME_MAX_PARC):
                $Result[$i] = ['valorfinal' => $VF, 'valormes' => $VM, 'numparcelas' => $P['installment'], 'valorlimpo' => $VL];
            endif;
            $i++;
        endforeach;

        $this->PagarmeResult = $Result;
    }

    /*     * *******************************
     * Metodos Privados
     * ******************************** */

    private function Conect($action, $value = null) {
        $this->PagarmeAction = $action;
        $this->PagarmeAPI = $this->PagarmeUrl . $this->PagarmeAction . $this->PagarmeKey . (!empty($value) ? $value : null);
    }

    private function GetCurl() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($curl, CURLOPT_URL, $this->PagarmeAPI);

        $result = curl_exec($curl);
        if ($result == false) {
            error_log("curl_exec threw error \"" . curl_error($curl) . "\" for " . $this->PagarmeAPI);
        }
        curl_close($curl);
        return json_decode($result, true);
    }

}
