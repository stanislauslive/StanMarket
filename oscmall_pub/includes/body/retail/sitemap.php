 <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
   <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
     <td class="pageHeading" align="right"><?php echo smn_image(DIR_WS_IMAGES . 'table_background_specials.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
    </tr>
   </table></td>
  </tr>
  <tr>
   <td><?php echo smn_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
  </tr>
  <tr>
   <td><table border="0" width="100%" cellspacing="1" cellpadding="2">
    <tr>
     <td width="50%" class="main" valign="top"></td>
     <td width="50%" class="main" valign="top"><ul>
      <li><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT, 'ID=' . $store_id, 'SSL') . '">' . PAGE_ACCOUNT . '</a>'; ?></li>
       <ul>
        <li><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT_EDIT, 'ID=' . $store_id, 'SSL') . '">' . PAGE_ACCOUNT_EDIT . '</a>'; ?></li>
        <li><?php echo '<a href="' . smn_href_link(FILENAME_ADDRESS_BOOK, 'ID=' . $store_id, 'SSL') . '">' . PAGE_ADDRESS_BOOK . '</a>'; ?></li>
        <li><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT_HISTORY, 'ID=' . $store_id, 'SSL') . '">' . PAGE_ACCOUNT_HISTORY . '</a>'; ?></li>
        <li><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT_NEWSLETTERS, 'ID=' . $store_id, 'SSL') . '">' . PAGE_ACCOUNT_NOTIFICATIONS . '</a>'; ?></li>
       </ul>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_SHOPPING_CART, 'ID=' . $store_id) . '">' . PAGE_SHOPPING_CART . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_CHECKOUT_SHIPPING, 'ID=' . $store_id, 'SSL') . '">' . PAGE_CHECKOUT_SHIPPING . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_ADVANCED_SEARCH, 'ID=' . $store_id) . '">' . PAGE_ADVANCED_SEARCH . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_PRODUCTS_NEW, 'ID=' . $store_id) . '">' . PAGE_PRODUCTS_NEW . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_SPECIALS, 'ID=' . $store_id) . '">' . PAGE_SPECIALS . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_REVIEWS, 'ID=' . $store_id) . '">' . PAGE_REVIEWS . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_SHIPPING, 'ID=' . $store_id) . '">' . BOX_INFORMATION_SHIPPING . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_PRIVACY, 'ID=' . $store_id) . '">' . BOX_INFORMATION_PRIVACY . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_CONDITIONS, 'ID=' . $store_id) . '">' . BOX_INFORMATION_CONDITIONS . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_CONTACT_US, 'ID=' . $store_id) . '">' . BOX_INFORMATION_CONTACT . '</a>'; ?></li>
      </ul></td>
     </tr>
    </table></td>
   </tr>
  </table>