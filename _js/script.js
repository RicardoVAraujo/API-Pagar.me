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

                        //EXIBE CALLBACKS
                        if (data.alert) {
                            bs_alert(data.alert[0], data.alert[1], data.alert[2], data.alert[3]);
                        }

                        $('.form_load').fadeOut();
                    }, 'json');

                });
            }
        }
    });

////############## Pagar por Boleto
    $('.btn_billet').on('click', function () {
        var Data = "callback=paymentBillet";
        $.post('_ajax/callback.ajax.php', Data, function (data) {

            //EXIBE CALLBACKS
            if (data.alert) {
                bs_alert(data.alert[0], data.alert[1], data.alert[2], data.alert[3]);
            }

            $('.form_load').fadeOut();
        }, 'json');
    });



////############## FUNCTIONS

    //ALERT DISPLAY
    function bs_alert(Color, Icon, Title, Content) {
        if (!$('.bs_alert').length) {
            $("body").append('<div class="bs_alert"><div class="bs_alert_box"><div id="bs_alert_icon" class="icon-notext"></div><div class="bs_alert_text"><p class="bs_alert_title">{TITLE}</p><p class="bs_alert_content">{CONTENT}</p></div><div class="bs_alert_close"><span class="icon-cross icon-notext"></span></div></div></div>');
        } else {
            $('.bs_alert').remove();
            $("body").append('<div class="bs_alert"><div class="bs_alert_box"><div id="bs_alert_icon" class="icon-notext"></div><div class="bs_alert_text"><p class="bs_alert_title">{TITLE}</p><p class="bs_alert_content">{CONTENT}</p></div><div class="bs_alert_close"><span class="icon-cross icon-notext"></span></div></div></div>');
        }

        var bsAlert = $(".bs_alert_box");
        $('.bs_alert').fadeOut(200, function () {
            bsAlert.addClass(Color);
            bsAlert.find('.bs_alert_title').html(Title);
            bsAlert.find('.bs_alert_content').html(Content);
            bsAlert.find('#bs_alert_icon').removeClass().addClass('icon-' + Icon);
            $('.bs_alert').fadeIn(200).css('display', 'flex');
            bsAlert.animate({right: '10px'}, 300);

            //Close Auto
            setTimeout(function () {
                bsAlert.animate({right: '-450px'}, 200, function () {
                    $('.bs_alert').fadeOut(200, function () {
                        setTimeout(function () {
                            $('.bs_alert').remove();
                        }, 210);
                    });
                });
            }, 4000);
        });
    }

//ALERT Close
    $('html').on('click', '.bs_alert_close', function () {
        var bsAlert = $(".bs_alert_box");
        bsAlert.animate({right: '-450px'}, 200, function () {
            $('.bs_alert').fadeOut(200, function () {
                setTimeout(function () {
                    $('.bs_alert').remove();
                }, 210);
            });
        });
    });

});
