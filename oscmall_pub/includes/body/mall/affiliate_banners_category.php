<?php
/*
  $Id: affiliate_banner_category.php,v 2.00 2003/10/12

  OSC-Affiliate

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
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
        </table>
	</td>
      </tr>
      <tr>
        <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table width="100%" align="center" border="0" cellpadding="0" cellspacing="0"><td>
<?php
  if (smn_db_num_rows($affiliate_banners_values)) {

    while ($affiliate_banners = smn_db_fetch_array($affiliate_banners_values)) {
      $affiliate_categories_query = smn_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $affiliate_banners['affiliate_category_id'] . "' and language_id = '" . $languages_id . "'");
      $affiliate_categories = smn_db_fetch_array($affiliate_categories_query);
      $prod_id = $affiliate_banners['affiliate_category_id'];
      $ban_id = $affiliate_banners['affiliate_banners_id'];
      switch (AFFILIATE_KIND_OF_BANNERS) {
        case 1: // Link to Categories
          if ($prod_id > 0) {
            $link = '<a href="' . HTTPS_SERVER . DIR_WS_CATALOG . FILENAME_CATEGORIES_INFO . '?ref=' . $affiliate_id . '&cPath=' . $prod_id . '&affiliate_banner_id=' . $ban_id . '" target="_blank"><img src="' . HTTPS_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $affiliate_banners['affiliate_banners_image'] . '" border="0" alt="' . $affiliate_categories['categories_name'] . '"></a>';
            $link1 = '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_CATEGORIES_INFO . '?ref=' . $affiliate_id . '&cPath=' . $prod_id . '&affiliate_banner_id=' . $ban_id . '" target="_blank"><img src="' . HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $affiliate_banners['affiliate_banners_image'] . '" border="0" alt="' . $affiliate_categories['categories_name'] . '"></a>';
            $link2 = '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_CATEGORIES_INFO . '?ref=' . $affiliate_id . '&cPath=' . $prod_id . '&affiliate_banner_id=' . $ban_id . '" target="_blank">' . $affiliate_categories['categories_name'] . '</a>';
			}
          break;
        case 2: // Link to Categories
          if ($prod_id > 0) {
            $link = '<a href="' . HTTPS_SERVER . DIR_WS_CATALOG . FILENAME_CATEGORIES_INFO . '?ref=' . $affiliate_id . '&cPath=' . $prod_id . '&affiliate_banner_id=' . $ban_id . '" target="_blank"><img src="' . HTTPS_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_SHOW_BANNER . '?ref=' . $affiliate_id . '&affiliate_banner_id=' . $ban_id . '" border="0" alt="' . $affiliate_categories['categories_name'] . '"></a>';
            $link1 = '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_CATEGORIES_INFO . '?ref=' . $affiliate_id . '&cPath=' . $prod_id . '&affiliate_banner_id=' . $ban_id . '" target="_blank"><img src="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_SHOW_BANNER . '?ref=' . $affiliate_id . '&affiliate_banner_id=' . $ban_id . '" border="0" alt="' . $affiliate_categories['categories_name'] . '"></a>';
            $link2 = '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_CATEGORIES_INFO . '?ref=' . $affiliate_id . '&cPath=' . $prod_id . '&affiliate_banner_id=' . $ban_id . '" target="_blank">' . $affiliate_categories['categories_name'] . '</a>';
			}
          break;
      }

          if ($prod_id > 0) {
?>
        <table width="95%" align="center" border="0" cellpadding="4" cellspacing="0" class="infoBoxContents">
          <tr>
            <td class="infoBoxHeading" align="center"><?php echo TEXT_AFFILIATE_NAME; ?>&nbsp;<?php echo $affiliate_banners['affiliate_banners_title']; ?></td>
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
            <td>&nbsp;<td> 
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

<?php }
}
}
?>
          </table>
	 </td>
      </tr>
     </table>