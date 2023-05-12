<?php if(!$ajax) { ?><div id="bestprice-container"><?php } ?>
    <?php if($visible) { ?>
    <div id="bestprice-bloc" class="bestprice-bloc" style="font-size:1.1rem;">
        <div class="bestprice-desc">
            <?php echo esc_html__("Either", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
            <b>
                <?php echo sprintf(
                    esc_html__("%s / months", WC_YOUNITEDPAY_GATEWAY_LANG),
                    esc_html($default_price['monthly_installment_amount_html'])
                ); ?>
            </b>
            <?php echo esc_html__("with financing in", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
            <span class='default_maturity'><?php echo esc_html($default_price['maturity_in_months']); ?></span>
            <?php echo esc_html__("monthly installments with", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
        </div>
        <div class="bestprice-action">
            <img width="150" class="younited-logo" src="<?php echo esc_url(plugins_url("../assets/img/".esc_attr($logo), __FILE__)); ?>">
        </div>
    </div>

    <div id="modal-bestprice" style="display:none">
        <div class="modal-bestprice">
            <div class="modal-bestprice-bloc">
                <div class="modal-bestprice-left">
                    <img src="<?php echo esc_url(plugins_url("../assets/img/logo-youpay-black.svg", __FILE__)); ?>" alt="youpay">
                    <div class="">
                        <?php echo esc_html__('Simple.', WC_YOUNITEDPAY_GATEWAY_LANG); ?>
                        <br>
                        <?php echo esc_html__('Instant.', WC_YOUNITEDPAY_GATEWAY_LANG); ?>
                        <br>
                        <?php echo esc_html__('Secure.', WC_YOUNITEDPAY_GATEWAY_LANG); ?>
                        <br>
                    </div>
                    <ul class="">
                        <li class=""><?php echo esc_html__('It has never been easier to pay in installments.', WC_YOUNITEDPAY_GATEWAY_LANG); ?></li>
                    </ul>
                    <p class="">
                        <span class="">
                            <img src="<?php echo esc_url(plugins_url("../assets/img/youpay-cb.svg", __FILE__)); ?>" alt="Cartes Bancaires" />
                        </span>
                        <span class=""> 
                            <img src="<?php echo esc_url(plugins_url("../assets/img/youpay-visa.svg", __FILE__)); ?>" alt="Cartes Visa" />
                        </span>
                        <span class="">
                            <img src="<?php echo esc_url(plugins_url("../assets/img/youpay-mc.svg", __FILE__)); ?>" alt="Cartes Mastercard" />
                        </span>
                    </p>
                    <button id="modal-bestprice-faq" type="button" target="_blank" class="btn btn-primary">
                        <i class="fa-regular fa-circle-question"></i>
                        <span><?php echo esc_html__('A question ? Click here', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                    </button>
                </div>
                <div class="modal-bestprice-right">
                    <div class="modal-bestprice-button">
                        <button>
                            <img width="30" height="30" src="<?php echo esc_url(plugins_url("../assets/img/close.png", __FILE__)); ?>" alt="youpay">
                        </button>
                    </div>
                    <div class="modal-bestprice-content">

                        <div class="woocommerce-variation-price">
                            <p class="modal-bestprice-paiement-sans-frais ">
                            <p class="monthly_installment_amount roc-text">
                                <span><?php echo esc_html__('Your purchase for', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                <span class="big-text bold-text"></span>

                                <?php foreach ($possible_prices as $maturity => $maturity_v) { ?>
                                    <span id="maturity-info-<?php echo esc_html($maturity); ?>" class="maturity-info big-text bold-text" style="display:none">
                                        <?php echo $maturity_v["monthly_installment_amount_html"] ?>
                                    </span>
                                <?php } ?>
                                <span>/ <?php echo esc_html__('month', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                <br>
                                <span><?php echo esc_html__('with', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                <span class="blue-text"><?php echo esc_html__('Younited Pay', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                            </p>
                            </p>
                            <p class="p-acheter">
                                <span><?php echo esc_html__('Buy today and start paying', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                <span class="bold-text"><?php echo esc_html__('after 30 days.', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                            </p>
                        </div>

                        <ul class="">
                            <?php foreach ($possible_prices as $maturity => $maturity_v) { ?>
                                <li data-maturity-id="<?php echo esc_attr($maturity); ?>">
                                    <span>
                                        <div class="maturity maturity_choice_<?php echo esc_attr($maturity); ?>">
                                            <?php echo esc_html($maturity); ?>
                                        </div>  <?php echo esc_html__('month', WC_YOUNITEDPAY_GATEWAY_LANG); ?>
                                    </span>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="modal-bestprice-box-droite">
                            <?php foreach ($possible_prices as $maturity => $maturity_v) { ?>
                                <div id="maturity_bloc_<?php echo esc_html($maturity); ?>" class="maturity_bloc" style="display:none">
                                    <div class="younitedpay-justify-between requested_amount">
                                        <span><?php echo esc_html__('Credit amount', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                        <span class=""><?php echo esc_html($maturity_v["requested_amount_html"]); ?></span>
                                    </div>
                                    <div class="younitedpay-justify-between interests_total_amount">
                                        <span><?php echo esc_html__('+ Credit interest', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                        <span class=""><?php echo esc_html($maturity_v["interests_total_amount_html"]); ?></span>
                                    </div>
                                    <hr class="">
                                    <div class="younitedpay-justify-between credit_total_amount">
                                        <span class="bold-text"><?php echo esc_html__('= total amount due', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                        <span><?php echo esc_html($maturity_v["credit_total_amount_html"]); ?></span>
                                    </div>
                                    <div class="younitedpay-justify-between annual_percentage_rate">
                                        <span class="bold-text"><?php echo esc_html__('Fixed APR', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                        <span class=""><?php echo esc_html($maturity_v["annual_percentage_rate_html"]); ?></span>
                                    </div>
                                    <div class="younitedpay-justify-between annual_debit_rate">
                                        <span class="bold-text"><?php echo esc_html__('Fixed borrowing rate', WC_YOUNITEDPAY_GATEWAY_LANG); ?></span>
                                        <span class=""><?php echo esc_html($maturity_v["annual_debit_rate_html"]); ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <p class="italic-text">
                            <?php echo esc_html__('A credit commits you and must be repaid. Check your repayment capacity before you commit.', WC_YOUNITEDPAY_GATEWAY_LANG); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
<?php if( !$ajax ) { ?></div><?php } ?>
