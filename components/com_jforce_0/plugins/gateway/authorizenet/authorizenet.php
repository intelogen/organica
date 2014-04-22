<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			authorizenet.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class GatewayAuthorizenet {
	
	function generateForm($params, $invoice) {
		
		$html = '<form action="index.php" method="post">';
		$html .= '<table width="100%" cellpadding="4">';
		
		if ($params->get('name')) :
			$html .= '<tr>';
			$html .= '<td>'.JText::_('First Name').'</td>';
			$html .= '<td><input type="text" name="first_name" class="inputbox" size="35"></td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>'.JText::_('Last Name').'</td>';
			$html .= '<td><input type="text" name="last_name" class="inputbox" size="35"></td>';
			$html .= '</tr>';
		endif;
		if ($params->get('address')) :
			$html .= '<tr>';
			$html .= '<td>'.JText::_('Address').'</td>';
			$html .= '<td><input type="text" name="address" class="inputbox" size="35"></td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>'.JText::_('City').'</td>';
			$html .= '<td><input type="text" name="city" class="inputbox" size="35"></td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>'.JText::_('State').'</td>';
			$html .= '<td><input type="text" name="state" class="inputbox" size="35"></td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>'.JText::_('Zip').'</td>';
			$html .= '<td><input type="text" name="zip" class="inputbox" size="35"></td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>'.JText::_('Country').'</td>';
			$html .= '<td><input type="text" name="country" class="inputbox" size="35"></td>';
			$html .= '</tr>';
		endif;
		if ($params->get('email')) :
			$html .= '<tr>';
			$html .= '<td>'.JText::_('Email').'</td>';
			$html .= '<td><input type="text" name="email" class="inputbox" size="35"></td>';
			$html .= '</tr>';
		endif;
		if ($params->get('phone')) :
			$html .= '<tr>';
			$html .= '<td>'.JText::_('Phone').'</td>';
			$html .= '<td><input type="text" name="phone" class="inputbox" size="35"></td>';
			$html .= '</tr>';
		endif;
		$html .= '<tr>';
		$html .= '<td>'.JText::_('Card Number').'</td>';
		$html .= '<td><input type="text" name="card_num" class="inputbox" size="35"></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>'.JText::_('CID').'</td>';
		$html .= '<td><input type="text" name="card_code" class="inputbox" size="35"></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>'.JText::_('Expiration Date').'</td>';
		$html .= '<td><input type="text" name="exp_date" class="inputbox" size="35"></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td colspan="2" align="center"><input type="submit" name="submit" class="button" value="'.JText::_('Submit Payment').'"></td>';
		$html .= '</tr>';
		
		$html .= '</table>';
		$html .= '<input type="hidden" name="option" value="com_jforce">';
		$html .= '<input type="hidden" name="task" value="processPayment">';
		$html .= '<input type="hidden" name="c" value="accounting">';
		$html .= '<input type="hidden" name="id" value="'.$invoice->id.'">';
		$html .= '</form>';
		
		
		return $html;
	}
	
	
	function processPayment($params, $post) {
		
		require_once(JPATH_COMPONENT.DS.'lib'.DS.'gateways'.DS.'authorizenet'.DS.'includes'.DS.'authorizenet.class.php');

		$a = new authorizenet_class;
		 
		$a->add_field('x_login', $params->get('api_login'));
		$a->add_field('x_tran_key', $params->get('transaction_key'));
		//$a->add_field('x_password', 'CHANGE THIS TO YOUR PASSWORD');
		
		$a->add_field('x_version', '3.1');
		$a->add_field('x_type', 'AUTH_CAPTURE');
		$a->add_field('x_test_request', $params->get('test_mode'));    // Set to false to go live
		$a->add_field('x_relay_response', 'FALSE');
		
		// You *MUST* specify '|' as the delim char due to the way I wrote the class.
		// I will change this in future versions should I have time.  But for now, just
		// make sure you include the following 3 lines of code when using this class.
		
		$a->add_field('x_delim_data', 'TRUE');
		$a->add_field('x_delim_char', '|');     
		$a->add_field('x_encap_char', '');
		
		
		// Setup fields for customer information.  This would typically come from an
		// array of POST values froma secure HTTPS form.
		
		$a->add_field('x_first_name', $post['first_name']);
		$a->add_field('x_last_name', $post['last_name']);
		$a->add_field('x_address', $post['address']);
		$a->add_field('x_city', $post['city']);
		$a->add_field('x_state', $post['state']);
		$a->add_field('x_zip', $post['zip']);
		$a->add_field('x_country', $post['country']);
		$a->add_field('x_email', $post['email']);
		$a->add_field('x_phone', $post['phone']);
		
		
		// Using credit card number '4007000000027' performs a successful test.  This
		// allows you to test the behavior of your script should the transaction be
		// successful.  If you want to test various failures, use '4222222222222' as
		// the credit card number and set the x_amount field to the value of the 
		// Response Reason Code you want to test.  
		// 
		// For example, if you are checking for an invalid expiration date on the
		// card, you would have a condition such as:
		// if ($a->response['Response Reason Code'] == 7) ... (do something)
		//
		// Now, in order to cause the gateway to induce that error, you would have to
		// set x_card_num = '4222222222222' and x_amount = '7.00'
		
		//  Setup fields for payment information
		$a->add_field('x_method', 'CC');
		#$a->add_field('x_card_num', $post['card_num']);
		$a->add_field('x_card_num', '4007000000027');   // test successful visa
		//$a->add_field('x_card_num', '370000000000002');   // test successful american express
		//$a->add_field('x_card_num', '6011000000000012');  // test successful discover
		//$a->add_field('x_card_num', '5424000000000015');  // test successful mastercard
		// $a->add_field('x_card_num', '4222222222222');    // test failure card number
		$a->add_field('x_amount', $invoice->total);
		$a->add_field('x_exp_date', $post['exp_date']);    // march of 2008
		$a->add_field('x_card_code', $post['card_code']);    // Card CAVV Security code
		
		
		// Process the payment and output the results
		switch ($a->process()) {
		
		   case 1:  // Successs
		   	  $msg = JText::_('Payment Successful');
			  $success = true;
			  break;
			  
		   case 2:  // Declined
			  $msg = $a->get_response_reason_text();
			  $success = false;
			  break;
			  
		   case 3:  // Error
			  $msg = $a->get_response_reason_text();
			  $success = false;
			  break;
		}
		
		return array($response, $msg);
		
		// The following two functions are for debugging and learning the behavior
		// of authorize.net's response codes.  They output nice tables containing
		// the data passed to and recieved from the gateway.
		
		#$a->dump_fields();      // outputs all the fields that we set
		#$a->dump_response();    // outputs the response from the payment gateway
		
	}
	
	
}