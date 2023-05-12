jQuery(function ($) {
    $(document).ready(function () {

        //Open modal
        $('body').on('click', '#bestprice-bloc .bestprice-action', function () {
            $("#modal-bestprice").css("display", "flex");
            var maturity = $('body').find('.default_maturity').html();
            var parent_ul = $('.modal-bestprice-right>div>ul');
            var maturity_to_select = parent_ul.find('.maturity.maturity_choice_' + maturity);
            maturity_to_select.closest('li').click();
        });

        //event click on maturity li in modal
        $('body').on('click', '#modal-bestprice .modal-bestprice-right li', function () {
            $('#modal-bestprice .modal-bestprice-right li').removeClass('checked');
            $(this).addClass('checked');

            var maturity = $(this).data("maturity-id");
            $('.maturity_bloc').css("display", "none");

            //bloc infos
            $("#maturity_bloc_" + maturity).css("display", "block");

            //titre
            $(".maturity-info").css("display", "none");
            $("#maturity-info-" + maturity).css("display", "inline-flex");
        });

        $('body').on('click', '#modal-bestprice-faq', function () {
            window.open("https://www.younited-credit.com/questions-reponses", "_blank")
        });

        // Close popup
        $('body').on('click', '#modal-bestprice .modal-bestprice-button button', function () {
            $("#modal-bestprice").css("display", "none");
        });

        $('.variations_form').on('change', 'select', function () {
            var variation_data = $('.variations_form').data('product_variations');
            // Récupère tous les éléments de sélection de variations
            var selectors = $('.variations_form select');

            // Initialise la chaîne d'ID de variations sélectionnées
            var selected_ids = '';

            // Boucle à travers les sélecteurs pour construire la chaîne d'ID
            selectors.each(function () {
                selected_ids += $(this).val() + '-';
            });

            // Supprime le dernier tiret de la chaîne
            selected_ids = selected_ids.slice(0, -1);
            
            // Récupère le prix correspondant à la combinaison de variations sélectionnées
            var price = 0;
            for (var i = 0; i < variation_data.length; i++) {
                var variation = variation_data[i];
                var variation_combination = "";
                for (let var_att in variation.attributes) {
                    variation_combination += variation.attributes[var_att] + '-';
                }
                // Supprime le dernier tiret de la chaîne
                variation_combination = variation_combination.slice(0, -1);
                if (variation_combination == selected_ids) {
                    price = variation.display_price;
                    break;
                }
            }

            if(price){
                wp.ajax.send('fetch_shortcode_younitedpay', {
                    data: {
                        without_container: true,
                        price: price,
                        action: 'fetch_shortcode_younitedpay'
                    },
                    success: function (response) {
                        if (response) {
                            $('#bestprice-container').html("");
                            $('#modal-bestprice').remove();
                            $('#bestprice-container').html(response);
                            document.body.appendChild(document.getElementById('modal-bestprice'));
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    });
});