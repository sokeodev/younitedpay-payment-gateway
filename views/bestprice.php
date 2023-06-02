<?php
$steps = [];
$steps[] = "At checkout step, select <strong>Younited Pay</strong>";
$steps[] = "Choose the repayment <strong>duration</strong>";
$steps[] = "<strong>Simply</strong> and <strong>securely</strong> connect your bank account";
$steps[] = "Receive a response <strong>within seconds</strong>";
?>

<?php if (!$ajax) { ?><div id="younitedpay-bestprice-container"><?php } ?>
    <?php if ($visible) { ?>

        <?php include __DIR__ . "/bestprice_action.php"; ?>

        <div id="younitedpay-bestprice-modal" class="younitedpay-bestprice-modal" style="display:none">
            <div class="younitedpay-bestprice-left">

                <div class="younitedpay-bestprice-title ">
                    <span class="younitedpay-bestprice-title-<?php echo esc_attr($lang); ?>">
                        <?php echo esc_html__('Buy now and pay as you go', 'wc-younitedpay-gateway'); ?>
                    </span>
                </div>
                <div class="younitedpay-bestprice-steps">

                    <?php foreach ($steps as $step_i => $step) : ?>
                        <div>
                            <div>
                                <div><?php echo esc_html__($step_i + 1); ?></div>
                            </div>
                            <span><span><?php echo wp_kses(__($step, 'wc-younitedpay-gateway'), array('strong' => array())); ?></span></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="younitedpay-bestprice-logo">
                    <img src="<?php echo esc_url(plugins_url("../assets/img/logo-youpay-black.svg", __FILE__)); ?>" alt="youpay">
                </div>
            </div>

            <div class="younitedpay-bestprice-right">
                <div>
                    <div class="younitedpay-bestprice-starting-payment">
                        <span><?php echo esc_html__('Start paying in just 30 days', 'wc-younitedpay-gateway'); ?></span>
                        <div class="younitedpay-bestprice-close">
                            <img src="<?php echo esc_url(plugins_url("../assets/img/close.svg", __FILE__)); ?>">
                        </div>
                    </div>

                    <div class="younitedpay-bestprice-payment-info">
                        <span>
                            <?php echo esc_html__('Your purchase for', 'wc-younitedpay-gateway'); ?>

                            <?php foreach ($possible_prices as $maturity => $maturity_v) { ?>
                                <span class="younitedpay-bestprice-price-per-month" id="younitedpay-maturity-info-<?php echo esc_html($maturity); ?>">
                                    <?php echo sprintf(
                                        esc_html__('%s/month', 'wc-younitedpay-gateway'),
                                        esc_html($maturity_v["monthly_installment_amount_html"])
                                    );
                                    ?>
                                </span>
                            <?php } ?>
                        </span>
                    </div>

                    <div class="younitedpay-bestprice-month-choice">
                        <?php foreach ($possible_prices as $maturity => $maturity_v) { ?>
                            <div data-maturity-id="<?php echo esc_attr($maturity); ?>">
                                <span>
                                    <?php echo esc_html($maturity); ?>&nbsp;<?php echo esc_html__('months', 'wc-younitedpay-gateway'); ?>
                                </span>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>

                    <div class="younitedpay-bestprice-details">
                        <?php foreach ($possible_prices as $maturity => $maturity_v) { ?>
                            <div id="younitedpay-maturity_bloc_<?php echo esc_html($maturity); ?>" class="younitedpay-bestprice-bloc" style="display:none">
                                <div>
                                    <span><?php echo esc_html__('Credit amount', 'wc-younitedpay-gateway'); ?></span>
                                    <span><?php echo esc_html($maturity_v["requested_amount_html"]); ?></span>
                                </div>
                                <div>
                                    <span><?php echo esc_html__('+ Interest on credit', 'wc-younitedpay-gateway'); ?></span>
                                    <span><?php echo esc_html($maturity_v["interests_total_amount_html"]); ?></span>
                                </div>
                                <hr>
                                <div class="younitedpay-bestprice-bloc-lg">
                                    <span><?php echo esc_html__('= Total amount due', 'wc-younitedpay-gateway'); ?></span>
                                    <span><?php echo esc_html($maturity_v["credit_total_amount_html"]); ?></span>
                                </div>
                                <div class="younitedpay-bestprice-bloc-lg">
                                    <span><?php echo esc_html__('Fixed APR', 'wc-younitedpay-gateway'); ?></span>
                                    <span><?php echo esc_html($maturity_v["annual_percentage_rate_html"]); ?></span>
                                </div>
                                <div>
                                    <span><?php echo esc_html__('(excluding optional insurance)', 'wc-younitedpay-gateway'); ?></span>
                                    <span></span>
                                </div>
                                <div>
                                    <span><?php echo esc_html__('Fixed lending rate', 'wc-younitedpay-gateway'); ?></span>
                                    <span><?php echo esc_html($maturity_v["annual_debit_rate_html"]); ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div>
                    <p class="younitedpay-bestprice-credit">
                        <?php if ($lang == "fr") {
                            echo "Un crédit vous engage et doit être remboursé. Vérifiez vos capacités de remboursement avant de vous engager.";
                        } else if ($lang == "es") {
                            echo "Empieza a pagar dentro de 30 días";
                        }
                        /* Pas de traduction en anglais */
                        ?>

                    </p>
                </div>
            </div>

        </div>
    <?php } ?>
    <?php if (!$ajax) { ?>
    </div><?php } ?>