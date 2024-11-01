<?php
if (!defined('ABSPATH'))
    exit;

    if (!class_exists('OCWDC_admin_menu')) {

        class OCWDC_admin_menu {

            protected static $OCWDC_instance;
            
            function ocwdc_custom_menu_page() {

                add_menu_page('Web Checker', 'Web Checker', 'edit_pages', 'ocwdc-domain-checker', array($this,'ocwdc_custom_menu_page_func'),"dashicons-admin-site-alt2", 10);
            }

            
            function ocwdc_custom_menu_page_func() {
                ?>
                <div class="wrap">

                    <div class="ocwdc_ratesup_notice_main">
                        <div class="ocwdc_rateus_notice">
                            <div class="ocwdc_rtusnoti_left">
                                <h3>Rate Us</h3>
                                <label>If you like our plugin, </label>
                                <a target="_blank" href="https://wordpress.org/support/plugin/web-domain-checker/reviews/?filter=5#new-post">
                                    <label>Please vote us</label>
                                </a>
                                <label>, so we can contribute more features for you.</label>
                            </div>
                            <div class="ocwdc_rtusnoti_right">
                                <img src="<?php echo OCWDC_PLUGIN_DIR; ?>/includes/images/review.png" class="ocwdc_review_icon">
                            </div>
                        </div>
                        <div class="ocwdc_support_notice">
                            <div class="ocwdc_rtusnoti_left">
                                <h3>Having Issues?</h3>
                                <label>You can contact us at</label>
                                <a target="_blank" href="https://oceanwebguru.com/contact-us/">
                                    <label>Our Support Forum</label>
                                </a>
                            </div>
                            <div class="ocwdc_rtusnoti_right">
                                <img src="<?php echo OCWDC_PLUGIN_DIR; ?>/includes/images/support.png" class="ocwdc_review_icon">
                            </div>
                        </div>
                    </div>
                    <div class="ocwdc_donate_main">
                       <img src="<?php echo OCWDC_PLUGIN_DIR; ?>/includes/images/coffee.svg">
                       <h3>Buy me a Coffee !</h3>
                       <p>If you like this plugin, buy me a coffee and help support this plugin !</p>
                       <div class="ocwdc_donate_form">
                          <a class="button button-primary ocwdc_donate_btn" href="https://www.paypal.com/paypalme/shayona163/" data-link="https://www.paypal.com/paypalme/shayona163/" target="_blank">Buy me a coffee !</a>
                       </div>
                    </div>

                    <h2 class="ocwdc_main_head">Web Checker Setting</h2>
                    <?php
                    if(isset( $_REQUEST['message'] ) &&  $_REQUEST['message'] == 'success') {
                        ?>
                        <div class="notice notice-success is-dismissible">
                            <p><strong>Changes saved successfully.</strong></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="ocwdc-container">
                    <form method="post">
                        <?php wp_nonce_field( 'ocwdc_nonce_action', 'ocwdc_nonce_field' ); ?>
                        <ul class="ocwdc-tabs">
                            <li class="ocwdc-tab-link ocwdc-current" data-tab="ocwdc-tab-general">
                                <?php echo __( 'General Settings', OCWDC_DOMAIN ); ?>
                            </li>
                            <li class="ocwdc-tab-link" data-tab="ocwdc-tab-other">
                                <?php echo __( 'Other Settings', OCWDC_DOMAIN ); ?>
                            </li>
                            <li class="ocwdc-tab-link" data-tab="ocwdc-tab-buy-domain">
                                <?php echo __( 'Buy Domain Settings', OCWDC_DOMAIN ); ?>
                            </li>
                            <li class="ocwdc-tab-link" data-tab="ocwdc-tab-captcha">
                                <?php echo __( 'reCAPTCHA v2 Settings', OCWDC_DOMAIN ); ?>
                            </li>
                        </ul>
                        <div id="ocwdc-tab-general" class="ocwdc-tab-content ocwdc-current">
                            <div class="ocwdc_cover_div">
                                <div class="ocwdc_grp_div">
                                    <h3>Shortcode</h3>
                                    <p class="ocwdc_shrtcdtxt">Use shortcode <strong>[ocwdc-domain-checker]</strong> in any page or post to display domain checker.</p>
                                </div>
                                <div class="ocwdc_grp_div">
                                    <h3>TLDs</h3>
                                    <table class="ocwdc_data_table">
                                        <tr>
                                            <th>TLD Type</th>
                                            <td>
                                                <?php $ocwdc_tldsel_type = get_option( 'ocwdc_tldsel_type', 'dropdown' ); ?>
                                                <p>
                                                    <input type="radio" name="ocwdc_tldsel_type" value="dropdown" <?php if( $ocwdc_tldsel_type == 'dropdown' ) { echo 'checked'; }?>>
                                                    <label>TLDs Dropdown <span class='description'>(If checked then select dropdown of TLDs listed below will be added on domain search box.)</span></label>
                                                </p>
                                                <p>
                                                    <input type="radio" name="ocwdc_tldsel_type" value="limited" <?php if( $ocwdc_tldsel_type == 'limited' ) { echo 'checked'; }?>>
                                                    <label>Limited TLDs <span class='description'>(If checked then only TLDs listed below will be allowed in domain search.)</span></label>
                                                </p>
                                                <p>
                                                    <input type="radio" name="ocwdc_tldsel_type" value="unlimited" <?php if( $ocwdc_tldsel_type == 'unlimited' ) { echo 'checked'; }?>>
                                                    <label>Any TLDs <span class='description'>(If checked then all available TLDs will be allowed in domain search.)</span></label>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>TLDs</th>
                                            <td>
                                                <table class="ocwdc_tld_table">
                                                    <thead>
                                                        <tr>
                                                            <th>TLD</th>
                                                            <th>Price</th>
                                                            <th>Buy Domain Link</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $ocwdc_allowed_tlds_def = array(
                                                            'com' => array('price' => '', 'purchase_link' => ''), 
                                                            'net' => array('price' => '', 'purchase_link' => ''), 
                                                            'org' => array('price' => '', 'purchase_link' => ''), 
                                                            'info' => array('price' => '', 'purchase_link' => '')
                                                        );


                                                        $ocwdc_allowed_tlds = get_option( 'ocwdc_allowed_tlds', $ocwdc_allowed_tlds_def );

                                                        if(!empty($ocwdc_allowed_tlds)) {
                                                            $tlds_counter = 0;

                                                            foreach($ocwdc_allowed_tlds as $tld_key => $tld_data) {
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" name="ocwdctbl_tld[]" value="<?php echo $tld_key; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="ocwdctbl_price[]" value="<?php echo $tld_data['price']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="ocwdctbl_link[]" value="<?php echo $tld_data['purchase_link']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <a class="ocwdctbl_addrow">
                                                                            <img src= " <?php echo OCWDC_PLUGIN_DIR . '/includes/images/plus.png' ?>">
                                                                        </a>
                                                                        <a class="ocwdctbl_deleterow" <?php if($tlds_counter == 0) {echo 'style="display: none;"'; } ?>>
                                                                            <img src= " <?php echo OCWDC_PLUGIN_DIR . '/includes/images/delete.png' ?>">
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $tlds_counter++;
                                                            }

                                                        } else {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="ocwdctbl_tld[]" value="">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="ocwdctbl_price[]" value="">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="ocwdctbl_link[]" value="">
                                                            </td>
                                                            <td>
                                                                <a class="ocwdctbl_addrow">
                                                                    <img src= " <?php echo OCWDC_PLUGIN_DIR . '/includes/images/plus.png' ?>">
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <span class="description">Leave empty <strong>Price</strong> and <strong>Buy Domain Link</strong> fields to use default values from Buy Domain Settings</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Check All</th>
                                            <td>
                                                <?php $ocwdc_check_all_tlds = get_option('ocwdc_check_all_tlds', 'disable'); ?>
                                                <input type="checkbox" name="ocwdc_check_all_tlds" value="enable" <?php if( $ocwdc_check_all_tlds == 'enable' ) { echo 'checked'; } ?>>
                                                <label>Enable checking all allowed TLDs simultaneously.</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>All Label</th>
                                            <td>
                                                <?php $ocwdc_check_all_opt_label = get_option('ocwdc_check_all_opt_label', 'all'); ?>
                                                <input type="text" class="regular-text" name="ocwdc_check_all_opt_label" value="<?php echo $ocwdc_check_all_opt_label; ?>">
                                                <label>Lable for option 'all' in select dropdown when Drop Down List is used.</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="ocwdc-tab-other" class="ocwdc-tab-content">
                            <div class="ocwdc_cover_div">
                                <div class="ocwdc_grp_div">
                                    <h3>Search Block Settings</h3>
                                    <table class="ocwdc_data_table">
                                        <tr>
                                            <th>Width</th>
                                            <td>
                                                <input type="number" name="ocwdc_dchecker_width" class="regular-text" value="<?php echo get_option( 'ocwdc_dchecker_width', '600' ); ?>">
                                                <select class="regular-text" name="ocwdc_dchecker_width_type" class="ocwdc_dchecker_sel">
                                                    <option value="px">Pixel</option>
                                                    <option value="%">Percent</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Label</th>
                                            <td>
                                                <input type="text" class="regular-text" name="ocwdc_label" value="<?php echo get_option( 'ocwdc_label', 'Web Domain Checker' ); ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Search Input Placeholder</th>
                                            <td>
                                                <input type="text" class="regular-text" name="ocwdc_placeholder" value="<?php echo get_option( 'ocwdc_placeholder', 'Search' ); ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Search Box Padding</th>
                                            <td>
                                                <input type="text" class="regular-text" name="ocwdc_search_padding" value="<?php echo get_option( 'ocwdc_search_padding', '8px 15px' ); ?>">
                                                <span>enter value in px (ex. 8px 15px)</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Search Button Text</th>
                                            <td>
                                                <input type="text" class="regular-text" name="ocwdc_head_title" value="<?php echo get_option( 'ocwdc_head_title', 'Search' ); ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Search Button Font Size</th>
                                            <td>
                                                <input type="number" class="regular-text" name="ocwdc_font_size" value="<?php echo get_option( 'ocwdc_font_size', '16' ); ?>">
                                                <span>fontsize is in px, just enter number (ex. 16)</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Search Button Font Color</th>
                                            <td>
                                                <?php $ocwdc_font_clr = get_option( 'ocwdc_font_clr', '#ffffff' ); ?>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocwdc_font_clr; ?>" name="ocwdc_font_clr" value="<?php echo $ocwdc_font_clr; ?>"/>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                            <th>Search Button Background Color</th>
                                            <td>
                                                <?php $ocwdc_btn_bg_clr = get_option( 'ocwdc_btn_bg_clr', '#000000' ); ?>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocwdc_btn_bg_clr; ?>" name="ocwdc_btn_bg_clr" value="<?php echo $ocwdc_btn_bg_clr; ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Search Button Button Padding</th>
                                            <td>
                                                <input type="text" name="ocwdc_btn_padding" class="regular-text" value="<?php echo get_option( 'ocwdc_btn_padding', '8px 10px' ); ?>">
                                                <span>enter value in px (ex. 8px 10px)</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <h3>Domain Search Result Settings</h3>
                                    <table class="ocwdc_data_table pro">
                                        <tr>
                                            <th>Font Size</th>
                                            <td>
                                                <input type="number" class="regular-text" name="ocwdc_srchreset_font_size" value="18" disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                                <span>fontsize is in px, just enter number (ex. 18)</span>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_subhead">
                                            <td colspan="2">
                                                <h3>Domain Empty Response</h3>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                          <th>Domain empty Text</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_domain_empty_text" value="Please enter domain name." disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_subhead">
                                        	<td colspan="2">
                                        		<h3>Domain Availibity Response</h3>
                                        	</td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                          <th>Domain is Available Text</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_domain_avai_text" value="Congratulations! {domain} is available!" disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                                <span class="description">Use tag <strong>{domain}</strong> to show domain and if you had enabled price in <em>Buy Domain Settings</em> then you can use <strong>{price}</strong> to show price in message. ( ex. 'Congratulations! {domain} is available for {price}' )</span>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Background Color</th>
                                            <td>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="#87b74f" name="ocwdc_domain_avai_bg_color" value="#87b74f" disabled=""/>
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Color</th>
                                            <td>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="#ffffff" name="ocwdc_domain_avai_color" value="#ffffff" disabled=""/>
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_subhead">
                                        	<td colspan="2">
                                        		<h3>Domain Already Taken Response</h3>
                                        	</td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                          <th>Domain Already Taken Text</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_domain_taken_text" value="Sorry! {domain} is already taken!" disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                                <span class="description">Use tag <strong>{domain}</strong> to show domain in message.</span>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Background Color</th>
                                            <td>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="#8a0e0e" name="ocwdc_domain_taken_bg_color" value="#8a0e0e" disabled=""/>
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Color</th>
                                            <td>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="#ffffff" name="ocwdc_domain_taken_color" value="#ffffff" disabled=""/>
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_subhead">
                                        	<td colspan="2">
                                        		<h3>Domain Extension not Supported Response</h3>
                                        	</td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                          <th>Domain Extension not Supported Text</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_domain_ext_notsup_text" value="{tld} is not supported." disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                                <span class="description">Use tag <strong>{tld}</strong> to show domain extension in message.</span>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Background Color</th>
                                            <td>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="#8a0e0e" name="ocwdc_domain_ext_notsup_bg_color" value="#8a0e0e" disabled=""/>
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Color</th>
                                            <td>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="#ffffff" name="ocwdc_domain_ext_notsup_color" value="#ffffff" disabled=""/>
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_subhead">
                                            <td colspan="2">
                                                <h3>Domain Extension Required Response</h3>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                          <th>Domain Extension not Supported Text</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_domain_ext_req_text" value="Please enter a domain extension." disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Background Color</th>
                                            <td>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="#8a0e0e" name="ocwdc_domain_ext_req_bg_color" value="#8a0e0e" disabled=""/>
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Color</th>
                                            <td>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="#ffffff" name="ocwdc_domain_ext_req_color" value="#ffffff" disabled=""/>
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                    </table>
                                    <h3>Whois Button Settings</h3>
                                    <table class="ocwdc_data_table">
                                        <tr>
                                            <th>Enable Whois Button</th>
                                            <td>
                                                <?php $ocwdc_whoisbtn_enable = get_option('ocwdc_whoisbtn_enable', 'enable'); ?>
                                                <input type="checkbox" name="ocwdc_whoisbtn_enable" value="enable" <?php if( $ocwdc_whoisbtn_enable == 'enable' ) { echo 'checked'; } ?>>
                                                <label>Enable whois button on domain search results.</label>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Whois Button Text</th>
                                            <td>
                                                <input type="text" class="regular-text" name="ocwdc_whoisbtn_text" value="<?php echo get_option( 'ocwdc_whoisbtn_text', 'Whois' ); ?>">
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                          <th>Whois Button Background Color</th>
                                            <td>
                                                <?php $ocwdc_whoisbtn_bg_color = get_option( 'ocwdc_whoisbtn_bg_color', '#ffffff' ); ?>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocwdc_whoisbtn_bg_color; ?>" name="ocwdc_whoisbtn_bg_color" value="<?php echo $ocwdc_whoisbtn_bg_color; ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                          <th>Whois Button Text Color</th>
                                            <td>
                                                <?php $ocwdc_whoisbtn_color = get_option( 'ocwdc_whoisbtn_color', '#8a0e0e' ); ?>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocwdc_whoisbtn_color; ?>" name="ocwdc_whoisbtn_color" value="<?php echo $ocwdc_whoisbtn_color; ?>"/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="ocwdc-tab-buy-domain" class="ocwdc-tab-content">
                            <div class="ocwdc_cover_div">
                                <div class="ocwdc_grp_div">
                                    <h3>Default Price and Text Settings</h3>
                                    <table class="ocwdc_data_table">
                                        <tr>
                                            <th>Enable Price</th>
                                            <td>
                                                <?php $ocwdc_domain_price_enable = get_option('ocwdc_domain_price_enable', 'disable'); ?>
                                                <input type="checkbox" name="ocwdc_domain_price_enable" value="enable" <?php if( $ocwdc_domain_price_enable == 'enable' ) { echo 'checked'; } ?>>
                                                <label>Enable price on domain search results.</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Default Price</th>
                                            <td>
                                                <input type="text" class="regular-text" name="ocwdc_domain_price_default" value="<?php echo get_option( 'ocwdc_domain_price_default', '10$' ); ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Enable Buy Domain Button</th>
                                            <td>
                                                <?php $ocwdc_atcbtn_enable = get_option('ocwdc_atcbtn_enable', 'disable'); ?>
                                                <input type="checkbox" name="ocwdc_atcbtn_enable" value="enable" <?php if( $ocwdc_atcbtn_enable == 'enable' ) { echo 'checked'; } ?>>
                                                <label>Enable buy domain button on domain search results.</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Buy Domain Button Text</th>
                                            <td>
                                                <input type="text" class="regular-text" name="ocwdc_atcbtn_text" value="<?php echo get_option( 'ocwdc_atcbtn_text', 'Buy Now' ); ?>">
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                            <th>Default Buy Domain Button Link</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_atcbtn_link_default" value="<?php echo get_option( 'ocwdc_atcbtn_link_default', '{domain}' ); ?>">
                                                <span class="description">Use tag <strong>{domain}</strong> to use domain name in url.</span>
                                            </td>
                                        </tr>
                                        <tr class="ocwdc_dmnavltxt">
                                            <th>Buy Now Button Background Color</th>
                                            <td>
                                                <?php $ocwdc_atcbtn_bg_color = get_option( 'ocwdc_atcbtn_bg_color', '#ffffff' ); ?>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocwdc_atcbtn_bg_color; ?>" name="ocwdc_atcbtn_bg_color" value="<?php echo $ocwdc_atcbtn_bg_color; ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Buy Now Button Text Color</th>
                                            <td>
                                                <?php $ocwdc_atcbtn_color = get_option( 'ocwdc_atcbtn_color', '#87b74f' ); ?>
                                                <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocwdc_atcbtn_color; ?>" name="ocwdc_atcbtn_color" value="<?php echo $ocwdc_atcbtn_color; ?>"/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="ocwdc-tab-captcha" class="ocwdc-tab-content">
                            <div class="ocwdc_cover_div">
                                <div class="ocwdc_grp_div">
                                    <h3>reCAPTCHA v2 Settings</h3>
                                    <table class="ocwdc_data_table ocwdc_recaptcha_table">
                                        <tr>
                                            <th>Enable Google reCAPTCHA v2</th>
                                            <td>
                                                <input type="checkbox" name="ocwdc_google_captcha_enable" value="enable" disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Google reCAPTCHA v2 Site Key</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_google_rcpcha_site_key" value="" disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                                <span class="description"><strong>Note: </strong>Please only use Google reCAPTCHA v2, you can create site key and secret key for your website from here <a href="https://www.google.com/recaptcha/admin/create" target="_blank">https://www.google.com/recaptcha/admin/create</a></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Google reCAPTCHA v2 Secret Key</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_google_rcpcha_secret_key" value="" disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Please Verify Captcha Error Text</th>
                                            <td class="ocwdc_inputtxt">
                                                <input type="text" class="regular-text" name="ocwdc_verfy_rcpcha_text" value="Please Verify Captcha." disabled="">
                                                <label class="ocwdc_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/web-domain-checker-pro/" target="_blank">link</a></label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="ocwdc_save_option">
                        <input type="submit" value="Save Changes" name="submit" class="button-primary ocwdc_save_btn" id="wfc-btn-space">
                    </form>
                </div>
                <?php
            }


            function OCWDC_save_options() {
                if( current_user_can('administrator') ) { 
                    if(isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'ocwdc_save_option'){

                        if(!isset( $_POST['ocwdc_nonce_field'] ) || !wp_verify_nonce( $_POST['ocwdc_nonce_field'], 'ocwdc_nonce_action' ) ) {
                            print 'Sorry, your nonce did not verify.';
                            exit;
                            
                        } else {
                            
                            $ocwdc_allowed_tlds = array();

                            if(!empty($_REQUEST['ocwdctbl_tld'])) {
                                $tlds_names = $this->ocwdc_recursive_sanitize_text_field( $_REQUEST['ocwdctbl_tld'] );

                                foreach ($tlds_names as $key => $value) {

                                    if($value != '') {
                                        $ocwdc_allowed_tlds[$value]['price'] = sanitize_text_field($_REQUEST['ocwdctbl_price'][$key]);
                                        $ocwdc_allowed_tlds[$value]['purchase_link'] = sanitize_text_field($_REQUEST['ocwdctbl_link'][$key]);
                                    }

                                }
                            }

                            update_option('ocwdc_tldsel_type', sanitize_text_field( $_REQUEST['ocwdc_tldsel_type'] ), 'yes');
                            update_option('ocwdc_allowed_tlds', $ocwdc_allowed_tlds, 'yes');

                            if(isset($_REQUEST['ocwdc_check_all_tlds']) && $_REQUEST['ocwdc_check_all_tlds'] == 'enable') {
                                $ocwdc_check_all_tlds = sanitize_text_field($_REQUEST['ocwdc_check_all_tlds']); 
                            } else {
                                $ocwdc_check_all_tlds = 'disable';
                            }

                            update_option('ocwdc_check_all_tlds', $ocwdc_check_all_tlds, 'yes');
                            update_option('ocwdc_check_all_opt_label', sanitize_text_field( $_REQUEST['ocwdc_check_all_opt_label'] ), 'yes');
                            update_option('ocwdc_dchecker_width', sanitize_text_field( $_REQUEST['ocwdc_dchecker_width'] ), 'yes');
                            update_option('ocwdc_dchecker_width_type', sanitize_text_field( $_REQUEST['ocwdc_dchecker_width_type'] ), 'yes');
                            update_option('ocwdc_head_title', sanitize_text_field( $_REQUEST['ocwdc_head_title'] ), 'yes');
                            update_option('ocwdc_font_clr',  sanitize_text_field( $_REQUEST['ocwdc_font_clr'] ), 'yes');
                            update_option('ocwdc_font_size', sanitize_text_field( $_REQUEST['ocwdc_font_size'] ), 'yes');
                            update_option('ocwdc_btn_bg_clr',sanitize_text_field( $_REQUEST['ocwdc_btn_bg_clr'] ), 'yes');
                            update_option('ocwdc_btn_padding',sanitize_text_field( $_REQUEST['ocwdc_btn_padding']),'yes');
                            update_option('ocwdc_search_padding',sanitize_text_field( $_REQUEST['ocwdc_search_padding']),'yes');
                            update_option('ocwdc_placeholder',sanitize_text_field( $_REQUEST['ocwdc_placeholder']),'yes');
                            update_option('ocwdc_label',sanitize_text_field( $_REQUEST['ocwdc_label']),'yes');
                            
                            if(isset($_REQUEST['ocwdc_whoisbtn_enable']) && $_REQUEST['ocwdc_whoisbtn_enable'] == 'enable') {
                                $ocwdc_whoisbtn_enable = sanitize_text_field($_REQUEST['ocwdc_whoisbtn_enable']); 
                            } else {
                                $ocwdc_whoisbtn_enable = 'disable';
                            }

                            update_option('ocwdc_whoisbtn_enable', $ocwdc_whoisbtn_enable, 'yes');
                            update_option('ocwdc_whoisbtn_text', sanitize_text_field( $_REQUEST['ocwdc_whoisbtn_text'] ), 'yes');
                            update_option('ocwdc_whoisbtn_bg_color',sanitize_text_field( $_REQUEST['ocwdc_whoisbtn_bg_color'] ), 'yes');
                            update_option('ocwdc_whoisbtn_color',sanitize_text_field( $_REQUEST['ocwdc_whoisbtn_color'] ), 'yes'); 

                            if(isset($_REQUEST['ocwdc_atcbtn_enable']) && $_REQUEST['ocwdc_atcbtn_enable'] == 'enable') {
                                $ocwdc_atcbtn_enable = sanitize_text_field($_REQUEST['ocwdc_atcbtn_enable']); 
                            } else {
                                $ocwdc_atcbtn_enable = 'disable';
                            }

                            update_option('ocwdc_atcbtn_enable', $ocwdc_atcbtn_enable, 'yes');
                            update_option('ocwdc_atcbtn_text', sanitize_text_field( $_REQUEST['ocwdc_atcbtn_text'] ), 'yes');
                            update_option('ocwdc_atcbtn_link_default', sanitize_text_field( $_REQUEST['ocwdc_atcbtn_link_default'] ), 'yes');
                            update_option('ocwdc_atcbtn_bg_color',sanitize_text_field( $_REQUEST['ocwdc_atcbtn_bg_color'] ), 'yes');
                            update_option('ocwdc_atcbtn_color',sanitize_text_field( $_REQUEST['ocwdc_atcbtn_color'] ), 'yes');
 
                            if(isset($_REQUEST['ocwdc_domain_price_enable']) && $_REQUEST['ocwdc_domain_price_enable'] == 'enable') {
                                $ocwdc_domain_price_enable = sanitize_text_field($_REQUEST['ocwdc_domain_price_enable']); 
                            } else {
                                $ocwdc_domain_price_enable = 'disable';
                            }

                            update_option('ocwdc_domain_price_enable', $ocwdc_domain_price_enable, 'yes');
                            update_option('ocwdc_domain_price_default', sanitize_text_field( $_REQUEST['ocwdc_domain_price_default'] ), 'yes');



                            $ocwdc_red = admin_url().'admin.php?page=ocwdc-domain-checker&message=success';
                            wp_redirect($ocwdc_red);
                            exit;
                        }
                    }
                }
            }


            function ocwdc_recursive_sanitize_text_field($array) {
         
                foreach ( $array as $key => &$value ) {
                    if ( is_array( $value ) ) {
                        $value = $this->ocwdc_recursive_sanitize_text_field($value);
                    } else {
                        $value = sanitize_text_field( $value );
                    }
                }
                return $array;
            }


            function ocwdc_admin_footer_func() {
            ?>
                <script type="text/javascript">

                    var imgDir = '<?php echo OCWDC_PLUGIN_DIR . '/includes/images/' ?>';

                    var rowHTML = '<tr><td><input type="text" name="ocwdctbl_tld[]" value=""></td><td><input type="text" name="ocwdctbl_price[]" value=""></td><td><input type="text" name="ocwdctbl_link[]" value=""></td><td><a class="ocwdctbl_addrow"><img src=" '+ imgDir + 'plus.png"></a><a class="ocwdctbl_deleterow"><img src="' + imgDir + 'delete.png"></a></td></tr>';

                    jQuery('body').on('click', '.ocwdctbl_addrow', function(e) {
                        e.preventDefault();
                        jQuery(rowHTML).insertAfter(jQuery(this).closest('tr'));
                    });

                    jQuery('body').on('click', '.ocwdctbl_deleterow', function(e) {
                        jQuery(this).closest('tr').remove();
                    });
                </script>
            <?php
            }


            function init() {
                add_action('admin_menu', array($this,'ocwdc_custom_menu_page'));
                add_action( 'init',  array($this, 'OCWDC_save_options'));
                add_action('admin_footer', array($this,'ocwdc_admin_footer_func'));
            }


            public static function OCWDC_instance() {
                if (!isset(self::$OCWDC_instance)) {
                    self::$OCWDC_instance = new self();
                    self::$OCWDC_instance->init();
                }
                return self::$OCWDC_instance;
            }
        }

        OCWDC_admin_menu::OCWDC_instance();
    }