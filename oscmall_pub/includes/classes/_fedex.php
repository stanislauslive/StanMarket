<?php
/*
  Copyright (c) 2002 - 2006 SystemsManager.Net

  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately.

*/

  class _FedEx {
    var $Screen = 'Ground';
    var $OriginZip;
    var $OriginCountryCode = 'US';
    var $DestZip;
    var $DestCountryCode = 'U.S.A.';
    var $Weight = 0;
    var $WeightUnit = 'lbs';
    var $Length;
    var $Width;
    var $Height;
    var $DimUnit = 'in';

    function _FedEx($zip = '', $country = '') {
      if (smn_not_null($zip)) {
        $this->SetOrigin($zip, $country);
      }
    }

    function SetOrigin($zip, $country = '') {
      $this->OriginZip = $zip;

      if (smn_not_null($country)) {
        $this->OriginCountryCode = $country;
      }
    }

    function SetDest($zip, $country = '') {
      $zip = str_replace(' ', '', $zip);
      $zip = str_replace('-', '', $zip);

      if ($country == 'U.S.A.') {
        $this->DestZip = substr($zip, 0, 5);
      } else {
        $this->DestZip = $zip;
        $this->Screen = 'Express';
      }

      if (smn_not_null($country)) {
        $this->DestCountryCode = $country;
      }
    }

    function SetWeight($weight, $units = '') {
      if ($weight < 1) {
        $this->Weight = 1;
      } else {
        $this->Weight = $weight;
      }

      if (smn_not_null($units)) {
        $this->WeightUnit = $units;
      }
    }

    function SetSize($length = '', $width = '', $height = '', $units = '') {
      if (smn_not_null($length)) {
        $this->Length = $length;
      }

      if (smn_not_null($width)) {
        $this->Width = $width;
      }

      if (smn_not_null($height)) {
        $this->Height = $height;
      }

      if (smn_not_null($units)) {
        $this->DimUnit = $units;
      }
    }

    function GetQuote() {
      $parameters = array(/* static variables begin */
                          'jsp_name=index',
                          'orig_country=' . $this->OriginCountryCode,
                          'language=english',
                          'portal=xx',
                          'account=',
                          'heavy_weight=NO',
                          'packet_zip=',
                          'hold_packaging=',
                          /* static variable end */

                          'orig_zip=' . $this->OriginZip, //maxlength=6
                          'dest_zip=' . $this->DestZip, //maxlength=6
                          'dest_country_val=' . $this->DestCountryCode,

                          'company_type=' . $this->Screen, //Express,Ground,Home
                          'packaging=1', //only used with Express

                          'weight=' . $this->Weight, //maxlength=4
                          'weight_units=' . $this->WeightUnit, //lbs,kgs

                          'dim_units=' . $this->DimUnit, //in, cm
                          'dim_width=' . $this->Width,
                          'dim_height=' . $this->Height,

                          'dropoff_type=4', // 4=Dropoff at FedEx location, 1=Give to scheduled courier at my location, 2=Schedule a pickup

                          'submit_button=Get Rate');

      $parameters = join('&', $parameters);

      if ($result = $this->request_url('http://www.fedex.com/servlet/RateFinderServlet', '', $parameters)) {
// convert the string to an array for easier parsing
        $result_array = explode("\n", $result);

// get the html table rows containing the shipping rates
        $rates = array();
        $set = false;
        for ($i=0, $n=sizeof($result_array); $i<$n; $i++) {
          if (substr($result_array[$i], 0, 47) == '<TR><TD BGCOLOR="#FFFFFF" class=\'resultstable\'>' || substr($result_array[$i], 0, 47) == '<TR><TD BGCOLOR="#CCCCCC" class=\'resultstable\'>') {
            $rates[] = strip_tags($result_array[$i], '<td><br>');
            $set = true;
          } elseif ($set == true) {
            break;
          }
        }

// split the table row into an array (mimicking <td>)
// title, drop off rate, other charges, total rate: used below in $rates_raw
        $rates_split = array();
        for ($i=0, $n=sizeof($rates); $i<$n; $i++) {
          $rates_split[] = explode('</TD>', $rates[$i]);
        }

// remove the html tags
        $rates_raw = array();
        for ($i=0, $n=sizeof($rates_split); $i<$n; $i++) {
          if (strlen($rates_split[$i][0]) > 15) {
            $title = explode('&reg;', $rates_split[$i][0]);
            if (strstr($title[0], '<BR>')) $title = explode('<BR>', $title[0]);
            $rates_raw[] = array('Service' => strip_tags($title[0]),
                                 'TotalCharges' => strip_tags($rates_split[$i][3]));
          }
        }

        if (sizeof($rates_raw) < 1) {
          $rates_raw['ErrorNbr'] = 1;
          $rates_raw['Error'] = MODULE_SHIPPING_FEDEX_TEXT_ERROR;
        }
      } else {
        $rates_raw['ErrorNbr'] = 1;
        $rates_raw['Error'] = MODULE_SHIPPING_FEDEX_TEXT_ERROR;
      }

      return $rates_raw;
    }

    function request_url($url, $get_data, $post_data = '', $port = '80') {
      $response = '';

      $url = ereg_replace('^http://', '', $url);

      $host = substr($url, 0, strpos($url, '/'));
      $uri = strstr($url, '/');

      $method = ((empty($post_data)) ? 'GET' : 'POST');

      if ($method == 'GET') $uri .= '?' . $get_data;

      if ($fp = @fsockopen($host, $port)) {
        fputs($fp, $method . ' ' . $uri . ' HTTP/1.1' . "\n");
        fputs($fp, 'Host: ' . $host . "\n");
        fputs($fp, 'Content-Type: application/x-www-form-urlencoded' . "\n");
        fputs($fp, 'Content-Length: ' . strlen($post_data) . "\n");
        fputs($fp, 'User-Agent: ' . getenv('HTTP_USER_AGENT') . "\n");
        fputs($fp, 'Connection: close' . "\n\n");

        if ($method == 'POST') fputs($fp, $post_data);

        while (!feof($fp)) $response .= fgets($fp, 128);

        fclose($fp);
      }

      return $response;
    }
  }
?>
