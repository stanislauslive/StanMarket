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
<!-- latest_news //-->
<?php
  
  $latest_news_query = smn_db_query('SELECT * from ' . TABLE_LATEST_NEWS . ' WHERE status = 1 ORDER BY date_added DESC LIMIT ' . MAX_DISPLAY_LATEST_NEWS);

  if (!smn_db_num_rows($latest_news_query)) { // there is no news
    echo '<!-- ' . TEXT_NO_LATEST_NEWS . ' -->';
  } else {

    $info_box_contents = array();
    $info_box_contents[] = array('align' => 'left',
                                 'text'  => TABLE_HEADING_LATEST_NEWS);
    new contentBoxHeading($info_box_contents, true, true);

    $info_box_contents = array();
    $row = 0;
    while ($latest_news = smn_db_fetch_array($latest_news_query)) {
      $info_box_contents[$row] = array('align' => 'left',
                                       'params' => 'class="smallText" valign="top"',
                                       'text' => '<b>' . $latest_news['headline'] . '</b> - <i>' . smn_date_long($latest_news['date_added']) . '</i><br>' . nl2br($latest_news['content']) . '<br>');
      $row++;
    }
    new infoBox($info_box_contents);
  }
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => ' '
                              );
  new infoBoxDefault($info_box_contents, true, true);
?>

<!-- latest_news_eof //-->
