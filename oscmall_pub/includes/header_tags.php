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

  WebMakers.com  Header Tags Generator v2.3
*/


echo '<!-- BOF: Generated Meta Tags -->' . "\n";

$the_desc='';
$the_key_words='';
$the_title='';

// Define specific settings per page:
switch (true) {

// INDEX.PHP
  case (strstr($_SERVER['PHP_SELF'],FILENAME_DEFAULT) or strstr($PHP_SELF,FILENAME_DEFAULT) ):
    $the_category_query = smn_db_query("select cd.categories_name, c.category_head_title_tag, c.category_head_desc_tag, c.category_head_keywords_tag from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and cd.categories_id = '" . (int)$current_category_id . "' and cd.language_id = '" . (int)$languages_id . "'");
    $the_category = smn_db_fetch_array($the_category_query);

    $the_manufacturers_query= smn_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
    $the_manufacturers = smn_db_fetch_array($the_manufacturers_query);
 
    $showCatTags = false;
    if ($category_depth == 'nested' || ($category_depth == 'products' || isset($_GET['manufacturers_id']))) 
      $showCatTags = true;
    
    if (HTDA_DEFAULT_ON=='1') {
      if ($showCatTags == true) {
        $the_desc= $the_category['category_head_desc_tag'] . HEAD_DESC_TAG_DEFAULT . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= HEAD_DESC_TAG_DEFAULT . ' ' . HEAD_DESC_TAG_ALL;
      }
    } else {
      if ($showCatTags == true) {
        $the_desc= $the_category['category_head_desc_tag'] . HEAD_DESC_TAG_DEFAULT;
      } else {
        $the_desc= HEAD_DESC_TAG_DEFAULT;
      }  
    }

    if (HTKA_DEFAULT_ON=='1') {
      if ($showCatTags == true) {
        $the_key_words= $the_category['category_head_keywords_tag'] . HEAD_KEY_TAG_ALL . ' ' . HEAD_KEY_TAG_DEFAULT;
      } else {
        $the_key_words= HEAD_KEY_TAG_ALL . ' ' . HEAD_KEY_TAG_DEFAULT;
      }  
    } else {
      if ($showCatTags == true) {
         $the_key_words= $the_category['category_head_keywords_tag'] . HEAD_KEY_TAG_DEFAULT;
      } else {
         $the_key_words= HEAD_KEY_TAG_DEFAULT;
      }   
    }

    if (HTTA_DEFAULT_ON=='1') {
      if ($showCatTags == true) {
        $the_title= $the_category['category_head_title_tag'] . HEAD_TITLE_TAG_DEFAULT . " " . $the_category['categories_name'] . $the_manufacturers['manufacturers_name'] . ' - ' . HEAD_TITLE_TAG_ALL;
      } else {
        $the_title= HEAD_TITLE_TAG_DEFAULT . " " . $the_category['categories_name'] . $the_manufacturers['manufacturers_name'] . ' - ' . HEAD_TITLE_TAG_ALL;
      }
    } else {
      if ($showCatTags == true) {
        $the_title= $the_category['category_head_title_tag'] . HEAD_TITLE_TAG_DEFAULT;
      } else {
        $the_title= HEAD_TITLE_TAG_DEFAULT;
      }  
    }

    break;

// PRODUCT_INFO.PHP
  case ( strstr($_SERVER['PHP_SELF'],'product_info.php') or strstr($PHP_SELF,'product_info.php') ):
//    $the_product_info_query = smn_db_query("select p.products_id, pd.products_name, pd.products_description, pd.products_head_title_tag, pd.products_head_keywords_tag, pd.products_head_desc_tag, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . $_GET['products_id'] . "' and pd.products_id = '" . $_GET['products_id'] . "'");
    $the_product_info_query = smn_db_query("select pd.language_id, p.products_id, pd.products_name, pd.products_description, pd.products_head_title_tag, pd.products_head_keywords_tag, pd.products_head_desc_tag, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = '" . (int)$_GET['products_id'] . "'" . " and pd.language_id ='" .  (int)$languages_id . "'");
    $the_product_info = smn_db_fetch_array($the_product_info_query);

    if (empty($the_product_info['products_head_desc_tag'])) {
      $the_desc= HEAD_DESC_TAG_ALL;
    } else {
      if ( HTDA_PRODUCT_INFO_ON=='1' ) {
        $the_desc= $the_product_info['products_head_desc_tag'] . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= $the_product_info['products_head_desc_tag'];
      }
    }

    if (empty($the_product_info['products_head_keywords_tag'])) {
      $the_key_words= HEAD_KEY_TAG_ALL;
    } else {
      if ( HTKA_PRODUCT_INFO_ON=='1' ) {
        $the_key_words= $the_product_info['products_head_keywords_tag'] . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= $the_product_info['products_head_keywords_tag'];
      }
    }

    if (empty($the_product_info['products_head_title_tag'])) {
      $the_title= HEAD_TITLE_TAG_ALL;
    } else {
      if ( HTTA_PRODUCT_INFO_ON=='1' ) {
	  /*Commented L118 and added L119 to strip tags from the title of the page by Cimi on June 08,2007*/
	  
        //$the_title= $the_product_info['products_head_title_tag'] . ' - ' . HEAD_TITLE_TAG_ALL;
        $the_title= strip_tags($the_product_info['products_head_title_tag']) . ' - ' . HEAD_TITLE_TAG_ALL;
      } else {
	  /*Commented L123 and added L124 to strip tags from the title of the page by Cimi on June 08,2007*/
	  
        //$the_title= $the_product_info['products_head_title_tag'];
        $the_title= strip_tags($the_product_info['products_head_title_tag']);
      }
    }

    break;


// PRODUCTS_NEW.PHP
  case ( strstr($_SERVER['PHP_SELF'],'products_new.php') or strstr($PHP_SELF,'products_new.php') ):
    if ( HEAD_DESC_TAG_WHATS_NEW!='' ) {
      if ( HTDA_WHATS_NEW_ON=='1' ) {
        $the_desc= HEAD_DESC_TAG_WHATS_NEW . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= HEAD_DESC_TAG_WHATS_NEW;
      }
    } else {
      $the_desc= HEAD_DESC_TAG_ALL;
    }

    if ( HEAD_KEY_TAG_WHATS_NEW!='' ) {
      if ( HTKA_WHATS_NEW_ON=='1' ) {
        $the_key_words= HEAD_KEY_TAG_WHATS_NEW . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= HEAD_KEY_TAG_WHATS_NEW;
      }
    } else {
      $the_key_words= HEAD_KEY_TAG_ALL;
    }

    if ( HEAD_TITLE_TAG_WHATS_NEW!='' ) {
      if ( HTTA_WHATS_NEW_ON=='1' ) {
        $the_title= HEAD_TITLE_TAG_WHATS_NEW . ' - ' . HEAD_TITLE_TAG_ALL;
      } else {
        $the_title= HEAD_TITLE_TAG_WHATS_NEW;
      }
    } else {
      $the_title= HEAD_TITLE_TAG_ALL;
    }

    break;


// SPECIALS.PHP
  case ( strstr($_SERVER['PHP_SELF'],'specials.php')  or strstr($PHP_SELF,'specials.php') ):
    if ( HEAD_DESC_TAG_SPECIALS!='' ) {
      if ( HTDA_SPECIALS_ON=='1' ) {
        $the_desc= HEAD_DESC_TAG_SPECIALS . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= HEAD_DESC_TAG_SPECIALS;
      }
    } else {
      $the_desc= HEAD_DESC_TAG_ALL;
    }

    if ( HEAD_KEY_TAG_SPECIALS=='' ) {
      // Build a list of ALL specials product names to put in keywords
      $new = smn_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' order by s.specials_date_added DESC ");
      $row = 0;
      $the_specials='';
      while ($new_values = smn_db_fetch_array($new)) {
        $the_specials .= clean_html_comments($new_values['products_name']) . ', ';
      }
      if ( HTKA_SPECIALS_ON=='1' ) {
        $the_key_words= $the_specials . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= $the_specials;
      }
    } else {
      $the_key_words= HEAD_KEY_TAG_SPECIALS . ' ' . HEAD_KEY_TAG_ALL;
    }

    if ( HEAD_TITLE_TAG_SPECIALS!='' ) {
      if ( HTTA_SPECIALS_ON=='1' ) {
        $the_title= HEAD_TITLE_TAG_SPECIALS . ' - ' . HEAD_TITLE_TAG_ALL;
      } else {
        $the_title= HEAD_TITLE_TAG_SPECIALS;
      }
    } else {
      $the_title= HEAD_TITLE_TAG_ALL;
    }

    break;


// PRODUCTS_REVIEWS_INFO.PHP and PRODUCTS_REVIEWS.PHP
  case ( strstr($_SERVER['PHP_SELF'],'product_reviews_info.php') or strstr($_SERVER['PHP_SELF'],'product_reviews.php') or strstr($PHP_SELF,'product_reviews_info.php') or strstr($PHP_SELF,'product_reviews.php') ):
    if ( HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO=='' ) {
      if ( HTDA_PRODUCT_REVIEWS_INFO_ON=='1' ) {
        $the_desc = smn_get_header_tag_products_desc(isset($_GET['reviews_id'])) . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc = smn_get_header_tag_products_desc(isset($_GET['reviews_id']));
      }
    } else {
      $the_desc= HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO;
    }

    if ( HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO=='' ) {
      if ( HTKA_PRODUCT_REVIEWS_INFO_ON=='1' ) {
        $the_key_words= smn_get_header_tag_products_keywords(isset($_GET['reviews_id'])) . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= smn_get_header_tag_products_keywords(isset($_GET['reviews_id']));
      }
    } else {
      $the_key_words= HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO;
    }

    if ( HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO=='' ) {
      if ( HTTA_PRODUCT_REVIEWS_INFO_ON=='1' ) {
        $the_title= smn_get_header_tag_products_title(isset($_GET['reviews_id'])) . ' - ' . HEAD_TITLE_TAG_ALL;
      } else {
        $the_title= smn_get_header_tag_products_title(isset($_GET['reviews_id']));
      }
    } else {
      $the_title= HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO;
    }

    break;

// ALL OTHER PAGES NOT DEFINED ABOVE
  default:
    $the_desc= HEAD_DESC_TAG_ALL;
    $the_key_words= HEAD_KEY_TAG_ALL;
    $the_title= HEAD_TITLE_TAG_ALL;
    break;

  }
echo '  <title>' . $the_title . '</title>' . "\n";
echo ' <meta http-equiv="Content-Type" content="text/html; charset=' . CHARSET  . '">'."\n";
echo '  <META NAME="Description" Content="' . $the_desc . '">' . "\n";
echo '  <META NAME="Keywords" CONTENT="' . $the_key_words . '">' . "\n";
echo '  <META NAME="Reply-to" CONTENT="' . HEAD_REPLY_TAG_ALL . '">' . "\n";

echo '<!-- EOF: Generated Meta Tags -->' . "\n";
?>