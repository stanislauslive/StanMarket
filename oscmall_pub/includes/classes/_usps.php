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

  class _USPS {
    var $server = "";
    var $user = "";
    var $pass = "";
    var $service = "";
    var $dest_zip;
    var $orig_zip;
    var $pounds;
    var $ounces;
    var $container = "None";
    var $size = "REGULAR";
    var $machinable;

    function setServer($server) {
      $this->server = $server;
    }

    function setUserName($user) {
      $this->user = $user;
    }

    function setPass($pass) {
      $this->pass = $pass;
    }

// Must be: Express, Priority, or Parcel */
    function setService($service) {
      $this->service = $service;
    }

// Must be 5 digit zip (No extension)
    function setDestZip($sending_zip) {
      $this->dest_zip = $sending_zip;
    }

    function setOrigZip($orig_zip) {
      $this->orig_zip = $orig_zip;
    }

// Must weight less than 70 lbs. */
    function setWeight($pounds, $ounces=0) {
      $this->pounds = $pounds;
      $this->ounces = $ounces;
    }

/*
  Valid Containers Package Name         Description 
  ================ ==================== ===================================
  Express Mail     None                 For someone using their own package
                   0-1093 Express Mail  Box, 12.25 x 15.5 x
                   0-1094 Express Mail  Tube, 36 x 6
                   EP13A Express Mail   Cardboard Envelope, 12.5 x 9.5
                   EP13C Express Mail   Tyvek Envelope, 12.5 x 15.5
                   EP13F Express Mail   Flat Rate Envelope, 12.5 x 9.5
  Priority Mail    None                 For someone using their own package
                   0-1095 Priority Mail Box, 12.25 x 15.5 x 3 
                   0-1096 Priority Mail Video, 8.25 x 5.25 x 1.5 
                   0-1097 Priority Mail Box, 11.25 x 14 x 2.25 
                   0-1098 Priority Mail Tube, 6 x 38 
                   EP14 Priority Mail   Tyvek Envelope, 12.5 x 15.5 
                   EP14F Priority Mail  Flat Rate Envelope, 12.5 x 9.5 
  Parcel Post      None                 For someone using their own package
*/
    function setContainer($cont) {
      $this->container = $cont;
    }

/*
  Valid Sizes                         Description                 Service(s) Available
  =================================== =========================== ====================
  Regular package length plus girth   84 inches or less           Parcel Post
                                                                  Priority Mail
                                                                  Express Mail
  Large package length plus girth     between 84 and 108 inches   Parcel Post
                                                                  Priority Mail
                                                                  Express Mail
  Oversize package length plus girth  between 108 and 130 inches  Parcel Post
*/ 
    function setSize($size) {
      $this->size = $size;
    }

// Required for Parcel Post only, set to True or False
    function setMachinable($mach) {
      $this->machinable = $mach;
    }

    function getPrice() {
        $str  = '<RateRequest USERID="' . $this->user . '" PASSWORD="' . $this->pass . '">';
        $str .= '<Package ID="0">';
        $str .= '<Service>' . $this->service . '</Service>';
        $str .= '<ZipOrigination>' . $this->orig_zip . '</ZipOrigination>';
        $str .= '<ZipDestination>' . $this->dest_zip . '</ZipDestination>';
        $str .= '<Pounds>' . $this->pounds . '</Pounds>';
        $str .= '<Ounces>' . $this->ounces . '</Ounces>';
        $str .= '<Container>' . $this->container . '</Container>';
        $str .= '<Size>' . $this->size . '</Size>';
        $str .= '<Machinable>' . $this->machinable . '</Machinable>';
        $str .= '</Package>';
        $str .= '</RateRequest>';
        $str = $this->server . '?API=Rate&XML=' . urlencode($str);

        $fp = fopen($str, "r");
        if (!$fp) {
          $body = 'Connection Failed';
        } else {
          while(!feof($fp)){  
            $result = fgets($fp, 500);  
            $body.=$result;
          }  
          fclose($fp);
        }

        if (ereg("<Postage>", $body)) {
          $split = split("<Postage>", $body);
          $body = split("</Postage>", $split[1]);
          $price = $body[0];
          return($price);
        } else {
          return($body);
        }
    }

    function trackPackage($ids) {
      $url = $this->server . '?API=Track&XML=';
      $xml = '<TrackRequest USERID="' . $this->user . '" PASSWORD="' . $this->pass . '">';
      for ($i = 0; $i < count($ids); $i ++) {
        $id = $ids[$i];
        $xml .= '<TrackID ID="' . $id . '"></TrackID>';
      }
      $xml .= '</TrackRequest>';
      $url = $url . urlencode($xml);

      $fp = fopen($url, 'r');
      while (!feof($fp)) {
        $str .= fread($fp, 80);
      }
      fclose($fp);

      $cnt = 0;
      $text = split('<TrackInfo ID=', $str);
      for ($i = 0; $i < count($text); $i ++) {
        if (ereg('<TrackSummary>(.+)</TrackSummary>', $text[$i], $regs)) {
          $values['eta'] = $regs[1];
          if (eregi('delivered', $values['eta'])) {
            $values["eta"] = "Delivered";
          } else {
            $values["eta"] = "In Transit";
          }
          $cnt ++;
        }
      }
      $values['type'] = 'Priority Mail';

      return $values;
    }
  }
?>
