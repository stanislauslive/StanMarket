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
       <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
         <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
         <td align="right"><?php echo smn_image(DIR_WS_IMAGES . 'affiliate_links.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
        </tr>
	    <tr>
         <td colspan=2 class="main"><?php echo TEXT_INFORMATION; ?></td>
        </tr>
       </table></td>
      </tr>
      <tr>
       <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
       <td><table width="95%" align="center" border="0" cellpadding="4" cellspacing="0"><td>
        <tr>
         <td class="infoBoxHeading" align="center"><?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER . ' ' . $affiliate_banners['affiliate_banners_title']; ?></td>
        </tr>
        <tr>
         <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <tr>
         <td class="smallText" align="center"><?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER_INFO . smn_draw_form('individual_banner', smn_href_link(FILENAME_AFFILIATE_BANNERS_BUILD_CAT) ) . "\n" . smn_draw_input_field('individual_banner_id', '', 'size="5"') . "&nbsp;&nbsp;" . smn_image_submit('button_affiliate_build_a_link.gif', IMAGE_BUTTON_BUILD_A_LINK); ?></form></td>
        </tr>
        <tr>
         <td class="smallText" align="center"><?php echo '<a href="javascript:popupWindow(\'' . smn_href_link(FILENAME_AFFILIATE_VALIDCATS) . '\')"><b>' . TEXT_AFFILIATE_VALIDCATS . '</b></a>'; ?>&nbsp;&nbsp;<?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER_VIEW;?><br><?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER_HELP;?></td>
        </tr>
        <tr>
         <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
<?php
  if (smn_not_null($HTTP_POST_VARS['individual_banner_id']) || smn_not_null($HTTP_GET_VARS['individual_banner_id'])) {

    if (smn_not_null($HTTP_POST_VARS['individual_banner_id'])) $individual_banner_id = $HTTP_POST_VARS['individual_banner_id'];
    if ($HTTP_GET_VARS['individual_banner_id']) $individual_banner_id = $HTTP_GET_VARS['individual_banner_id'];
    $affiliate_pbanners_values = smn_db_query("select c.categories_image, cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $individual_banner_id . "' and cd.categories_id = '" . $individual_banner_id . "' and cd.language_id = '" . $languages_id . "'");
    if ($affiliate_pbanners = smn_db_fetch_array($affiliate_pbanners_values)) {
      switch (AFFILIATE_KIND_OF_BANNERS) {
        case 1:
   			$link = '<a href="' . HTTPS_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank"><img src="' . HTTPS_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $affiliate_pbanners['affiliate_banners_image'] . '" border="0" alt="' . $affiliate_pbanners['categories_name'] . '"></a>';
   			$link1 = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank"><img src="' . HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $affiliate_pbanners['affiliate_banners_image'] . '" border="0" alt="' . $affiliate_pbanners['categories_name'] . '"></a>';
   			$link2 = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank">' . $affiliate_pbanners['categories_name'] . '</a>'; 
   		break; 
  		case 2: 
   // Link to Products 
   			$link = '<a href="' . HTTPS_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank"><img src="' . HTTPS_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_SHOW_BANNER . '?ref=' . $affiliate_id . '&affiliate_pbanner_id=' . $individual_banner_id . '" border="0" alt="' . $affiliate_pbanners['categories_name'] . '"></a>';
   			$link1 = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank"><img src="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_SHOW_BANNER . '?ref=' . $affiliate_id . '&affiliate_pbanner_id=' . $individual_banner_id . '" border="0" alt="' . $affiliate_pbanners['categories_name'] . '"></a>';
   			$link2 = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank">' . $affiliate_pbanners['categories_name'] . '</a>'; 
   		break; 
     } 
} 
?>
      <tr>
        <td><table width="100%" align="center" border="0" cellpadding="4" cellspacing="0" class="infoBoxContents">
          <tr>
            <td class="infoBoxHeading" align="center"><?php echo TEXT_AFFILIATE_NAME; ?>&nbsp;<?php echo $affiliate_pbanners['categories_name']; ?></td>
          </tr>
          <tr>
            <td class="smallText" align="center"><?php echo $link; ?></td> 
          </tr> 
          <tr> 
            <td class="smallText" align="center"><?php echo TEXT_AFFILIATE_INFO; ?></td> 
          </tr> 
          <tr> 
            <td class="smallText" align="center"> 
             <textarea cols="60" rows="4" class="boxText"><?php echo $link1; ?></textarea> 
            </td> 
          </tr> 
          <tr> 
            <td><td> 
          </tr> 
          <tr> 
            <td class="smallText" align="center"><b>Text Version:</b> <?php echo $link2; ?></td> 
          </tr> 
          <tr> 
            <td class="smallText" align="center"><?php echo TEXT_AFFILIATE_INFO; ?></td> 
          </tr> 
          <tr> 
            <td class="smallText" align="center"> 
             <textarea cols="60" rows="3" class="boxText"><?php echo $link2; ?></textarea> 
            </td> 
          </tr>
          </table>
<?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?>
<?php
}
?>
	 </td></tr>
	 </td>
      </tr></table>
	 </td>
      </tr>	
     </table>