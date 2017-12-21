/* 
 Created on : 06/12/2017, 21:32:28
 Author     : Vinicios Oliveira
 */

$(function () {

//############## ACTTIONS MODAL DEFAULT
//Open Modal
    $('html').on('click', '.bs_modal_open', function () {
        var ID = $(this).attr('rel');
        var Modal = '#' + $(this).attr('rel');

        //Abre Modal 
        $(".bs_modal" + Modal + " .bs_moda_close").attr('rel', ID);
        $(".bs_modal" + Modal).fadeIn(function () {
            $(".bs_modal" + Modal + " .bs_modal_base").animate({'opacity': 1, 'top': '0'}, 300);
        });

        //Close Modal 
        $('.bs_moda_close').click(function () {
            var Modal = '#' + $(this).attr('rel');

            //efeito close
            $(".bs_modal" + Modal + " .bs_modal_base").animate({'opacity': 0.5, 'top': '-1000px'}, 300, function () {
                $(".bs_modal" + Modal).fadeOut(100);
            });
        });

    });




//Chamada Modulos Adicionais para o Payment
    if ($('.paymentAPI').length) {
        $.getScript('https://assets.pagar.me/pagarme-js/3.0/pagarme.min.js'); //API      
        $.getScript('_js/jquery.payment.min.js', function () {
            $("input[name='card_number']").payment('formatCardNumber');
            $("input[name='card_cvv']").payment('formatCardCVC');
            $("input[name='card_expiration_date']").payment('formatCardExpiry');
            $(".numberOnly").payment('restrictNumeric');
        });
    }


////############## SUBMIT FORM PAYMENT
    $("body").on("submit", "form[name='paymentCard']", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var Form = $(this);

        $('.form_load').fadeIn(); //LOAD

        $('.payment_check_error').fadeOut(1, function () {
            $(this).remove();
        });

        var cardType = $.payment.cardType($("input[name='card_number']").val());
        if (!$.payment.validateCardNumber($("input[name='card_number']").val())) {
            $("input[name='card_number']").after("<p class='payment_check_error'>&#10008; O número do cartão não é válido! </p>");
            $('.form_load').fadeOut();
        } else if (!$.payment.validateCardCVC($("input[name='card_cvv']").val(), cardType)) {
            $("input[name='card_cvv']").after("<p class='payment_check_error'>&#10008; O CVV deve ter 3 ou 4 números!</p>");
            $('.form_load').fadeOut();
        } else if (!$.payment.validateCardExpiry($("input[name='card_expiration_date']").payment('cardExpiryVal'))) {
            $("input[name='card_expiration_date']").after("<p class='payment_check_error'>&#10008; A data informada não é valida </p>");
            $('.form_load').fadeOut();
        } else if ($("input[name='card_holder_name']").val().length < 9) {
            $("input[name='card_holder_name']").after("<p class='payment_check_error'>&#10008; Favor informe o nome impresso no cartão!</p>");
            $('.form_load').fadeOut();
        } else {
            var card = {};
            card.card_holder_name = $("input[name='card_holder_name']").val();
            card.card_expiration_date = $("input[name='card_expiration_date']").val();
            card.card_number = $("input[name='card_number']").val();
            card.card_cvv = $("input[name='card_cvv']").val();

            var cardValidations = pagarme.validate({card: card});
            if (!cardValidations.card.card_number) {
                $("input[name='card_number']").after("<p class='payment_check_error'>&#10008; O número do cartão não é válido! </p>");
            } else {
                pagarme.client.connect({encryption_key: $("input[name='encryption_key']").val()}).then(client => client.security.encrypt(card)).then(card_hash => {

                    var Data = Form.serialize() + "&cardhash=" + card_hash;
                    $.post('_ajax/callback.ajax.php', Data, function (data) {

                        //EXIBE ERROS IN FIELD   
                        if (data.error) {
                            $('.form_load').fadeOut(100);
                            if (data.field) {
                                Form.find("input[name='" + data.field + "']").after(data.error);
                            } else {
                                var Inputs = Form.find('input, select');
                                Inputs.each(function (index, elem) {
                                    if (!elem.value) {
                                        $(this).after(data.error);
                                    }
                                });
                            }
                            $('.payment_check_error').fadeIn();
                        }

                        //DATA DINAMIC CONTENT
                        if (data.divcontent) {
                            $.each(data.divcontent, function (key, value) {
                                $(key).html(value);
                            });
                        }

                        $('.form_load').fadeOut();
                    }, 'json');

                });
            }
        }
    });

});
