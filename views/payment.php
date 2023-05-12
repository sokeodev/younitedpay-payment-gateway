<ul>
    <?php $check = true; ?>
    <?php foreach ($possible_maturities as $maturity) {
        if (array_key_exists($maturity, $possible_prices)) { ?>

            <?php
            $price = $possible_prices[$maturity];
            ?>

            <li class="younitedpay-checkout-details <?php if ($check) { ?>checked<?php } ?>" <?php if (!$check) { ?>style="margin-top: 0.3rem!important;" <?php } ?>>
                <input required="required" id="payment_method_<?php echo esc_attr($maturity); ?>" type="<?php if ($are_many_offers) { ?>radio<?php } else { ?>hidden<?php } ?>" name="maturity" value="<?php echo esc_attr($maturity); ?>" data-order_button_text="" <?php if ($check) { ?>checked="checked" <?php } ?>>
                <label for="payment_method_<?php echo esc_attr($maturity); ?>"><?php echo sprintf(__('Pay in %s x', WC_YOUNITEDPAY_GATEWAY_LANG), $maturity); ?></label>
                <p>
                    <span><?php echo esc_html__('Financing amount', WC_YOUNITEDPAY_GATEWAY_LANG); ?> : </span><b><?php echo esc_html($price['requested_amount_html']); ?></b>.<br />
                    <span><?php echo esc_html__('Cost of financing', WC_YOUNITEDPAY_GATEWAY_LANG); ?> : </span><b><?php echo esc_html($price['interests_total_amount_html']); ?></b>
                    <span><?php echo sprintf(
                                esc_html__('(i.e. fixed APR of %s, fixed lending rate %s).', WC_YOUNITEDPAY_GATEWAY_LANG),
                                esc_html($price['annual_percentage_rate_html']),
                                esc_html($price['annual_debit_rate_html'])
                            ); ?>
                    </span><br />
                    <span><?php echo esc_html__('Total amount due', WC_YOUNITEDPAY_GATEWAY_LANG); ?> : </span><b><?php echo esc_html($price['credit_total_amount_html']); ?></b>.<br />
                    <span><?php echo esc_html__('Your monthly installments will therefore be', WC_YOUNITEDPAY_GATEWAY_LANG); ?> </span>
                    <b>
                        <?php echo sprintf(
                            esc_html__('%s / month during %s', WC_YOUNITEDPAY_GATEWAY_LANG),
                            esc_html($price['monthly_installment_amount_html']),
                            esc_html($price['maturity_in_months_html'])
                        ); ?>
                    </b><br /><br />
                    <em><?php echo esc_html__('A credit commits you and must be repaid. Check your repayment capacity before you commit.', WC_YOUNITEDPAY_GATEWAY_LANG); ?></em>
                </p>
            </li>
            <?php if ($check) {
                $check = false;
            } ?>
    <?php }
    } ?>
</ul>