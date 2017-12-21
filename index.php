<!DOCTYPE html>
<!--
INTEGRAÇÃO COM A PAGAR.ME
V8DESIGN - VINICIOS OLIVEIRA
-->

<?php
require './config.inc.php'; //parametro de Configuração
$Price = "10.50"; //Valor a ser Pago em decimal "informe centavos com . na frente"
?>
<html>
    <head>
        <title>Integrando a Pagar.me API</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--CSS-->
        <link href="_css/bootstrap.min.css" rel="stylesheet">
        <link href="_css/fonticon.css" rel="stylesheet">
        <link href="_css/base.css" rel="stylesheet">

    </head>
    <body>
        <div class="site-wrapper">
            <div class="site-wrapper-inner">
                <div class="cover-container">

                    <div class="masthead clearfix">
                        <div class="inner">
                            <h3 class="masthead-brand"><img src="_img/v8design_w_.svg" width="300"/></h3>
                            <nav class="nav nav-masthead">
                                <a class="nav-link active" href="#">#ConectandoVocê</a>
                            </nav>
                        </div>
                    </div>

                    <div class="inner cover">
                        <h1 class="cover-heading">Integração com a API PAGAR.ME</h1>
                        <p class="lead">Realizando transações por Cartão de Credito e Boleto Bancario de forma rapida, pratica e objetiva.</p>
                        <p class="lead">
                            <a href="#" class="btn btn-lg btn-secondary bs_modal_open" rel="OpenCreatebillet">Pagar por Boleto Bancario</a>
                            <a href="#" class="btn btn-lg btn-secondary bs_modal_open" rel="OpenCreateCard">Pagar por Cartão</a><br>
                            <br><a href="#" class="btn btn-lg btn-secondary bs_modal_open" rel="OpenCreateModal">Bônus MODAL</a>
                        </p>
                    </div>

                    <div class="mastfoot">
                        <div class="inner">
                            <p>Estruturado e desenvolvido pela <a href="https://www.v8design.com.br">V8 Design</a>, by <a href="https://www.facebook.com/vinicios.18">Vinicios Oliveira</a>.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--MODAL Cartão de Credito-->
        <div class="bs_modal" id="OpenCreateCard" style="display: none;">
            <article class="bs_modal_base">
                <header style="background: #ffb100;">
                    <span class="bs_moda_close icon-cross icon-notext"></span>
                    <h1>Pagamento por Cartão</h1>
                </header>
                <form class="paymentAPI" name="paymentCard" action="" method="post" enctype="multipart/form-data">
                    <input type='hidden' name='callback' value='valideCard'/> 
                    <input type='hidden' name='encryption_key' value='<?= (PAGARME_SANDBOX ? PAGARME_SANDBOX_ENCRYPTION_KEY : PAGARME_ENCRYPTION_KEY); ?>'/>

                    <div class="bs_modal_content">
                        <h2>Informe os dados de seu cartão:</h2>
                        <h2 style="font-size: 1em;">Pagamento de R$ <?= number_format($Price, '2', ',', '.'); ?></h2>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Numero do Cartão</label>
                                <input class='form-control cardNumber' type='tel' name='card_number' placeholder='•••• •••• •••• ••••'>
                            </div>                            
                            <div class="form-group col-md-6">
                                <label>CVV</label>
                                <input class="form-control" type='tel' name='card_cvv' placeholder='•••'>
                            </div>                     

                            <div class="form-group col-md-6">
                                <label>Vencimento</label>
                                <input class="form-control" type='tel' maxlength='7' name='card_expiration_date' placeholder='•• / ••'>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Parcelamento</label>
                                <select class="form-control" name="cardInstallmentQuantity" id="inputState">
                                    <?php
                                    $Payment = new PagarmeBS;
                                    $Payment->ObterParcelas(number_format($Price, '2', '', ''));
                                    foreach ($Payment->getResult() as $P):
                                        echo "<option value='{$P['valorlimpo']}/{$P['numparcelas']}' >{$P['numparcelas']}x de R$ {$P['valormes']} - Total R$ {$P['valorfinal']}</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nome Completo</label>
                                <input class="form-control" type='text' name='card_holder_name' placeholder='Nome: (igual no cartão)'>
                            </div> 

                            <div class="form-group col-md-6">
                                <label>CPF</label>
                                <input type='text' class='numberOnly form-control' maxlength='11' name='cardCPF' placeholder='CPF: (Titular do cartão)'>
                            </div> 
                        </div>

                    </div>
                    <footer>
                        <button name="public" value="1" class="btn btn-dark">Enviar <img class="form_load" style="margin-left: 10px; display: none; width: 25%;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load_w.gif"/></button>
                    </footer>
                </form>
            </article>
        </div>	

        <!--MODAL Boleto Bancario-->
        <div class="bs_modal" id="OpenCreatebillet" style="display: none;">
            <article class="bs_modal_base">
                <header style="background: #9c27b0;">
                    <span class="bs_moda_close icon-cross icon-notext"></span>
                    <h1>Pagamento por Boleto Bancario</h1>
                </header>
                <div class="bs_modal_content">
                    <h2>Realizar o Pagamento:</h2>
                    <h2 style="font-size: 1em;">Pagamento de R$ <?= number_format($Price, '2', ',', '.'); ?></h2>
                    <br>
                    <a href="#" class="btn btn-dark btn_billet">Gerar Boleto</a>
                </div>
                <footer>
                    Pagamento por boleto podem demorar até 2 dias úteis para ser compensado
                </footer>
                </form>
            </article>
        </div>
        
        
          <!--MODAL bonus-->
        <div class="bs_modal" id="OpenCreateModal" style="display: none;">
            <article class="bs_modal_base">
                <header>
                    <span class="bs_moda_close icon-cross icon-notext"></span>
                    <h1>Modal de Bonus</h1>
                </header>
                <div class="bs_modal_content">
                     <!-- Insira o conteudo da modal -->
                </div>
                <footer>
                  <!-- Insira um botão ou uma menssagem aqui -->
                </footer>
                </form>
            </article>
        </div>

        <script type="text/javascript" src="_js/jquery-3.2.1.min.js"></script><!-- Jquery -->
        <script type="text/javascript" src="_js/script.js"></script><!-- scripts -->
    </body>
</html>
