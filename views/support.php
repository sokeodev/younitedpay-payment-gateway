<div class="wrap">
    <h1><?php echo esc_html__("YounitedPay Payment Gateway", WC_YOUNITEDPAY_GATEWAY_LANG); ?></h1>

    <div class="wrap">

        <?php include __DIR__."/menu.php"; ?>

        <form method="post" action="https://support.sokeo.fr/"  id="younited_support_form" target="_blank">
            <input type='hidden' name='lang' value='<?php echo esc_attr($sok_lang); ?>' />
            <input type='hidden' name='config' value='<?php echo esc_attr($sok_config);  ?>' />
            <input type='hidden' name='project' value='<?php echo esc_attr($sok_project);  ?>' />
            <input type='hidden' name='log' value='<?php echo esc_attr($sok_log);  ?>' />
            <input type='hidden' name='hmac' value='<?php echo esc_attr($sok_hmac);  ?>' />
            <input type='hidden' name='site' value='<?php echo esc_url(get_site_url())  ?>' />
            <input type='hidden' name='customer' value='<?php echo esc_attr($sok_customer_id);  ?>' />
            <input type='hidden' name='support' value='sokeo-support' />
        </form>

        <table class="form-table">
            <tr valign="top">
                <td class="forminp">
                    <h2><?php echo esc_html__('A question about Younited Pay?', WC_YOUNITEDPAY_GATEWAY_LANG ); ?></h2>
                    <span><?php echo esc_html__('If your question concerns the Younited Pay solution or your business relationship with Younited,', WC_YOUNITEDPAY_GATEWAY_LANG ); ?></span>
                    <br>
                    <span><?php echo esc_html__('you can reach a technical team or your account manager from your YounitedPay Back Office via our ticketing system.', WC_YOUNITEDPAY_GATEWAY_LANG ); ?></span><br><br>
                    <span><?php echo esc_html__('If your question concerns technical difficulties with the WooCommerce module, please contact our support team via the button below.', WC_YOUNITEDPAY_GATEWAY_LANG ); ?></span>                    
                </td>
            </tr>
        </table>
        <p class="submit">
            <button 
                onclick="(function(){ document.getElementById('younited_support_form').submit(); })()"
                class="button-primary woocommerce-save-button">            
                <?php echo esc_html__('Contact Support', WC_YOUNITEDPAY_GATEWAY_LANG ); ?>
            </button>
        </p>
    </div>               
</div>