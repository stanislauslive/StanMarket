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
?>
<!-- affiliate_news //-->
<?php
  /*Changed the query to get the details of affiliate news, by Cimi*/
  /*$affiliate_news_query = smn_db_query('SELECT * from ' . TABLE_AFFILIATE_NEWS . ' WHERE status = 1 ORDER BY date_added DESC LIMIT ' . MAX_DISPLAY_AFFILIATE_NEWS);*/
  $affiliate_news_query = smn_db_query('SELECT * from ' . TABLE_AFFILIATE_NEWS . ' an,' . TABLE_AFFILIATE_NEWS_CONTENTS . ' anc WHERE news_status = 1 ORDER BY date_added DESC LIMIT ' . MAX_DISPLAY_AFFILIATE_NEWS);

  if (!smn_db_num_rows($affiliate_news_query)) { // there is no news
    echo '<!-- ' . TEXT_NO_AFFILIATE_NEWS . ' -->';
  } else {

    $info_box_contents = array();
    $row = 0;
    while ($affiliate_news = smn_db_fetch_array($affiliate_news_query)) {
	/*Changed the array contents to get values according to DB,by Cimi*/
      /*$info_box_contents[$row] = array('align' => 'left',
                                       'params' => 'class="smallText" valign="top"',
                                       'text' => '<b>' . $affiliate_news['headline'] . '</b> - <i>' . smn_date_long($affiliate_news['date_added']) . '</i><br>' . nl2br($affiliate_news['content']) . '<br>');*/
      $info_box_contents[$row] = array('align' => 'left',
                                       'params' => 'class="smallText" valign="top"',
									   'text' => '<b>' . $affiliate_news['affiliate_news_headlines'] . '</b> - <i>' . smn_date_long($affiliate_news['date_added']) . '</i><br>' . nl2br($affiliate_news['affiliate_news_contents']) . '<br>');
      $row++;
    }
    new contentBox($info_box_contents); 
  /*Commente the following code to as it creates incomplete box , By Cimi*/ 
/*$info_box_contents = array(); 
  $info_box_contents[] = array('align' => 'left', 
                                'text'  => ' ' 
                              ); 
  new infoBoxDefault($info_box_contents, true, true);*/
  }
?>
<!-- affiliate_news_eof //-->
