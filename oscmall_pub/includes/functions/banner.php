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

////
// Sets the status of a banner
  function smn_set_banner_status($banners_id, $status) {
    if ($status == '1') {
      return smn_db_query("update " . TABLE_BANNERS . " set status = '1', date_status_change = now(), date_scheduled = NULL where banners_id = '" . (int)$banners_id . "'");
    } elseif ($status == '0') {
      return smn_db_query("update " . TABLE_BANNERS . " set status = '0', date_status_change = now() where banners_id = '" . (int)$banners_id . "'");
    } else {
      return -1;
    }
  }

////
// Auto activate banners
  function smn_activate_banners() {
    $banners_query = smn_db_query("select banners_id, date_scheduled from " . TABLE_BANNERS . " where date_scheduled != ''");
    if (smn_db_num_rows($banners_query)) {
      while ($banners = smn_db_fetch_array($banners_query)) {
        if (date('Y-m-d H:i:s') >= $banners['date_scheduled']) {
          smn_set_banner_status($banners['banners_id'], '1');
        }
      }
    }
  }

////
// Auto expire banners
  function smn_expire_banners() {
    $banners_query = smn_db_query("select b.banners_id, b.expires_date, b.expires_impressions, sum(bh.banners_shown) as banners_shown from " . TABLE_BANNERS . " b, " . TABLE_BANNERS_HISTORY . " bh where b.status = '1' and b.banners_id = bh.banners_id group by b.banners_id");
    if (smn_db_num_rows($banners_query)) {
      while ($banners = smn_db_fetch_array($banners_query)) {
        if (smn_not_null($banners['expires_date'])) {
          if (date('Y-m-d H:i:s') >= $banners['expires_date']) {
            smn_set_banner_status($banners['banners_id'], '0');
          }
        } elseif (smn_not_null($banners['expires_impressions'])) {
          if ( ($banners['expires_impressions'] > 0) && ($banners['banners_shown'] >= $banners['expires_impressions']) ) {
            smn_set_banner_status($banners['banners_id'], '0');
          }
        }
      }
    }
  }

////
// Display a banner from the specified group or banner id ($identifier)
  function smn_display_banner($action, $identifier) {
    if ($action == 'dynamic') {
      $banners_query = smn_db_query("select count(*) as count from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      $banners = smn_db_fetch_array($banners_query);
      if ($banners['count'] > 0) {
        $banner = smn_random_select("select banners_group, banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      } else {
        return '<b>smn ERROR! (smn_display_banner(' . $action . ', ' . $identifier . ') -> No banners with group \'' . $identifier . '\' found!</b>';
      }
    } elseif ($action == 'static') {
      if (is_array($identifier)) {
        $banner = $identifier;
      } else {
        $banner_query = smn_db_query("select banners_group, banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . (int)$identifier . "'");
        if (smn_db_num_rows($banner_query)) {
          $banner = smn_db_fetch_array($banner_query);
        } else {
          return '<b>smn ERROR! (smn_display_banner(' . $action . ', ' . $identifier . ') -> Banner with ID \'' . $identifier . '\' not found, or status inactive</b>';
        }
      }
    } else {
      return '<b>smn ERROR! (smn_display_banner(' . $action . ', ' . $identifier . ') -> Unknown $action parameter value - it must be either \'dynamic\' or \'static\'</b>';
    }

    if (smn_not_null($banner['banners_html_text'])) {
      $banner_string = $banner['banners_html_text'];
    } else {
// systemsmanager begin - Nov 30, 2005
      $banner_string = '<a href="' . smn_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner['banners_id']) . '" target="_blank">' . smn_image('images/' . $banner['banners_image'], $banner['banners_title'], ($banner['banners_group'] === 'Side' ? '154' : '') ) . '</a>';
    }

    smn_update_banner_display_count($banner['banners_id']);

    return $banner_string;
  }

////
// Check to see if a banner exists
/* systemsmanager begin - Nov 29, 2005
  function smn_banner_exists($action, $identifier) {
    if ($action == 'dynamic') {
      return smn_random_select("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
    } elseif ($action == 'static') {
      $banner_query = smn_db_query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . (int)$identifier . "'");
      return smn_db_fetch_array($banner_query);
    } else {
      return false;
    }
  }
*/
  function smn_banner_exists($action, $identifier, $prodid=0, $cPath=0) {
	
    if ($prodid!=0 && $cPath==0) {
		$sql = "SELECT categories_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE products_id=$prodid";
		$row = smn_db_fetch_array(smn_db_query($sql));
		$catid = $row['categories_id'];
	}
	else {
	  	$catid = $cPath;
	}

  	if ($catid==0) {
		if ($action == 'dynamic') {
		  return smn_random_select("select banners_group, banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
		} elseif ($action == 'static') {
		  $banner_query = smn_db_query("select banners_group, banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . (int)$identifier . "'");
		  return smn_db_fetch_array($banner_query);
		} else {
		  return false;
		}
	}
	else {
		if ($action == 'dynamic') {
		  $sql = "select banners_group, banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and categories_id=" . $catid . " and banners_group = '" . $identifier . "'";
		  $qry = smn_db_query($sql);
		  if (smn_db_num_rows($qry) > 0) {
			  return smn_random_select($sql);
		  }
		  else {
			  $sql = "select banners_group, banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and categories_id=0 and banners_group = '" . $identifier . "'";
			  return smn_random_select($sql);
		  }
		} elseif ($action == 'static') {
		  $sql = "select banners_group, banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and categories_id=" . $catid . " and banners_id = '" . (int)$identifier . "'";
		  $banner_query = smn_db_query($sql);
		  if (smn_db_num_rows($banner_query) > 0) {
			  return smn_db_fetch_array($banner_query);
		  }
		  else {
			  $sql = "select banners_group, banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . (int)$identifier . "'";
			  $banner_query = smn_db_query($sql);
			  return smn_db_fetch_array($banner_query);
		  }
		} else {
		  return false;
		}
	}
  }
// systemsmanager end

////
// Update the banner display statistics
  function smn_update_banner_display_count($banner_id) {
    $banner_check_query = smn_db_query("select count(*) as count from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . (int)$banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
    $banner_check = smn_db_fetch_array($banner_check_query);

    if ($banner_check['count'] > 0) {
      smn_db_query("update " . TABLE_BANNERS_HISTORY . " set banners_shown = banners_shown + 1 where banners_id = '" . (int)$banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
    } else {
      smn_db_query("insert into " . TABLE_BANNERS_HISTORY . " (banners_id, banners_shown, banners_history_date) values ('" . (int)$banner_id . "', 1, now())");
    }
  }

////
// Update the banner click statistics
  function smn_update_banner_click_count($banner_id) {
    smn_db_query("update " . TABLE_BANNERS_HISTORY . " set banners_clicked = banners_clicked + 1 where banners_id = '" . (int)$banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
  }
?>