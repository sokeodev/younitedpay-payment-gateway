<nav class="nav-tab-wrapper">
    <a href="?page=younitedpay_settings" class="nav-tab 
        <?php if ($option=== "home"){ ?>nav-tab-active<?php } ?>">
        <?php echo esc_html__("Home", WC_YOUNITEDPAY_GATEWAY_LANG); ?>           
    </a>
    <a href="?page=wc-settings&tab=checkout&section=younitedpay-gateway" class="nav-tab <?php if($option==="settings"):?>nav-tab-active<?php endif; ?>">
        <?php echo esc_html__("Settings", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
    </a> 
    <a href="?page=wc-settings&tab=checkout&section=younitedpay-gateway&option=behaviour" class="nav-tab <?php if($option==='behaviour'):?>nav-tab-active<?php endif; ?>">
        <?php echo esc_html__("Behaviour", WC_YOUNITEDPAY_GATEWAY_LANG); ?> 
    </a>
    <a href="?page=wc-settings&tab=checkout&section=younitedpay-gateway&option=appearance" class="nav-tab <?php if($option==='appearance'):?>nav-tab-active<?php endif; ?>">
        <?php echo esc_html__("Appearance", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
    </a>
    <a href="?page=younitedpay_settings&option=faq" class="nav-tab <?php if($option==='faq'):?>nav-tab-active<?php endif; ?>">
        <?php echo esc_html__("Q/A", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
    </a>
    <a href="?page=wc-status&tab=logs" class="nav-tab">
        <?php echo esc_html__("Logs", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
    </a>
    <a href="?page=younitedpay_settings&option=support" class="nav-tab 
        <?php if ($option == "support"){ ?>nav-tab-active<?php } ?>">
        <?php echo esc_html__("Support", WC_YOUNITEDPAY_GATEWAY_LANG); ?>
    </a>
</nav>