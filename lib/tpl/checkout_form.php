<div id="paymill_payment_form">
	<script type="text/javascript">
		var PAYMILL_PUBLIC_KEY = '<?php echo $GLOBALS['paymill_settings']->paymill_general_settings['api_key_public']; ?>';
	</script>
	<?php
		$count_all_payment_types	= 0;
		$count_bank_payment_types	= 0;
		if(isset($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']) && is_array($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']) && count($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']) > 0){
			if($no_logos != true){ echo '<div class="paymill_payment_logos">'; }
			foreach($GLOBALS['paymill_settings']->paymill_general_settings['payments_display'] as $name => $type){
				if($type==1){
					if($no_logos != true){ echo '<img src="'.plugins_url('',__FILE__ ).'/../img/logos/'.$name.'.png" style="vertical-align:middle;" alt="'.$name.'" />'; }
					if($name == 'elv' || $name == 'sepa' || $name == 'paypal'){
						$count_bank_payment_types++;
					}
				}
				$count_all_payment_types++;
			}
			if($no_logos != true){ echo '</div>'; }
		}
		// count buttons
		// credit card
		$buttons = 0;
		if($count_all_payment_types > $count_bank_payment_types){
			$buttons++;
		}
		if(isset($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['sepa']) && $GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['sepa'] == 1){
			$buttons++;
		}
		if(isset($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['elv']) && $GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['elv'] == 1){
			$buttons++;
		}
		if(isset($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['paypal']) && $GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['paypal'] == 1){
			$buttons++;
		}
		
		if($buttons > 1){
			$visibility = '';
		}else{
			$visibility = ' style="display:none;"';
		}
		// credit card
		if($count_all_payment_types > $count_bank_payment_types){
			$show_cc = true;
			echo '<div id="paymill_form_switch_credit" class="paymill_form_switch paymill_form_switch_active"'.$visibility.'>'.__('Credit Card', 'paymill').'</div>';
		}
		// SEPA
		if(isset($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['sepa']) && $GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['sepa'] == 1){
			if(!isset($show_cc)){
				$show_sepa = true;
			}
			echo '<div id="paymill_form_switch_sepa" class="paymill_form_switch paymill_form_switch'.(isset($show_sepa) ? '_active' : '').'"'.$visibility.'>'.__('SEPA', 'paymill').'</div>';
		}
		// ELV
		if(isset($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['elv']) && $GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['elv'] == 1){
			if(!isset($show_cc) && !isset($show_sepa)){
				$show_elv = true;
			}
			echo '<div id="paymill_form_switch_elv" class="paymill_form_switch paymill_form_switch'.(isset($show_elv) ? '_active' : '').'"'.$visibility.'>'.__('ELV', 'paymill').'</div>';
		}
		// PayPal
		if(isset($GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['paypal']) && $GLOBALS['paymill_settings']->paymill_general_settings['payments_display']['paypal'] == 1){
			if(!isset($show_cc) && !isset($show_sepa) && !isset($show_elv)){
				$show_paypal = true;
			}
			echo '<div id="paymill_form_switch_paypal" class="paymill_form_switch paymill_form_switch'.(isset($show_paypal) ? '_active' : '').'"'.$visibility.'>'.__('PayPal', 'paymill').'</div>';
		}
	if(empty($GLOBALS['paymill_settings']->paymill_general_settings['pci_dss_3']) || $GLOBALS['paymill_settings']->paymill_general_settings['pci_dss_3'] != '1'){
?>
	<div id="paymill_form_credit"<?php if(!isset($show_cc)){ echo ' style="display:none;"'; } ?>></div>
<?php
	}else{
?>
	<div id="paymill_form_credit"<?php if(!isset($show_cc)){ echo ' style="display:none;"'; } ?>>
		<div class="paymill_holdername"><input id="paymill_holdername_c" type="text" size="20" value="" autocomplete="off" placeholder="<?php echo __('Holder Name', 'paymill'); ?>" /></div>
		<div class="paymill_card_number"><input id="paymill_card_number" type="text" size="20" value="" autocomplete="off" placeholder="<?php echo __('Card Number', 'paymill'); ?>" /></div>
		<div class="paymill_card_data">
			<div class="paymill_expire_date"><?php echo __('Expiry Date: ', 'paymill'); ?></div>
			<div class="paymill_card_expiry_month"><input class="paymill_card_expiry_month" id="paymill_card_expiry_month" type="text" size="2" value="" autocomplete="off" placeholder="<?php echo __('MM', 'paymill'); ?>" /></div>
			<div class="paymill_card_expiry_year"><input class="paymill_card_expiry_year" id="paymill_card_expiry_year" type="text" size="4" value="" autocomplete="off" placeholder="<?php echo __('YYYY', 'paymill'); ?>" /></div>
			<div class="paymill_card_cvc"><input class="paymill_card_cvc" id="paymill_card_cvc" type="text" size="4" value="" autocomplete="off" placeholder="<?php echo __('CVC', 'paymill'); ?>" /> <div class="cvc_desc"><?php echo __('(Security code)', 'paymill'); ?></div></div>
		</div>
	</div>
<?php
	}
?>
	<div id="paymill_form_sepa"<?php if(!isset($show_sepa)){ echo ' style="display:none;"'; } ?>>	
		<div class="paymill_holdername"><input id="paymill_holdername_s" type="text" size="20" value="" autocomplete="off" placeholder="<?php echo __('Account Holder', 'paymill'); ?>" /></div>
		<div class="paymill_sepa_iban"><input id="paymill_sepa_iban" type="text" value="" autocomplete="off"  maxlength="31" placeholder="<?php echo __('IBAN', 'paymill'); ?>"></div>
		<div class="paymill_sepa_bic"><input id="paymill_sepa_bic" type="text" value="" autocomplete="off"  maxlength="11" placeholder="<?php echo __('BIC', 'paymill'); ?>"></div>
	</div>
	<div id="paymill_form_elv"<?php if(!isset($show_elv)){ echo ' style="display:none;"'; } ?>>
		<div class="paymill_holdername"><input id="paymill_holdername_e" type="text" size="20" value="" autocomplete="off" placeholder="<?php echo __('Account Holder', 'paymill'); ?>" /></div>
		<div class="paymill_elv_number"><input id="paymill_elv_number" type="text" value="" autocomplete="off"  maxlength="31" placeholder="<?php echo __('Account Number', 'paymill'); ?>"></div>
		<div class="paymill_elv_bank"><input id="paymill_elv_bank_code" type="text" value="" autocomplete="off"  maxlength="11" placeholder="<?php echo __('Bank Code', 'paymill'); ?>"></div>
	</div>
	<div id="paymill_form_paypal"<?php if(!isset($show_paypal)){ echo ' style="display:none;"'; } ?>>
		<div class="paypal_description"><?php echo __('You will be redirected to PayPal to complete your order.', 'paymill'); ?></div>
	</div>
	<input class="paymill_amount" type="hidden" size="5" value="<?php if(isset($cart_total)){ echo $cart_total; } ?>"/>
	<input class="paymill_currency" type="hidden" size="3" value="<?php echo $currency; ?>"/>
	<div class="paymill_payment_errors" id="paymill_payment_errors"></div>
</div>