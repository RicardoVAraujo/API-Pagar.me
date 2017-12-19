   <?php 

    /*
     * API PAGAR.ME
     * Configuração API de comunicação com a pagarme
     */
    define('PAGARME_SANDBOX', 1); //ATIVA MODO SANDBOX
    define('PAGARME_SANDBOX_API_KEY', "ak_test_LGUvwk2yifCvwyj2DJzR4DvEerK0q0"); //API_KEY MODO SANDBOX
    define('PAGARME_SANDBOX_ENCRYPTION_KEY', "ek_test_DPE7ittFDmGz1BfEhdOaT9c0I6Vc7S"); //API_KEY MODO SANDBOX

    define('PAGARME_API_KEY', "ak_test_LGUvwk2yifCvwyj2DJzR4DvEerK0q0"); //API_KEY MODO PRODUÇÂO
    define('PAGARME_ENCRYPTION_KEY', "ek_test_DPE7ittFDmGz1BfEhdOaT9c0I6Vc7S"); //API_KEY MODO PRODUÇÂO
    
    define('PAGARME_MAX_PARC', 12); //Numero Maximo de Parcelas
    define('PAGARME_TX_JUROS', 3.99); //Taxas de Juros
