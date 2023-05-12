jQuery(function($) {
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const paymentFailed = urlParams.get('younited-msg');
        if (paymentFailed) {
            var form = $('form[name="checkout"]');
            var text = paymentFailed;
            var html = '<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li>' + text + '</li></ul></div>';
            form.prepend(html);
        }
        
        // Choose maturity in checkout page
        $('body').on('click', 'li.payment_method_younitedpay-gateway fieldset ul li:not(.checked)', function() {
            $('li.payment_method_younitedpay-gateway fieldset ul li.checked').removeClass('checked');
            $(this).addClass('checked');
            $(this).find('input').prop('checked', true);
        });
        
    });
});