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
      <tr>
        <td>
         <table border="0" width="90%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_articles.gif', NAVBAR_TITLE); ?></td>
          </tr>
         </table>
        </td>
      </tr>
      
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

          <tr>
        <td>
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => HEADER_TITLE);
  new infoBoxModuleHeading($info_box_contents, true, true);
  $box_contents = array();
if  (!isset($_GET ['page_id']))
{
  while ($page_list_query = smn_db_fetch_array($page_query))
    {
    $box_contents[] = array('text' => '<a href="' .  smn_href_link(FILENAME_ARTICLES, 'page_id=' . $page_list_query['page_id'] . '&type=' . $page_name) . '">' . nl2br($page_list_query['page_title']). '</a><br>'); 
   }	  
  new infoBox($box_contents);  
}
if (isset($_GET ['page_id']))
{

  $info_box_contents = array();
  $info_box_contents[] = array('text' => TEXT_BODY);
  new infoBox($info_box_contents);
}
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => ' ');
  new infoBoxModuleDefault($info_box_contents, true, true);
?>
        </td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right">
                <?php if (isset($_GET ['page_id'])) {echo '<a href="' . smn_href_link(FILENAME_ARTICLES, 'type=' . $page_name) . '">' . smn_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>';      
                        }else{  echo '<a href="' . smn_href_link(FILENAME_DEFAULT) . '">' . smn_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>';} ?>
                    </td>
                <td width="10"><?php echo smn_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
    </table>