<?php
/*
  Copyright (c) 2004 SystemsManager.Net
  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately. 

    
    Licensed under GNU General Public License (GPL) v2.0
    Copyright (C) 2002 Stanford Ng

  ===================================================================*/

define( TABLE_SUREPAY_TRANSACTIONS, "surepay_transactions" );


/*
Class implementing the OS Commerce Payment Module interface.
*/
class surepay
{
    var $enabled, $login, $password, $test_mode;
    var $code, $title, $description;
    var $cc_number, $cc_cvv2, $cc_expires_month, $cc_expires_year;
    var $cc_card_type;
    

// class constructor
    function surepay()
    {
        global $_POST;
        $this->code = 'surepay';
        $this->title = MODULE_PAYMENT_SUREPAY_TEXT_TITLE;
        $this->description = MODULE_PAYMENT_SUREPAY_TEXT_DESCRIPTION;
        $this->enabled = MODULE_PAYMENT_SUREPAY_STATUS;
        $this->test_mode = MODULE_PAYMENT_SUREPAY_TESTMODE;
        $this->login = MODULE_PAYMENT_SUREPAY_LOGIN;
        $this->password = MODULE_PAYMENT_SUREPAY_PASSWORD;
        $this->cc_number = smn_db_prepare_input( $_POST['surepay_cc_number'] );
        $this->cc_cvv2 = smn_db_prepare_input( $_POST['surepay_cc_cvv2'] );
        $this->cc_expires_month = smn_db_prepare_input( $_POST['surepay_cc_expires_month'] );
        $this->cc_expires_year = smn_db_prepare_input( $_POST['surepay_cc_expires_year'] );
	    $this->single = ((MODULE_PAYMENT_SUREPAY_SINGLE_CHECKOUT == 'True') ? true : false);
    }

    
    /*
        Generates a javascript snippet that validates the credit card #. 
    */
    function javascript_validation()
    {
      $js = '  if (payment_value == "' . $this->code . '") {' . "\n" .
            '    var cc_number = document.checkout_payment.surepay_cc_number.value;' . "\n" .
            '    if (cc_number == "" || cc_number.length < ' . CC_NUMBER_MIN_LENGTH . ') {' . "\n" .
            '      error_message = error_message + "' . MODULE_PAYMENT_SUREPAY_TEXT_JS_CC_NUMBER . '";' . "\n" .
            '      error = 1;' . "\n" .
            '    }' . "\n" .
            '  }' . "\n";

      return $js;
    }

    
    
    function selection()
    {
        global $order;

        // -- Generates an array containing the text names of each month of the year.
        for( $i=1; $i < 13; $i++ )
        {
            $expires_month[] = array( 'id' => sprintf( '%02d', $i ), 'text' => strftime( '%B', mktime( 0, 0, 0, $i, 1, 2000 ) ) );
        }
        
        // -- Generates an array containing this year and the next nine years.        
        $today = getdate(); 
        for( $i = $today['year']; $i < $today['year'] + 10; $i++)
        {
            $expires_year[] = array( 'id' => strftime( '%y', mktime( 0, 0, 0, 1, 1, $i ) ), 'text' => strftime( '%Y', mktime( 0, 0, 0, 1, 1, $i ) ) );
        }

        $selection = array( 
            'id' => $this->code,
            'module' => $this->title,
            'fields' => array( 
                            array( 'title' => MODULE_PAYMENT_SUREPAY_TEXT_CREDIT_CARD_NUMBER,
                                    'field' => smn_draw_input_field( 'surepay_cc_number' ) ),
                            array( 'title' => MODULE_PAYMENT_SUREPAY_TEXT_CREDIT_CARD_CVV2,
                                    'field' => smn_draw_input_field( 'surepay_cc_cvv2' ) ),
                            array( 'title' => MODULE_PAYMENT_SUREPAY_TEXT_CREDIT_CARD_EXPIRES,
                                    'field' => smn_draw_pull_down_menu( 'surepay_cc_expires_month', $expires_month ) . '&nbsp;' . smn_draw_pull_down_menu( 'surepay_cc_expires_year', $expires_year ) )
                        )
        );
        return $selection;
    }


