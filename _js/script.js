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

});
