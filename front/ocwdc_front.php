<?php
if (!defined('ABSPATH'))
    exit;

    if (!class_exists('OCWDC_front_checker')) {

        class OCWDC_front_checker {

            protected static $OCWDC_instance;

            function ocwdc_domain_checker_func($domain, $domain_tld) {
            	
                $Domains = new ocwdc_domain_availability();
                $available = $Domains->is_available($domain, $domain_tld);

                $ocwdc_srchreset_font_size = '18px';

                $ocwdc_domain_avai_text = 'Congratulations! {domain} is available!';
                $ocwdc_domain_avai_bg_color = '#87b74f';
                $ocwdc_domain_avai_color = '#ffffff';

                $ocwdc_domain_taken_text = 'Sorry! {domain} is already taken!';
                $ocwdc_domain_taken_bg_color = '#8a0e0e';
                $ocwdc_domain_taken_color = '#ffffff';

                $ocwdc_domain_ext_notsup_text = '{tld} is not supported.';
                $ocwdc_domain_ext_notsup_bg_color = '#8a0e0e';
                $ocwdc_domain_ext_notsup_color = '#ffffff';

                $ocwdc_allowed_tlds_def = array(
                                            'com' => array('price' => '', 'purchase_link' => ''), 
                                            'net' => array('price' => '', 'purchase_link' => ''), 
                                            'org' => array('price' => '', 'purchase_link' => ''), 
                                            'info' => array('price' => '', 'purchase_link' => '')
                                        );

				$ocwdc_allowed_tlds = get_option( 'ocwdc_allowed_tlds', $ocwdc_allowed_tlds_def );

				$ocwdc_atcbtn_link_default = get_option( 'ocwdc_atcbtn_link_default', '{domain}' );
				$domain_price_default = get_option( 'ocwdc_domain_price_default', '10$' );

				if(!empty($ocwdc_allowed_tlds)) {
					if($ocwdc_allowed_tlds[$domain_tld]['purchase_link'] != '') {
						$ocwdc_atcbtn_link_default = $ocwdc_allowed_tlds[$domain_tld]['purchase_link'];
					}
					if($ocwdc_allowed_tlds[$domain_tld]['price'] != '') {
						$domain_price_default = $ocwdc_allowed_tlds[$domain_tld]['price'];
					}
				}

                $true_svg = '<span class="ocwdc_tficons"><svg height="'.$ocwdc_srchreset_font_size.'" viewBox="0 -46 417.81333 417" width="'.$ocwdc_srchreset_font_size.'" xmlns="http://www.w3.org/2000/svg"><path d="m159.988281 318.582031c-3.988281 4.011719-9.429687 6.25-15.082031 6.25s-11.09375-2.238281-15.082031-6.25l-120.449219-120.46875c-12.5-12.5-12.5-32.769531 0-45.246093l15.082031-15.085938c12.503907-12.5 32.75-12.5 45.25 0l75.199219 75.203125 203.199219-203.203125c12.503906-12.5 32.769531-12.5 45.25 0l15.082031 15.085938c12.5 12.5 12.5 32.765624 0 45.246093zm0 0"/></svg></span>';

                $false_svg = '<span class="ocwdc_tficons"><svg height="'.$ocwdc_srchreset_font_size.'" viewBox="0 0 365.696 365.696" width="'.$ocwdc_srchreset_font_size.'" xmlns="http://www.w3.org/2000/svg"><path d="m243.1875 182.859375 113.132812-113.132813c12.5-12.5 12.5-32.765624 0-45.246093l-15.082031-15.082031c-12.503906-12.503907-32.769531-12.503907-45.25 0l-113.128906 113.128906-113.132813-113.152344c-12.5-12.5-32.765624-12.5-45.246093 0l-15.105469 15.082031c-12.5 12.503907-12.5 32.769531 0 45.25l113.152344 113.152344-113.128906 113.128906c-12.503907 12.503907-12.503907 32.769531 0 45.25l15.082031 15.082031c12.5 12.5 32.765625 12.5 45.246093 0l113.132813-113.132812 113.128906 113.132812c12.503907 12.5 32.769531 12.5 45.25 0l15.082031-15.082031c12.5-12.503906 12.5-32.769531 0-45.25zm0 0"/></svg></span>';

                $full_domain = $domain.'.'.$domain_tld;
                $ocwdc_atcbtn_link_final = str_replace('{domain}', $full_domain, $ocwdc_atcbtn_link_default);

                $ocwdc_domain_avai_text_final = str_replace('{domain}', $full_domain, $ocwdc_domain_avai_text);

                $ocwdc_domain_price_enable = get_option('ocwdc_domain_price_enable', 'disable');

                if($ocwdc_domain_price_enable == 'enable') {
                    $ocwdc_domain_avai_text_final = str_replace('{price}', $domain_price_default, $ocwdc_domain_avai_text_final);
                }
                
                $custom_found_result_text = __($true_svg.'<p style="font-size:'.$ocwdc_srchreset_font_size.'; color: '.$ocwdc_domain_avai_color.';">'.$ocwdc_domain_avai_text_final.'</p>', 'ocwdc');

                $ocwdc_domain_taken_text_final = str_replace('{domain}', $full_domain, $ocwdc_domain_taken_text); 
                $custom_not_found_result_text = __($false_svg.'<p style="font-size:'.$ocwdc_srchreset_font_size.'; color: '.$ocwdc_domain_taken_color.';">'.$ocwdc_domain_taken_text_final.'</p>', 'ocwdc');

                $ocwdc_domain_ext_notsup_text_final = str_replace('{tld}', $domain_tld, $ocwdc_domain_ext_notsup_text);

                $ocwdc_atcbtn_enable = get_option('ocwdc_atcbtn_enable', 'disable');
                $ocwdc_atcbtn_text = get_option( 'ocwdc_atcbtn_text', 'Buy Now' );
                $ocwdc_atcbtn_bg_color = get_option( 'ocwdc_atcbtn_bg_color', '#ffffff' );
                $ocwdc_atcbtn_color = get_option( 'ocwdc_atcbtn_color', '#87b74f' );

                $atc_button = '';
                if( $ocwdc_atcbtn_enable ==  'enable') {
                    $atc_button = '<a  class="ocwdc_open_atc" style="font-size: '.$ocwdc_srchreset_font_size.'; background-color:'.$ocwdc_atcbtn_bg_color.';  color: '.$ocwdc_atcbtn_color.'" href="'.$ocwdc_atcbtn_link_final.'" target="_blank">'.$ocwdc_atcbtn_text.'</a>';
                }

                $available_html = '<div class="ocwdc-available ocwdc-avb" style="background-color: '.$ocwdc_domain_avai_bg_color.';">'.$custom_found_result_text.$atc_button.'</div>';

                $ocwdc_whoisbtn_enable = get_option('ocwdc_whoisbtn_enable', 'enable');
                $ocwdc_whoisbtn_text = get_option( 'ocwdc_whoisbtn_text', 'Whois' );
                $ocwdc_whoisbtn_bg_color = get_option( 'ocwdc_whoisbtn_bg_color', '#ffffff' );
                $ocwdc_whoisbtn_color = get_option( 'ocwdc_whoisbtn_color', '#8a0e0e' );

                $whois_button = '';
                if( $ocwdc_whoisbtn_enable ==  'enable') {
                    $whois_button = '<a  class="ocwdc_open_whois" style="font-size: '.$ocwdc_srchreset_font_size.'; background-color:'.$ocwdc_whoisbtn_bg_color.'; color: '.$ocwdc_whoisbtn_color.';" href="https://www.whois.com/whois/'.$domain.'.'.$domain_tld.'" target="_blank">'.$ocwdc_whoisbtn_text.'</a>';
                }

                $not_available_html = '<div class="ocwdc-not-available ocwdc-nta" style="background-color:'.$ocwdc_domain_taken_bg_color.';">'.$custom_not_found_result_text.$whois_button.'</div>';

                $not_supported_tld = '<div class="ocwdc-not-available ocwdc-nts" style="background-color:'.$ocwdc_domain_ext_notsup_bg_color.';"><p style="font-size:'.$ocwdc_srchreset_font_size.'; color: '.$ocwdc_domain_ext_notsup_color.';">'.$ocwdc_domain_ext_notsup_text_final.'</p></div>';

                $content = '';

                $style = '<style>';
                $style .= '.ocwdc-avb .ocwdc_tficons svg path { fill: '.$ocwdc_domain_avai_color.'; }';
                $style .= '.ocwdc-nta .ocwdc_tficons svg path { fill: '.$ocwdc_domain_taken_color.'; }';
                $style .= '.ocwdc-nts .ocwdc_tficons svg path { fill: '.$ocwdc_domain_ext_notsup_color.'; }';
                $style .= '</style>';

                if ($available == '1') {
                	$content = $available_html.$style;
                } elseif ($available == '0') {
                    $content = $not_available_html.$style;
                } elseif ($available == '2') {
                	$content = $not_supported_tld.$style;
                }

                return $content;
            }


            function ocwdc_display_func() {

                if(isset($_POST['domain'])) {
                    $domain_tld = sanitize_text_field($_REQUEST['domain_tld']);
                    $domain = sanitize_text_field($_REQUEST['domain']);

                    if($domain_tld == 'not_dropdown') {
                        $split = explode('.', $domain, 2);
                        $domain = $split[0];
                        $split_count = count($split);
                        
                        if($split_count > 1) {
                            $domain_tld = $split[1];
                        }

                    } else {
                        $domain_tld = $domain_tld;
                        $domain = $domain;
                        $split_count = 2;
                        if($domain_tld == 'ocwdc_all') {
                            $split_count = 1;
                        }
                    }

                    $ocwdc_tldsel_type = get_option( 'ocwdc_tldsel_type', 'dropdown' );
                    
                    $ocwdc_allowed_tlds_def = array(
	                                            'com' => array('price' => '', 'purchase_link' => ''), 
	                                            'net' => array('price' => '', 'purchase_link' => ''), 
	                                            'org' => array('price' => '', 'purchase_link' => ''), 
	                                            'info' => array('price' => '', 'purchase_link' => '')
	                                        );

					$ocwdc_allowed_tlds = get_option( 'ocwdc_allowed_tlds', $ocwdc_allowed_tlds_def );
					$ocwdc_allowed_tlds_keys = array_keys($ocwdc_allowed_tlds);

                    $ocwdc_check_all_tlds = get_option('ocwdc_check_all_tlds', 'disable');

                    $ocwdc_srchreset_font_size = '18px';

                    $ocwdc_domain_ext_notsup_bg_color = '#8a0e0e';
                    $ocwdc_domain_ext_notsup_color = '#ffffff';
                    $ocwdc_domain_ext_notsup_text = '{tld} is not supported.';
                    $ocwdc_domain_ext_notsup_text_final = str_replace('{tld}', $domain_tld, $ocwdc_domain_ext_notsup_text);

                    $ocwdc_domain_ext_req_text = 'Please enter a domain extension.';
                    $ocwdc_domain_ext_req_bg_color = '#8a0e0e';
                    $ocwdc_domain_ext_req_color = '#ffffff';

                    $content = '';


                    if($split_count == 1) {
                        if($ocwdc_check_all_tlds == 'enable') {
                            //echo 'check all tlds';

                            if(!empty($ocwdc_allowed_tlds)) {
                            	$content_data = '';

                            	foreach ($ocwdc_allowed_tlds as $tld_key => $tld_val) {
				                	$content_data .= $this->ocwdc_domain_checker_func($domain, $tld_key);
				                }

                            	$status = '1';
                            	$content = $content_data;


                            	$result = array('status' => '1', 'content' => $content);
                            	echo json_encode($result);
                            	exit;

                            } else {
                            	$status = '1';
                            	$content = '<div class="ocwdc-not-available" style="background-color: '.$ocwdc_domain_ext_req_bg_color.';"><p style="font-size: '.$ocwdc_srchreset_font_size.'; color: '.$ocwdc_domain_ext_req_color.';">'.$ocwdc_domain_ext_req_text.'</p></div>';
                            }


                        } else {
                            //$status = 'tld_required';
                            $status = '1';
                            $content = '<div class="ocwdc-not-available" style="background-color: '.$ocwdc_domain_ext_req_bg_color.';"><p style="font-size: '.$ocwdc_srchreset_font_size.'; color: '.$ocwdc_domain_ext_req_color.';">'.$ocwdc_domain_ext_req_text.'</p></div>';
                        }
                    } else {
                        if($ocwdc_tldsel_type == 'limited') {
                            if (in_array($domain_tld, $ocwdc_allowed_tlds_keys)) {
                                //echo 'allowed tld';
                                $status = '1';
                                $content = $this->ocwdc_domain_checker_func($domain, $domain_tld);
                            } else {
                                //$status = 'tld_not_allowed';
                                $status = '1';
                                $content = '<div class="ocwdc-not-available" style="background-color: '.$ocwdc_domain_ext_notsup_bg_color.';"><p style="font-size: '.$ocwdc_srchreset_font_size.'; color: '.$ocwdc_domain_ext_notsup_color.';">.'.$ocwdc_domain_ext_notsup_text_final.'</p></div>';
                            }
                        } else {
                       		//echo 'all tlds allowed';
                       		$status = '1';
                       		$content = $this->ocwdc_domain_checker_func($domain, $domain_tld);
                        }
                    }

                    $result = array('status' => $status, 'content' => $content);
                    echo json_encode($result);
                }
                exit;
            }


            function ocwdc_display_shortcode($atts) {
                $image = OCWDC_PLUGIN_DIR.'/includes/images/load.gif';
                $ocwdc_dchecker_width = get_option('ocwdc_dchecker_width', '600');
                $ocwdc_dchecker_width_type = get_option('ocwdc_dchecker_width_type', 'px');
                $ocwdc_label = get_option('ocwdc_label', 'Web Domain Checker');
                $ocwdc_placeholder = get_option('ocwdc_placeholder', 'Search');
                $ocwdc_search_padding = get_option( 'ocwdc_search_padding', '8px 15px');
                $ocwdc_head_title = get_option('ocwdc_head_title', 'Search');
                $ocwdc_font_clr = get_option('ocwdc_font_clr', '#ffffff');
                $ocwdc_btn_padding = get_option('ocwdc_btn_padding', '8px 10px');
                $ocwdc_font_size = get_option('ocwdc_font_size', '16');
                $ocwdc_btn_bg_clr = get_option('ocwdc_btn_bg_clr', '#000000');
                $ocwdc_tldsel_type = get_option( 'ocwdc_tldsel_type', 'dropdown' );
                
                $ocwdc_allowed_tlds_def = array(
                                            'com' => array('price' => '', 'purchase_link' => ''), 
                                            'net' => array('price' => '', 'purchase_link' => ''), 
                                            'org' => array('price' => '', 'purchase_link' => ''), 
                                            'info' => array('price' => '', 'purchase_link' => '')
                                        );

				$ocwdc_allowed_tlds = get_option( 'ocwdc_allowed_tlds', $ocwdc_allowed_tlds_def );
                $ocwdc_check_all_tlds = get_option('ocwdc_check_all_tlds', 'disable');
                $ocwdc_check_all_opt_label = get_option('ocwdc_check_all_opt_label', 'all');

                $ocwdc_dchecker_size = $ocwdc_dchecker_width.$ocwdc_dchecker_width_type;

                ob_start();
                ?>

                <div class="ocwdc-domain-main" style="width: <?php echo $ocwdc_dchecker_size; ?>"> 
                    <form method="post" id="ocwdc-domain-form">
                        <h2><?php echo $ocwdc_label; ?></h2>
                        <div class="ocwdc_search_div">
                            <input type="text" autocomplete="off" id="ocwdc-domain" class="ocwdc_srchinp" placeholder="<?php echo $ocwdc_placeholder; ?>" name="ocwdc-domain" style="padding:<?php echo $ocwdc_search_padding; ?>;">
                            <?php
                            if($ocwdc_tldsel_type == 'dropdown') {
                            	if(!empty($ocwdc_allowed_tlds)) {
                            		?>
                                    <span class="ocwdc_dot">.</span>
                            		<select name="ocwdc-domain-tld" id="ocwdc-domain-tld">
                            			<?php
                            			foreach ($ocwdc_allowed_tlds as $key => $value) {
                            				echo '<option value="'.$key.'">'.$key.'</option>';
                            			}

                                        if( $ocwdc_check_all_tlds == 'enable' ) {
                                            echo '<option disabled="">----</option>';
                                            echo '<option value="ocwdc_all">'.$ocwdc_check_all_opt_label.'</option>';
                                        }

                                        ?>
                            		</select>
                            		<?php
                            	}
                            }
                            ?>


                            <input type="submit" value="<?php echo $ocwdc_head_title; ?>" class="ocwdc_srchbtn" style=" color:<?php echo $ocwdc_font_clr; ?>; padding:<?php echo $ocwdc_btn_padding; ?>; font-size: <?php echo $ocwdc_font_size; ?>px; background-color:<?php echo $ocwdc_btn_bg_clr; ?>">
                        </div>

                        <div id="ocwdc-loading">
                            <img src="<?php echo $image; ?>">
                        </div>
                    </form>
                    <div id="ocwdc-results" class="ocwdc-result"></div>
                </div>

                <?php

                $content = ob_get_clean();
                return $content;
            }


            function init() {
                add_action('wp_ajax_ocwdc_display',array($this,'ocwdc_display_func'));
                add_action('wp_ajax_nopriv_ocwdc_display',array($this,'ocwdc_display_func'));
                add_shortcode('ocwdc-domain-checker', array($this,'ocwdc_display_shortcode'));
            }


            public static function OCWDC_instance() {
                if (!isset(self::$OCWDC_instance)) {
                    self::$OCWDC_instance = new self();
                    self::$OCWDC_instance->init();
                }
                return self::$OCWDC_instance;
            }
        }

        OCWDC_front_checker::OCWDC_instance();
    }