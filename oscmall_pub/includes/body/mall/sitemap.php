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
      <li><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT, 'ID=1', 'SSL') . '">' . PAGE_ACCOUNT . '</a>'; ?></li>
       <ul>
        <li><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT_EDIT, 'ID=1', 'SSL') . '">' . PAGE_ACCOUNT_EDIT . '</a>'; ?></li>
        <li><?php echo '<a href="' . smn_href_link(FILENAME_ADDRESS_BOOK, 'ID=1', 'SSL') . '">' . PAGE_ADDRESS_BOOK . '</a>'; ?></li>
        <li><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT_HISTORY, 'ID=1', 'SSL') . '">' . PAGE_ACCOUNT_HISTORY . '</a>'; ?></li>
        <li><?php echo '<a href="' . smn_href_link(FILENAME_ACCOUNT_NEWSLETTERS, 'ID=1', 'SSL') . '">' . PAGE_ACCOUNT_NOTIFICATIONS . '</a>'; ?></li>
       </ul>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_SHOPPING_CART, 'ID=1') . '">' . PAGE_SHOPPING_CART . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_CHECKOUT_SHIPPING, 'ID=1', 'SSL') . '">' . PAGE_CHECKOUT_SHIPPING . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_ADVANCED_SEARCH, 'ID=1') . '">' . PAGE_ADVANCED_SEARCH . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_PRODUCTS_NEW, 'ID=1') . '">' . PAGE_PRODUCTS_NEW . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_SPECIALS, 'ID=1') . '">' . PAGE_SPECIALS . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_REVIEWS, 'ID=1') . '">' . PAGE_REVIEWS . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_SHIPPING, 'ID=1') . '">' . BOX_INFORMATION_SHIPPING . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_PRIVACY, 'ID=1') . '">' . BOX_INFORMATION_PRIVACY . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_CONDITIONS, 'ID=1') . '">' . BOX_INFORMATION_CONDITIONS . '</a>'; ?></li>
       <li><?php echo '<a href="' . smn_href_link(FILENAME_CONTACT_US, 'ID=1') . '">' . BOX_INFORMATION_CONTACT . '</a>'; ?></li>
      </ul></td>
     </tr>
    </table></td>
   </tr>
  </table>