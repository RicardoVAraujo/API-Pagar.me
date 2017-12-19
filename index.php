<!DOCTYPE html>
<!--
INTEGRAÇÃO COM A PAGAR.ME
V8DESIGN - VINICIOS OLIVEIRA
-->
<html>
    <head>
        <title>Integrando a Pagar.me API</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--CSS-->
        <link href="_css/bootstrap.min.css" rel="stylesheet">
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
                            <a href="#" class="btn btn-lg btn-secondary">Pagar por Boleto Bancario</a>
                            <a href="#" class="btn btn-lg btn-secondary">Pagar por Cartão</a>
                            <span class="btn btn_yellow bs_modal_open icon-connection" rel="OpenCreateAlert">Registrar Alerta</span>
                        </p>
                    </div>

                    <div class="mastfoot">
                        <div class="inner">
                            <p>Estruturado e desenvolvido pela <a href="https://www.v8design.com.br">V8 Design</a>, by <a href="https://twitter.com/mdo">Vinicios Oliveira</a>.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--MODAL-->
        <div class="bs_modal" id="OpenCreateAlert" style="display: none;">
            <article class="bs_modal_base">
                <header style="background: #ffb100;">
                    <span class="bs_moda_close">x</span>
                    <h1 class="icon-connection">Registrar Alerta</h1>
                </header>
                <form class="form-horizontal" name="page_add" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="AppMapsAlert"/>
                    <input type="hidden" name="callback_action" value="manage"/>

                    <div class="bs_modal_content">
                        <p>Informe abaixo o CEP e o tipo do alerta que deseja registrar</p>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Address 2</label>
                            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">City</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">State</label>
                                <select id="inputState" class="form-control">
                                    <option selected>Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputZip">Zip</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"> Check me out
                                </label>
                            </div>
                        </div>


                    </div>
                    <footer>
                        <button name="public" value="1" class="btn btn-dark">Enviar <img class="form_load" style="margin-left: 10px; display: none" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load_w.gif"/></button>
                    </footer>
                </form>
            </article>
        </div>	

        <script type="text/javascript" src="_js/jquery-3.2.1.min.js"></script><!-- Jquery -->
        <script type="text/javascript" src="_js/script.js"></script><!-- scripts -->
    </body>
</html>
