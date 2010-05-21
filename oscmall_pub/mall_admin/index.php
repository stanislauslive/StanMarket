<?php
/*
  Copyright (c) 2002 - 2005 SystemsManager.Net

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

  require('includes/application_top.php');

  $cat = array(array('title' => BOX_HEADING_MY_ACCOUNT,
                     'access' => 'true',
                     'image' => 'my_account.gif',
                     'href' => smn_href_link(FILENAME_ADMIN_ACCOUNT),
                     'children' => array(array('title' => 'My Account', 'link' => smn_href_link(FILENAME_ADMIN_ACCOUNT),
                                               'access' => 'true')),
                                         array('title' => 'logoff', 'link' => smn_href_link(FILENAME_LOGOFF),
                                               'access' => 'true')),
  
                array('title' => BOX_HEADING_LAYOUT_CUSTOMIZATION,
                      'access' => 'true',
                     'image' => 'configuration.gif',
                     'href' => smn_href_link(FILENAME_TEMPLATE, 'selected_box=layout'),
                     'children' => array(array('title' => BOX_MANAGEMENT, 'link' => smn_href_link(FILENAME_MANAGEMENT, 'selected_box=layout'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_MANAGEMENT, 'sub_boxes')),
                                         array('title' => BOX_TEXT_EDITOR, 'link' => smn_href_link(FILENAME_TEXT_EDITOR, 'selected_box=layout'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_TEXT_EDITOR, 'sub_boxes')))),
   
               array('title' => BOX_HEADING_ADMINISTRATOR,
                     'access' => $store->smn_admin_check_boxes('administrator.php'),
                     'image' => 'administrator.gif',
                     'href' => smn_href_link('admin.php')),
               array('title' => BOX_HEADING_CONFIGURATION,
                     'access' => $store->smn_admin_check_boxes('configuration.php'),
                     'image' => 'configuration.gif',
                     'href' => smn_href_link(FILENAME_CONFIGURATION, 'selected_box=configuration&gID=1'),
                     'children' => array(array('title' => BOX_CONFIGURATION_MYSTORE, 'link' => smn_href_link(FILENAME_CONFIGURATION, 'selected_box=configuration&gID=1'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_CONFIGURATION, 'sub_boxes')),
                                         array('title' => BOX_CONFIGURATION_LOGGING, 'link' => smn_href_link(FILENAME_CONFIGURATION, 'selected_box=configuration&gID=10'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_CONFIGURATION, 'sub_boxes')),
                                         array('title' => BOX_CONFIGURATION_CACHE, 'link' => smn_href_link(FILENAME_CONFIGURATION, 'selected_box=configuration&gID=11'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_CONFIGURATION, 'sub_boxes')))),
               array('title' => BOX_HEADING_MODULES,
                     'access' => $store->smn_admin_check_boxes('modules.php'),
                     'image' => 'modules.gif',
                     'href' => smn_href_link($store->smn_selected_file('modules.php'), 'selected_box=modules&set=payment'),
                     'children' => array(array('title' => BOX_MODULES_PAYMENT, 'link' => smn_href_link(FILENAME_MODULES, 'selected_box=modules&set=payment'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_MODULES, 'sub_boxes')),
                                         array('title' => BOX_MODULES_SHIPPING, 'link' => smn_href_link(FILENAME_MODULES, 'selected_box=modules&set=shipping'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_MODULES, 'sub_boxes')))),
               array('title' => BOX_HEADING_CATALOG,
                     'access' => $store->smn_admin_check_boxes('catalog.php'),
                     'image' => 'catalog.gif',
                     'href' => smn_href_link($store->smn_selected_file('catalog.php'), 'selected_box=catalog'),
                     'children' => array(array('title' => CATALOG_CONTENTS, 'link' => smn_href_link(FILENAME_CATEGORIES, 'selected_box=catalog'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_CATEGORIES, 'sub_boxes')),
                                         array('title' => BOX_CATALOG_MANUFACTURERS, 'link' => smn_href_link(FILENAME_MANUFACTURERS, 'selected_box=catalog'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_MANUFACTURERS, 'sub_boxes')))),
               array('title' => BOX_HEADING_LOCATION_AND_TAXES,
                     'access' => $store->smn_admin_check_boxes('taxes.php'),
                     'image' => 'location.gif',
                     'href' => smn_href_link($store->smn_selected_file('taxes.php'), 'selected_box=taxes'),
                     'children' => array(array('title' => BOX_TAXES_COUNTRIES, 'link' => smn_href_link(FILENAME_COUNTRIES, 'selected_box=taxes'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_COUNTRIES, 'sub_boxes')),
                                         array('title' => BOX_TAXES_GEO_ZONES, 'link' => smn_href_link(FILENAME_GEO_ZONES, 'selected_box=taxes'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_GEO_ZONES, 'sub_boxes')))),
               array('title' => BOX_TITLE_ORDERS,
                     'access' => $store->smn_admin_check_boxes('customers_info.php'),
                     'image' => 'customers.gif',
                     'href' => smn_href_link($store->smn_selected_file('customers_info.php'), 'selected_box=customers_info'),
                     'children' => array(array('title' => BOX_CUSTOMERS_CUSTOMERS, 'link' => smn_href_link(FILENAME_CUSTOMERS, 'selected_box=customers_info'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_CUSTOMERS, 'sub_boxes')),
                                         array('title' => BOX_CUSTOMERS_ORDERS, 'link' => smn_href_link(FILENAME_ORDERS, 'selected_box=customers_info'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_ORDERS, 'sub_boxes')))),
               array('title' => BOX_HEADING_LOCALIZATION,
                     'access' => $store->smn_admin_check_boxes('localization.php'),
                     'image' => 'localization.gif',
                     'href' => smn_href_link($store->smn_selected_file('localization.php'), 'selected_box=localization'),
                     'children' => array(array('title' => BOX_LOCALIZATION_CURRENCIES, 'link' => smn_href_link(FILENAME_CURRENCIES, 'selected_box=localization'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_CURRENCIES, 'sub_boxes')),
                                         array('title' => BOX_LOCALIZATION_LANGUAGES, 'link' => smn_href_link(FILENAME_LANGUAGES, 'selected_box=localization'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_LANGUAGES, 'sub_boxes')))),
               array('title' => BOX_HEADING_REPORTS,
                     'access' => $store->smn_admin_check_boxes('reports.php'),
                     'image' => 'reports.gif',
                     'href' => smn_href_link($store->smn_selected_file('reports.php'), 'selected_box=reports'),
                     'children' => array(array('title' => REPORTS_PRODUCTS, 'link' => smn_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, 'selected_box=reports'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_STATS_PRODUCTS_PURCHASED, 'sub_boxes')),
                                         array('title' => REPORTS_ORDERS, 'link' => smn_href_link(FILENAME_STATS_CUSTOMERS, 'selected_box=reports'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_STATS_CUSTOMERS, 'sub_boxes')))),
               array('title' => BOX_HEADING_TOOLS,
                     'access' => $store->smn_admin_check_boxes('tools.php'),
                     'image' => 'tools.gif',
                     'href' => smn_href_link($store->smn_selected_file('tools.php'), 'selected_box=tools'),
                     'children' => array(array('title' => TOOLS_NEWLETTERS, 'link' => smn_href_link(FILENAME_NEWSLETTERS, 'selected_box=tools'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_NEWSLETTERS, 'sub_boxes')),
                                         array('title' => TOOLS_BANNERS, 'link' => smn_href_link(FILENAME_BANNER_MANAGER, 'selected_box=tools'),
                                               'access' => $store->smn_admin_check_boxes(FILENAME_BANNER_MANAGER, 'sub_boxes')))));

  $languages = smn_get_languages();
  $languages_array = array();
  $languages_selected = DEFAULT_LANGUAGE;
  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
    $languages_array[] = array('id' => $languages[$i]['code'],
                               'text' => $languages[$i]['name']);
    if ($languages[$i]['directory'] == $language) {
      $languages_selected = $languages[$i]['code'];
    }
  }
    
  $content_page = basename($_SERVER['PHP_SELF']);
  
  $ignoreHeader = true;
  $ignoreColumn = true;
  $ignoreFooter = true;
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>