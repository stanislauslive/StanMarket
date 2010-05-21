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



    UPS Shipping calculator.  Much of this is re-organized stuff that was 
    borrowed from shawnblue@radiotakeover.com.  I fixed a couple of bugs, 
    and optimized much of the code for speed (ie switch(), rather than 
    a bunch of if() statements, join(), rather than a lot of .=  
    statements, etc..  I tested this using the sample code below (using 
    various values for my paramaters), and it works pretty well.  Happy 
    shipping. 

    Sample usage: 
    $rate = new Ups; 
    $rate->upsProduct("1DM");    // See upsProduct() function for codes 
    $rate->origin("08033", "US"); // Use ISO country codes! 
    $rate->dest("90210", "US");      // Use ISO country codes! 
    $rate->rate("RDP");        // See the rate() function for codes 
    $rate->container("CP");    // See the container() function for codes 
    $rate->weight("2"); 
    $rate->rescom("RES");    // See the rescom() function for codes 
    $quote = $rate->getQuote(); 
    echo $quote; 

  */ 

  class _Ups { 

    function upsProduct($prod){ 
        
     /* 
     1DM == Next Day Air Early AM 
     1DA == Next Day Air 
     1DP == Next Day Air Saver 
     2DM == 2nd Day Air Early AM 
     2DA == 2nd Day Air 
     3DS == 3 Day Select 
     GND == Ground 
     STD == Canada Standard 
     XPR == Worldwide Express 
     XDM == Worldwide Express Plus 
     XPD == Worldwide Expedited 
     */ 
      $this->upsProductCode = $prod; 
    } 
     
    function origin($postal, $country){ 
      $this->originPostalCode = $postal; 
      $this->originCountryCode = $country; 
    } 

    function dest($postal, $country){ 
      $postal = str_replace(' ', '', $postal);
      if ($country == 'US') {
	$this->destPostalCode = substr($postal, 0, 5);
      } else {
	$this->destPostalCode = $postal; 
      }
      $this->destCountryCode = $country; 
    } 

    function rate($foo){ 
      switch($foo){ 
        case  "RDP": 
          $this->rateCode =  "Regular+Daily+Pickup"; 
          break; 
        case  "OCA": 
          $this->rateCode =  "On+Call+Air"; 
          break; 
        case  "OTP": 
          $this->rateCode =  "One+Time+Pickup"; 
          break; 
        case  "LC": 
          $this->rateCode =  "Letter+Center"; 
          break; 
        case  "CC": 
          $this->rateCode =  "Customer+Counter"; 
          break; 
      } 
    } 

    function container($foo){ 
          switch($foo){ 
        case  "CP":             // Customer Packaging 
          $this->containerCode =  "00"; 
          break; 
               case  "ULE":         // UPS Letter Envelope 
          $this->containerCode =  "01";         
          break; 
        case  "UT":             // UPS Tube 
          $this->containerCode =  "03"; 
          break; 
        case  "UEB":             // UPS Express Box 
          $this->containerCode =  "21"; 
          break; 
        case  "UW25":         // UPS Worldwide 25 kilo 
          $this->containerCode =  "24"; 
          break; 
        case  "UW10":         // UPS Worldwide 10 kilo 
          $this->containerCode =  "25"; 
          break; 
      } 
    } 
     
    function weight($foo){ 
      $this->packageWeight = $foo; 
    } 

    function rescom($foo){ 
          switch($foo){ 
        case  "RES":             // Residential Address 
          $this->resComCode =  "1"; 
          break; 
        case  "COM":             // Commercial Address 
          $this->resComCode =  "2"; 
          break; 
          } 
    } 

    function getQuote(){ 
          $upsAction =  "3";  // You want 3.  Don't change unless you are sure. 
      $url = join( "&",  
               array( "http://www.ups.com/using/services/rave/qcostcgi.cgi?accept_UPS_license_agreement=yes", 
                      "10_action=$upsAction", 
                      "13_product=$this->upsProductCode", 
                      "14_origCountry=$this->originCountryCode", 
                      "15_origPostal=$this->originPostalCode", 
                      "19_destPostal=$this->destPostalCode", 
                      "22_destCountry=$this->destCountryCode", 
                      "23_weight=$this->packageWeight", 
                      "47_rate_chart=$this->rateCode", 
                      "48_container=$this->containerCode", 
                      "49_residential=$this->resComCode" 
           ) 
                ); 
      $fp = fopen($url,  "r"); 
      while(!feof($fp)){ 
        $result = fgets($fp, 500); 
        $result = explode( "%", $result); 
        $errcode = substr($result[0], -1); 
        switch($errcode){ 
          case 3: 
            $returnval = $result[8]; 
                break; 
          case 4: 
            $returnval = $result[8]; 
            break; 
          case 5: 
            $returnval = $result[1]; 
            break; 
          case 6: 
            $returnval = $result[1]; 
            break; 
        } 
      } 
      fclose($fp); 
          if(! $returnval) { $returnval =  "error"; } 
      return $returnval; 
    } 
  } 

?>
