<?php
/*
  $Id: gv_admin.php,v 1.2.2.1 2003/04/18 21:13:51 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Gift Voucher System v1.0
  Copyright (c) 2001,2002 Ian C Wilson
  http://www.phesis.org

  Released under the GNU General Public License
*/

  $menu->addMenuBlock(array(
      'heading' => BOX_HEADING_GV_ADMIN,
      'children' => array(
          $store->smn_admin_files_boxes(FILENAME_COUPON_ADMIN, BOX_COUPON_ADMIN),
          $store->smn_admin_files_boxes(FILENAME_GV_QUEUE, BOX_GV_ADMIN_QUEUE),
          $store->smn_admin_files_boxes(FILENAME_GV_MAIL, BOX_GV_ADMIN_MAIL),
          $store->smn_admin_files_boxes(FILENAME_GV_SENT, BOX_GV_ADMIN_SENT),
          $store->smn_admin_files_boxes(FILENAME_GV_REPORT, BOX_GV_ADMIN_REPORT)
      )
  ));
?>