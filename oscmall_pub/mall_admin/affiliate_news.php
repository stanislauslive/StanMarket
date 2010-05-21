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

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setflag': //set the status of a news item.
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if ($_GET['affiliate_news_id']) {
		  /*Changed the query to change the field names as in the table,by Cimi*/
            /*smn_db_query("update " . TABLE_AFFILIATE_NEWS . " set status = '" . $_GET['flag'] . "' where news_id = '" . $_GET['affiliate_news_id'] . "'");*/
            smn_db_query("update " . TABLE_AFFILIATE_NEWS . " set news_status = '" . $_GET['flag'] . "' where news_id = '" . $_GET['affiliate_news_id'] . "'");
          }
        }

        smn_redirect(smn_href_link(FILENAME_AFFILIATE_NEWS));
        break;

      case 'delete_affiliate_news_confirm': //user has confirmed deletion of news article.
        if ($_POST['affiliate_news_id']) {
          $affiliate_news_id = smn_db_prepare_input($_POST['affiliate_news_id']);
          smn_db_query("delete from " . TABLE_AFFILIATE_NEWS . " where news_id = '" . smn_db_input($affiliate_news_id) . "'");
		  /*Added the query to delete the news contents,by Cimi*/
		  smn_db_query("delete from " . TABLE_AFFILIATE_NEWS_CONTENTS . " where affiliate_news_id = '" . smn_db_input($affiliate_news_id) . "'");
        }

        smn_redirect(smn_href_link(FILENAME_AFFILIATE_NEWS));
        break;

      case 'insert_affiliate_news': //insert a new news article.
        if ($_POST['headline']) {
		/*Changed the insert query to add the news details to affiliate_news_content table by Cimi */
         /* $sql_data_array = array('headline'   => smn_db_prepare_input($_POST['headline']),
                                  'content'    => smn_db_prepare_input($_POST['content']),
                                  'date_added' => 'now()', //uses the inbuilt mysql function 'now'
                                  'status'     => '1' );

          smn_db_perform(TABLE_AFFILIATE_NEWS, $sql_data_array);
          $news_id = smn_db_insert_id();*/ //not actually used ATM -- just there in case          $sql_data_array = array('date_added' => 'now()', //uses the inbuilt mysql function 'now'
           $sql_data_array = array('date_added' => 'now()',
		                           'news_status'     => '1' );

          smn_db_perform(TABLE_AFFILIATE_NEWS, $sql_data_array);
          $news_id = smn_db_insert_id(); //not actually used ATM -- just there in case
        
		$sql_data_array = array('affiliate_news_id' => $news_id,
								'affiliate_news_languages_id' => $languages_id,
								'affiliate_news_headlines' => $_POST['headline'],
								'affiliate_news_contents' => $_POST['content'] );

        smn_db_perform(TABLE_AFFILIATE_NEWS_CONTENTS, $sql_data_array);
		}
        smn_redirect(smn_href_link(FILENAME_AFFILIATE_NEWS));
        break;

      case 'update_affiliate_news': //user wants to modify a news article.
        if($_GET['affiliate_news_id']) {
		/*Changed the update query to update the news details to affiliate_news_content table by Cimi */
         /* $sql_data_array = array('headline' => smn_db_prepare_input($_POST['headline']),
                                  'content'  => smn_db_prepare_input($_POST['content']) );
                                  
          smn_db_perform(TABLE_AFFILIATE_NEWS, $sql_data_array, 'update', "news_id = '" . smn_db_prepare_input($_GET['affiliate_news_id']) . "'");*/
          $sql_data_array = array('affiliate_news_headlines' => smn_db_prepare_input($_POST['headline']),
                                  'affiliate_news_contents'  => smn_db_prepare_input($_POST['content']) );
                                  
          smn_db_perform(TABLE_AFFILIATE_NEWS_CONTENTS, $sql_data_array, 'update', "affiliate_news_id = '" . smn_db_prepare_input($_GET['affiliate_news_id']) . "'");
        }
        smn_redirect(smn_href_link(FILENAME_AFFILIATE_NEWS));
        break;
    }
  }
  
  $content_page = basename($_SERVER['PHP_SELF']);
  
  require('templates/default/layout.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>