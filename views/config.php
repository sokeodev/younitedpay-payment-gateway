
<style>
    table{
        background-color:white;
    }
    table th,td{
        padding-left: 10px ! important;
    }

    <?php if ((!$api_keys_is_defined && ($option=='appearance' || $option=='behaviour' )) ){ ?>
    .button-primary.woocommerce-save-button{
        display: none;
    }
    <?php } ?>
</style>

<div class="wrap">
    <h1><?php echo esc_html__("YounitedPay Payment Gateway", WC_YOUNITEDPAY_GATEWAY_LANG); ?></h1>

    <div class="wrap">

        <?php include __DIR__."/menu.php"; ?>

        <div class="tab-content">
            
                <table class="form-table" <?php if($option=='behaviour' || $option=='appearance'):?>style="display:none"<?php endif; ?> >
                    <?php echo $settings_fields; ?> 
                </table>

                <?php if(!$api_keys_is_defined && ($option=='appearance' || $option=='behaviour' )){ ?>
                <table class="form-table">                   
                    <h2> <?php echo esc_html__("Please enter you API credentials before changing the module's settings", WC_YOUNITEDPAY_GATEWAY_LANG); ?></h2>
                </table>
                <?php } ?>

                <table class="form-table" <?php if(!$api_keys_is_defined || $option== 'settings' || $option=='appearance'):?>style="display:none"<?php endif; ?>>
                    <?php echo $behaviour_fields; ?>
                </table>

                <table class="form-table" <?php if(!$api_keys_is_defined || $option== 'settings' || $option=='behaviour'):?>style="display:none"<?php endif; ?>>
                    <?php echo $appearance_fields ?>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <label for="woocommerce_younitedpay-gateway_monthly_installments_widget">
                                <?php echo esc_html__("Monthly installments Widget", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
                            </label>
                        </th>
                        <td class="forminp">
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php echo esc_html__("Monthly installments Widget", WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                </legend>
                                <input 
                                    id="shortcode"
                                    class="input-text regular-input " 
                                    type="text"
                                    value="[younitedpay]"
                                    disabled
                                >
                                <button class="button-primary" onclick="(function(){
                                    const shortcode_element = document.getElementById('shortcode');
                                    shortcode_element.select();
                                    shortcode_element.setSelectionRange(0, 99999);
                                    navigator.clipboard.writeText(shortcode_element.value);
                                })();"><?php echo esc_html__("Copy", WC_YOUNITEDPAY_GATEWAY_LANG); ?></button>
                                <p class="description">
                                <?php echo esc_html__("Alternatively you can copy this code and paste it in any text on the product page.", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                </table>
        </div>
    </div>               
</div>