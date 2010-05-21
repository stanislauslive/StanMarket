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

 echo smn_draw_form('advanced_search', smn_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'post', 'onSubmit="return check_form(this);"') . smn_hide_session_id(); ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><?php echo HEADING_SEARCH_CRITERIA; ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($messageStack->size('search') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('search'); ?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
        <td><?php echo smn_draw_input_field('keywords', '', 'style="width: 100%"') .  smn_draw_checkbox_field('search_in_description', '1') . ' ' . TEXT_SEARCH_IN_DESCRIPTION;?></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText"><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_POPUP_SEARCH_HELP) . '\')">' . TEXT_SEARCH_HELP_LINK . '</a>'; ?></td>
            <td class="smallText" align="right"><?php echo smn_image_submit('button_search.gif', IMAGE_BUTTON_SEARCH); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="fieldKey"><?php echo ENTRY_CATEGORIES; ?></td>
                <td class="fieldValue"><?php echo smn_draw_pull_down_menu('categories_id', smn_get_categories_extended(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES)))); ?></td>
              </tr>
              <tr>
                <td class="fieldKey">&nbsp;</td>
                <td class="smallText"><?php echo smn_draw_checkbox_field('inc_subcat', '1', true) . ' ' . ENTRY_INCLUDE_SUBCATEGORIES; ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
<!-- systemsmanager begin
              <tr>
                <td class="fieldKey"><?php echo ENTRY_MANUFACTURERS; ?></td>
                <td class="fieldValue"><?php echo smn_draw_pull_down_menu('manufacturers_id', smn_get_manufacturers(array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS)))); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
-- systemsmanager end -->
              <tr>
                <td class="fieldKey"><?php echo ENTRY_PRICE_FROM; ?></td>
                <td class="fieldValue"><?php echo smn_draw_input_field('pfrom'); ?></td>
              </tr>
              <tr>
                <td class="fieldKey"><?php echo ENTRY_PRICE_TO; ?></td>
                <td class="fieldValue"><?php echo smn_draw_input_field('pto'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
              <tr>
                <td class="fieldKey"><?php echo ENTRY_DATE_FROM; ?></td>
                <td class="fieldValue"><?php echo smn_draw_input_field('dfrom', DOB_FORMAT_STRING, 'onFocus="RemoveFormatString(this, \'' . DOB_FORMAT_STRING . '\')"'); ?></td>
              </tr>
              <tr>
                <td class="fieldKey"><?php echo ENTRY_DATE_TO; ?></td>
                <td class="fieldValue"><?php echo smn_draw_input_field('dto', DOB_FORMAT_STRING, 'onFocus="RemoveFormatString(this, \'' . DOB_FORMAT_STRING . '\')"'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></form>
<!-- search_eof //-->
