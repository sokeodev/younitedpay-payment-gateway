<div id="younitedpay-bestprice-action" class="younitedpay-bestprice-action" style="font-size:1.1rem;">
    <div class="younitedpay-bestprice-action-desc">
        <?php echo esc_html__("Either", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
        <b>
            <?php echo sprintf(
                esc_html__("%s / months", WC_YOUNITEDPAY_GATEWAY_LANG),
                esc_html($default_price['monthly_installment_amount_html'])
            ); ?>
        </b>
        <?php echo esc_html__("with financing in", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
        <span class='younitedpay-default-maturity'><?php echo esc_html($default_price['maturity_in_months']); ?></span>
        <?php echo esc_html__("monthly installments with", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
    </div>
    <div class="younitedpay-bestprice-action-button">
        <img width="150" class="younited-logo" src="<?php echo esc_url(plugins_url("../assets/img/" . esc_attr($logo), __FILE__)); ?>">
    </div>
</div>