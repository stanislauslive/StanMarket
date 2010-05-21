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
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
  if ($_GET['action'] == 'new_affiliate_news') { //insert or edit a news item
    if ( isset($_GET['affiliate_news_id']) ) { //editing exsiting news item
	/*Changed the query to take details from affiliate_news_contents table, by Cimi*/
      /*$affiliate_news_query = smn_db_query("select news_id, headline, content from " . TABLE_AFFILIATE_NEWS . " where news_id = '" . $_GET['affiliate_news_id'] . "'");*/
      $affiliate_news_query = smn_db_query("select an.news_id, anc.affiliate_news_headlines, anc.affiliate_news_contents, an.news_status from " . TABLE_AFFILIATE_NEWS ." an," . TABLE_AFFILIATE_NEWS_CONTENTS. " anc where an.news_id=anc.affiliate_news_id and news_id = '" . $_GET['affiliate_news_id'] . "'");
      $affiliate_news = smn_db_fetch_array($affiliate_news_query);
    } else { //adding new news item
      $affiliate_news = array();
    }
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo TEXT_NEW_AFFILIATE_NEWS; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo smn_draw_form('new_affiliate_news', FILENAME_AFFILIATE_NEWS, isset($_GET['affiliate_news_id']) ? 'affiliate_news_id=' . $_GET['affiliate_news_id'] . '&action=update_affiliate_news' : 'action=insert_affiliate_news', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_AFFILIATE_NEWS_HEADLINE; ?></td>
			<!--Changed the array index headline to affiliate_news_headlines,By Cimi -->
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_input_field('headline', $affiliate_news['affiliate_news_headlines'], '', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_AFFILIATE_NEWS_CONTENT; ?></td>
			<!--Changed the array index content to affiliate_news_contents,By Cimi -->
            <td class="main"><?php echo smn_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . smn_draw_textarea_field('content', 'soft', '70', '15', stripslashes($affiliate_news['affiliate_news_contents'])); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
          <?php
            isset($_GET['affiliate_news_id']) ? $cancel_button = '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'affiliate_news_id=' . $_GET['affiliate_news_id']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>' : $cancel_button = '';
            echo smn_image_submit('button_insert.gif', IMAGE_INSERT) . $cancel_button;
          ?>
        </td>
      </form></tr>
<?php

  } else {
?>
      <tr>
        <td>
          <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            </tr>
          </table>
        </td>
      </tr>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AFFILIATE_NEWS_HEADLINE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_AFFILIATE_NEWS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_AFFILIATE_NEWS_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;

    $affiliate_news_count = 0;
	/*Changed the query to take details from affiliate_news_contents table, by Cimi*/
    /*$affiliate_news_query = smn_db_query('select news_id, headline, content, status from ' . TABLE_AFFILIATE_NEWS . ' order by date_added desc');*/
    $affiliate_news_query = smn_db_query('select an.news_id, anc.affiliate_news_headlines, anc.affiliate_news_contents, an.news_status from ' . TABLE_AFFILIATE_NEWS . ' an,' . TABLE_AFFILIATE_NEWS_CONTENTS. ' anc where an.news_id=anc.affiliate_news_id order by an.date_added desc');
    
    while ($affiliate_news = smn_db_fetch_array($affiliate_news_query)) {
      $affiliate_news_count++;
      $rows++;
      
      if ( ((!$_GET['affiliate_news_id']) || (@$_GET['affiliate_news_id'] == $affiliate_news['news_id'])) && (!$selected_item) && (substr($_GET['action'], 0, 4) != 'new_') ) {
        $selected_item = $affiliate_news;
      }
      if ( (is_array($selected_item)) && ($affiliate_news['news_id'] == $selected_item['news_id']) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'affiliate_news_id=' . $affiliate_news['news_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'affiliate_news_id=' . $affiliate_news['news_id']) . '\'">' . "\n";
      }
?>
	<!--Changed the array index headline to affiliate_news_headlines,By Cimi -->
                <td class="dataTableContent"><?php echo '&nbsp;' . $affiliate_news['affiliate_news_headlines']; ?></td>
                <td class="dataTableContent" align="center">
<?php
	/*Changed the array index status to news_status,By Cimi*/
      if ($affiliate_news['news_status'] == '1') {
        echo smn_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'action=setflag&flag=0&affiliate_news_id=' . $affiliate_news['news_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'action=setflag&flag=1&affiliate_news_id=' . $affiliate_news['news_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . smn_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ($affiliate_news['news_id'] == $_GET['affiliate_news_id']) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'affiliate_news_id=' . $affiliate_news['news_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo '<br>' . TEXT_NEWS_ITEMS . '&nbsp;' . $affiliate_news_count; ?></td>
                    <td align="right" class="smallText"><?php echo '&nbsp;<a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'action=new_affiliate_news') . '">' . smn_image_button('button_new_news_item.gif', IMAGE_NEW_NEWS_ITEM) . '</a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete_affiliate_news': //generate box for confirming a news article deletion
        $heading[] = array('text'   => '<b>' . TEXT_INFO_HEADING_DELETE_ITEM . '</b>');
        
        $contents = array('form'    => smn_draw_form('news', FILENAME_AFFILIATE_NEWS, 'action=delete_affiliate_news_confirm') . smn_draw_hidden_field('affiliate_news_id', $_GET['affiliate_news_id']));
        $contents[] = array('text'  => TEXT_DELETE_ITEM_INTRO);
        $contents[] = array('text'  => '<br><b>' . $selected_item['headline'] . '</b>');
        
        $contents[] = array('align' => 'center',
                            'text'  => '<br>' . smn_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'affiliate_news_id=' . $selected_item['news_id']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;

      default:
        if ($rows > 0) {
          if (is_array($selected_item)) { //an item is selected, so make the side box
            $heading[] = array('text' => '<b>' . $selected_item['headline'] . '</b>');

            $contents[] = array('align' => 'center', 
                                'text' => '<a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'affiliate_news_id=' . $selected_item['news_id'] . '&action=new_affiliate_news') . '">' . smn_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . smn_href_link(FILENAME_AFFILIATE_NEWS, 'affiliate_news_id=' . $selected_item['news_id'] . '&action=delete_affiliate_news') . '">' . smn_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
            $contents[] = array('text' => '<br>' . $selected_item['content']);
          }
        } else { // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');

          $contents[] = array('text' => sprintf(TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS, $parent_categories_name));
        }
        break;
    }

    if ( (smn_not_null($heading)) && (smn_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table>