    /*
        Runs some simple checks to see if the information entered is potentially valid.
        The pre_process methods does the real validation via SurePay's service.
    */
    function pre_confirmation_check() {
      global $_POST;

      include(DIR_WS_CLASSES . 'cc_validation.php');

      $cc_validation = new cc_validation();
      $result = $cc_validation->validate($_POST['surepay_cc_number'], $_POST['surepay_cc_expires_month'], $_POST['surepay_cc_expires_year']);

      $error = '';
      switch ($result) {
        case -1:
          $error = sprintf(TEXT_CCVAL_ERROR_UNKNOWN_CARD, substr($cc_validation->cc_number, 0, 4));
          break;
        case -2:
        case -3:
        case -4:
          $error = TEXT_CCVAL_ERROR_INVALID_DATE;
          break;
        case false:
          $error = TEXT_CCVAL_ERROR_INVALID_NUMBER;
          break;
      }

      if ( ($result == false) || ($result < 1) ) {
        $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($error) . '&surepay_cc_expires_month=' . $_POST['surepay_cc_expires_month'] . '&surepay_cc_expires_year=' . $_POST['surepay_cc_expires_year'];
        smn_redirect(smn_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'NONSSL', true, false));
      }

      $this->cc_card_type = $cc_validation->cc_type;
      $this->cc_card_number = $cc_validation->cc_number;
    }

    
    /*
        Generates the snippet of HTML that is displayed for confirmation from the user that all the
        credit card info was entered correctly.
    */
    function confirmation()
    {
        global $CardName, $CardNumber, $checkout_form_action;
      global $_POST;

      $confirmation = array('title' => $this->title,
                            'fields' => array(array('title' => MODULE_PAYMENT_SUREPAY_TEXT_TYPE,
                                                    'field' => $this->cc_card_type ),
                                              array('title' => MODULE_PAYMENT_SUREPAY_TEXT_CREDIT_CARD_NUMBER,
                                                    'field' => substr($this->cc_card_number, 0, 4) . str_repeat('X', (strlen($this->cc_card_number) - 8)) . substr($this->cc_card_number, -4) ),
                                              array('title' => MODULE_PAYMENT_SUREPAY_TEXT_CREDIT_CARD_CVV2,
                                                    'field' => $this->cc_cvv2 ),
                                              array('title' => MODULE_PAYMENT_SUREPAY_TEXT_CREDIT_CARD_EXPIRES,
                                                    'field' => strftime('%B, %Y', mktime(0,0,0,$_POST['surepay_cc_expires_month'], 1, '20' . $_POST['surepay_cc_expires_year'])))));
      return $confirmation;
    }

    
    /*
        Used to pass the credit card info via hidden fields to the process page.   
    */
    function process_button()
    {
        global $_POST, $CardName, $CardNumber, $order;
        
        // TODO: enter real tax rate.
        $process_button_string = smn_draw_hidden_field( 'surepay_cc_number', $this->cc_number ) .
                                 smn_draw_hidden_field( 'surepay_cc_cvv2', $this->cc_cvv2 ) .
                                 smn_draw_hidden_field( 'surepay_cc_expires_month', $this->cc_expires_month ) .
                                 smn_draw_hidden_field( 'surepay_cc_expires_year', $this->cc_expires_year ) .
                                 smn_draw_hidden_field( 'surepay_fullname', $order->customer['firstname'] . ' ' . $order->customer['lastname'] ) .
                                 smn_draw_hidden_field( 'surepay_address', $order->customer['street_address'] ) .
                                 smn_draw_hidden_field( 'surepay_city', $order->customer['city'] ) .
                                 smn_draw_hidden_field( 'surepay_state', $order->customer['state'] ) .
                                 smn_draw_hidden_field( 'surepay_postcode', $order->customer['postcode'] ) .
                                 smn_draw_hidden_field( 'surepay_country',$order->customer['country']['title'] ) .
                                 smn_draw_hidden_field( 'surepay_phone', $order->customer['telephone'] ) .
                                 smn_draw_hidden_field( 'surepay_email', $order->customer['email_address'] ) .
                                 smn_draw_hidden_field( 'surepay_delivery_fullname', $order->delivery[ 'firstname' ] . ' ' . $order->delivery[ 'lastname' ] ) .
                                 smn_draw_hidden_field( 'surepay_delivery_address', $order->delivery['street_address'] ) .
                                 smn_draw_hidden_field( 'surepay_delivery_city', $order->delivery['city'] ) .
                                 smn_draw_hidden_field( 'surepay_delivery_state', $order->delivery['state'] ) .
                                 smn_draw_hidden_field( 'surepay_delivery_postcode', $order->delivery['postcode'] ) .
                                 smn_draw_hidden_field( 'surepay_delivery_country',$order->delivery['country']['title'] ) .
                                 smn_draw_hidden_field( 'surepay_tax_rate', '0.00' ) .
                                 smn_draw_hidden_field( 'surepay_shipping_cost', number_format( $order->info['shipping_cost'], 2 ) . 'USD' ) .
                                 smn_draw_hidden_field( 'surepay_tax', number_format( $order->info[ 'tax' ], 2 ) . 'USD' ) .
                                 smn_draw_hidden_field( 'surepay_total', number_format( $order->info[ 'total' ], 2 ) . 'USD' )
                                 ;
        
        return $process_button_string;
    }
    
    
    /*
        This is where most of the legwork is done.  SurePay is contacted via a NONSSL connection
        and the credit card authorization is performed.  If it fails, the user is redirected
        to an error page.
    */
    function before_process()
    {
        global $_POST, $language;
        require( DIR_WS_LANGUAGES . $language . "/modules/payment/surepay.php" );
        require( DIR_WS_CLASSES . "sausurepay.php" );
        
        #  Creditcard test AUTH:
        #     cc number: 4012000033330026   any future exp date
        #     $11 = AUTH     $21 = "REF"   $31 = "DCL"   any other may give "ERR"
        #     This test request uses total $1 shipping, and 1x$5 + 1x$5 goods, 
        #     total $11. Just change the item quantities to try the other status.
        #  I have also found some bugs and weakneses in Surepays processing, here is a 
        #  couple of them:
        #
        #   - Do not add % as character data, best off staying away from it totally.
        #     This can cause surepays servlets to crash and gives a 500 server error.
        #
        #   - Do not convert < > & ' " to the correct XML entities, surepays parser or
        #     data collector rejects any characterdata like &lt; and so on.
        #
        #   - Phone numbers in address are limited length (stay 11 digits or less), they
        #     claim to be "US domestic oriented" (?)
        #
        #   - What is the correct way to handle ref? Should the script handle and check
        #     avs and cvv2status responses to something automatically? If someone has 
        #     a guideline to this would be appreciated.. (sausurepay@sauen.com)
        
        ## Syntax: 
        ##  vobject_identifier: sausp ( 
        ##     boolean: live?
        ##    ,string: merchant id
        ##    ,string: password
        ##   [,array: extra pp.request parameters ] 
        ##  )
        
        
        // --- Create the SurePay request object. ---

        // --- This is where you can change some of the settings. ---        
        $amount = $_POST[ 'surepay_total' ];
        $shipping_cost = $_POST[ 'surepay_shipping_cost' ];
        if( $this->test_mode == true )
        {
            // --- Fill in the info for the fake auth requests. ---
            $shipping_cost = '0.00USD';
            $amount = '11.00USD';   // Use this amount if you want to test: card okay.
            $amount = '31.00USD';   // Use this amount if you want to test: card referred to voice center.
            $amount = '44.00USD';   // Use this amount if you want to test: card declined.
            
            // -- Random valid generator.
            if( rand() % 2 == 1 )
            {
                $amount = '11.00USD';
            }
        }

        // -- Figure out whether to use xml.test.surepay.com (test) or xml.surepay.com (live). 
        $live = !($this->test_mode);

        $ssp = new sausp( $live, $this->login, $this->password );
        if( $ssp->err )
        {
            die( $ssp->err );
        }
        
        // --- Generate SurePay order id. ---
        // --   Note that this is not the same as the order_id in OS Commerce, which does
        // --   not exist until after a payment is approved.
        
        smn_db_perform( TABLE_SUREPAY_TRANSACTIONS, array( message => '' ) );
        $order_number = smn_db_insert_id();
        
        // --- Add miscellanous auth request info. ---
        // --   ecommercecode specifies the level of encryption( default is 07 - NONSSL, ) 
        // --   05 - secure w/ cardholder & merchant cert,
        // --   06 - secure w/ merchant cert
        // --   07 - NONSSL
        // --   08 - no security
        
        $auth = $ssp->add_auth( 
        array(
            'ordernumber'     => $order_number,
            'ecommerce'       => 'true',
            'ecommercecode'   => '07',
            'ipaddress'       => $REMOTE_ADDR,
            'shippingcost'    => $shipping_cost,
            'shippingcost2'   => "0.00USD", 
            'taxamount'       => $_POST[ 'surepay_tax' ],
            'referringurl'    => $HTTP_REFERER,
            'browsertype'     => $HTTP_USER_AGENT
            )
        );
            
        if( $ssp->err )
        {
            die( $ssp->err );
        }

        
        // --- Add the shipping address using the order info. ---
        
        $ssp->add_shipping_address(
            $auth,
            array(
                'fullname' => $_POST[ 'surepay_delivery_fullname' ],
                'address1' => $_POST[ 'surepay_delivery_address' ],
                'address2' => '',
                'city'     => $_POST[ 'surepay_delivery_city' ],
                'state'    => $_POST[ 'surepay_delivery_state' ],
                'zip'      => $_POST[ 'surepay_delivery_postcode' ],
                'country'  => $_POST[ 'surepay_delivery_country' ],
                'phone'    => $_POST[ 'surepay_phone' ],
                'email'    => $_POST[ 'surepay_email' ]
            )
        );
        
        if( $ssp->err )
        {
            die( $ssp->err );
        }

        // --- Add the credit card info. ---
        ## Syntax:
        ##  object_identifier: add_creditcard (
        ##      object_identifier: parent object
        ##     ,string: card number
        ##     ,string: expiration (mm/yy)
        ##     ,int: cvv2 code from card
        ##    [,int: cvv2status (security mode) (0|1|9) default is 1 (In Use), 0 = off, 9 = no code available ]
        ##    [,array: billing address]
        ##  )

        $creditcard = $ssp->add_creditcard(
            $auth,
            $this->cc_number,
            $this->cc_expires_month . "/" . $this->cc_expires_year,
            $this->cc_cvv2
        );
        
        
        // --- Add the billing address for the order. ---
        
        $ssp->add_billing_address(
            $creditcard,
            array(
                'fullname' => $_POST[ 'surepay_fullname' ],
                'address1' => $_POST[ 'surepay_address' ],
                'address2' => '',
                'city'     => $_POST[ 'surepay_city' ],
                'state'    => $_POST[ 'surepay_state' ],
                'zip'      => $_POST[ 'surepay_postcode' ],
                'country'  => $_POST[ 'surepay_country' ],
                'phone'    => $_POST[ 'surepay_phone' ],
                'email'    => $_POST[ 'surepay_email' ]
            )
        );

        if( $ssp->err )
        {
            die( $ssp->err );
        }

        // --- Add total as lineitem ---
        // -- We only add one lineitem with the total right now.  If you wanted to, you could
        // --  rewrite this to use multiple lineitems to more accurately reflect the items
        // --  in the current order.
         
        ## Syntax:
        ##  object_identifier: add_lineitem (
        ##      object_identifier: parent object (The AUTH object)
        ##     ,int: quantity,
        ##     ,string: sku,
        ##     ,string: description, 
        ##     ,string: unit cost (currency) [d..d]d.ccUSD
        ##     ,real: taxrate in decimal notation (0.08 = 8%)
        ##    [,array: options ]
        ##  )
    
        $item = $ssp->add_lineitem (
            $auth,
            '1',
            'ORDER_TOTAL',
            'Order total for this order.',
            $amount,
            $_POST[ 'surepay_tax_rate' ]
        );
    
        if( $ssp->err )
        {
            die( $ssp->err );
        }
    
        // --- Generate the XML request for SurePay. ---
        $ssp->prepare_request();
        if( $ssp->err )
        {
            die($ssp->err);
        }

        // TODO: remove.  debug info
        if( $surepay_debug_mode )
        {
            echo "server: " . $ssp->serverurl;
            echo "</PRE><h2>The request xml we send:</H2><PRE>" . 
            htmlentities($ssp->xml_request,ENT_QUOTES) . "\n<hr>";
        }
        
        // --- Send the request to SurePay. ---
        $ssp->submit_request();
        if( $ssp->err )
        {
            die( $ssp->err );
        }
        
        // TODO: remove  debug info
        if( $surepay_debug_mode )
        {
           echo "</PRE><h2>The response xml we got back:</H2><PRE>" . 
           htmlentities($ssp->xml_response,ENT_QUOTES) . "\n<hr>";
           die( "\n<br>end" );
        }
        
        $responsecount = $ssp->parse_response();
        if( $ssp->err )
        {
            die( $ssp->err );
        }

        if( !$responsecount )
        {
            die( "Invalid response count.\n" );
        }

        
        // --- Check through the AUTH responses. --- 
        
        $auths = $ssp->auths();
        if( $ssp->err )
        {
            die( $ssp->err );
        }

        while( list( $key, $ssp_order ) = each( $auths ) )
        {
            // -- Store the transaction record in the SurePay table. ---
            $sql_data_array = array(
                'auth_code' => $ssp->auth_authcode( $ssp_order ),
                'transaction_id' => $ssp->auth_trans_id( $ssp_order ),
                'message' => $ssp->auth_text( $ssp_order )
            );
            smn_db_perform( TABLE_SUREPAY_TRANSACTIONS, $sql_data_array, 'update', 'request_id = ' . $ssp_order );
            if( $ssp->auth_status( $ssp_order ) != 'AUTH' )
            {
                // -- Redirect to error page.
                $err_msg = $ssp->auth_text( $ssp_order );
                smn_redirect( smn_href_link( FILENAME_CHECKOUT_PAYMENT, 'payment_error=' . $this->code . '&error=' . stripslashes( MODULE_PAYMENT_SUREPAY_TEXT_ERROR_DECLINED ), 'NONSSL', true, false ) );
            }
            
            if( $ssp->err )
            {
                die( $ssp->err );
            }
        }
    }
	

    
    /*
        No functionality yet.  This is called after the processing of the order info into the 
        database for OS Commerce.
    */
    function after_process()
    {
        return;
    }

     /*
        Returns SurePay errors.  Used in the pre-confirmation checks, iirc. 
    */

    function get_error() {
      global $_GET;
      
      // TODO: append surepay_err_header too?

      $error = array('title' => MODULE_PAYMENT_SUREPAY_TEXT_ERROR,
                     'error' => stripslashes(urldecode($_GET['error'])));

      return $error;
    }

    
    /*
        Checks to see if this payment module is installed.
    */
    function check()
    {
        if( !isset( $this->_check ) )
        {
            $check_query = smn_db_query( "select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SUREPAY_STATUS'" );
            $this->_check = smn_db_num_rows( $check_query );
        }
        return $this->_check;
    }

    /*
        Installs this payment module into OS Commerce.
    */
    function install()
    {
	global $store_id;
        smn_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Allow Surepay', 'MODULE_PAYMENT_SUREPAY_STATUS', '1', 'Do you want to accept Surepay payments?', '6', '0', now())" );
        smn_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Surepay Login', 'MODULE_PAYMENT_SUREPAY_LOGIN', '1001', 'Merchant id used for Surepay processing', '6', '0', now())" );
        smn_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Surepay Password', 'MODULE_PAYMENT_SUREPAY_PASSWORD', 'password', 'Password used for Surepay processing', '6', '0', now())" );
        smn_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Surepay Test Mode', 'MODULE_PAYMENT_SUREPAY_TESTMODE', '1', 'Test mode for Surepay payments', '6', '0', now())" );
        smn_db_query( "create table " . TABLE_SUREPAY_TRANSACTIONS . " ( request_id int(12) unsigned NOT NULL auto_increment, auth_code varchar(60) default NULL, transaction_id varchar(60) default NULL, message varchar(255) default NULL, PRIMARY KEY ( request_id ) );" ); 
	    if($store_id==1){
		  smn_db_query("insert into " . TABLE_CONFIGURATION . " (store_id, configuration_title,  configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . $store_id . "', 'For Single Checkout?', 'MODULE_PAYMENT_SUREPAY_SINGLE_CHECKOUT', 'False', 'Use this payment for single checkout?', '6', '2', 'smn_cfg_select_option(array(\'True\', \'False\'), ', now())");
	    }
    }

    
    /*
        Installs this payment module into OS Commerce.
    */
    function remove()
    {
        smn_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SUREPAY_STATUS'" );
        smn_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SUREPAY_LOGIN'" );
        smn_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SUREPAY_PASSWORD'" );
        smn_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SUREPAY_TESTMODE'" );
	    smn_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SUREPAY_SINGLE_CHECKOUT'" );
        smn_db_query( "drop table " . TABLE_SUREPAY_TRANSACTIONS . ";" );
    }

    /*
        Returns configuration keys.  Used by OS Commerce to determine what global vars to make available. 
    */
    function keys()
    {
	  global $store_id;
	   $key_array = array('MODULE_PAYMENT_SUREPAY_STATUS', 'MODULE_PAYMENT_SUREPAY_LOGIN', 'MODULE_PAYMENT_SUREPAY_PASSWORD', 'MODULE_PAYMENT_SUREPAY_TESTMODE');
	   if($store_id==1){
	   	$key_array = array_merge($key_array,array('MODULE_PAYMENT_PAYPAL_IPN_SINGLE_CHECKOUT'));
	   }
      return $key_array;
    }
  }
?>
