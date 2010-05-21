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

if (isset($_GET['action']))
{
switch ($_GET['action'])
{
    
    case 'add_quck_pick_name':
    {
    $quick_pick_box_display = smn_get_quick_pick_list($customer_id);            
    $quick_pick_box_display['form'] =   smn_draw_form('quick_pick_name',  smn_href_link(basename($PHP_SELF),'action=add_quck_pick', 'NONSSL', false), 'post');
    $quick_pick_box_display['text'] .=  '<br><b>Order Name<br></b>';
    $quick_pick_box_display['text'] .=  smn_draw_input_field('quick_pick_name', '', 'size="10"') . '&nbsp;&nbsp;' . smn_image_submit('button_submit.gif', BOX_HEADING_TELL_A_FRIEND) .  smn_hide_session_id() . '<br>';   
    }
    break;
    case 'add_quck_pick':
    {
    $products = $cart->get_products();
    $quick_pick_add = smn_add_quick_pick($products, $_POST['quick_pick_name']);
    if ($quick_pick_add == 'true')
    {
    $quick_pick_box_display = smn_get_quick_pick_list($customer_id);
    $quick_pick_box_display['form'] =  smn_draw_form('quick_pick',  smn_href_link(basename($PHP_SELF),'action=show_saved_order', 'NONSSL', false), 'post');
    $quick_pick_box_display['text'] .=  '<b>Success!<br></b>';
    }else{
    $quick_pick_box_display = smn_get_quick_pick_list($customer_id);
    $quick_pick_box_display['form'] =  smn_draw_form('quick_pick',  smn_href_link(basename($PHP_SELF),'action=show_saved_order', 'NONSSL', false), 'post');
    $quick_pick_box_display['text'] .=  '<b>You Have reached the limit<br> for Quick Picks in your list.<br> Please delete one first<br></b>';
    }
    }
    break;
    case 'delete_quck_pick':
    {
    $quick_pick_box_display = smn_remove_quick_pick($_GET['saved_order_id']);
    $quick_pick_box_display = smn_get_quick_pick_list($customer_id);
    $quick_pick_box_display['form'] =  smn_draw_form('quick_pick',  smn_href_link(basename($PHP_SELF),'action=show_saved_order', 'NONSSL', false), 'post');
    $quick_pick_box_display['text'] .=  '<b>Success!<br></b>';
    if ($cart->count_contents() > 0)
        {
        $quick_pick_box_display['text'] .= '<br><a href="' . smn_href_link(basename($PHP_SELF),'action=add_quck_pick_name', 'NONSSL') . '">' . smn_image_button('button_add_now.gif', IMAGE_ADD_NOW). '</a> ';
        }
    }
    break;
    case 'show_saved_order':
    {
    $quick_pick_box_display = smn_get_quick_pick_list($customer_id);
    $quick_pick_box_show_saved_order = smn_get_quick_pick($_POST['quick_pick']);
    $quick_pick_box_display['form'] =  smn_draw_form('quick_pick',  smn_href_link(basename($PHP_SELF),'action=show_saved_order', 'NONSSL', false), 'post');
    $quick_pick_box_display['text'] .=  '<br>' . $quick_pick_box_show_saved_order['text'];
    $quick_pick_box_display['text'] .= '<br><a href="' . smn_href_link(basename($PHP_SELF),'action=in_cart_quick_pick&saved_order_id='.$_POST['quick_pick'], 'NONSSL') . '">' . smn_image_button('button_buy_now.gif', IMAGE_BUY_NOW) . '</a> ';
    $quick_pick_box_display['text'] .= '<a href="' . smn_href_link(basename($PHP_SELF),'action=delete_quck_pick&saved_order_id='.$_POST['quick_pick'], 'NONSSL') . '">' . smn_image_button('button_delete.gif', IMAGE_BUY_NOW). '</a> ';

    }
    break;
    default:
    {
    $quick_pick_box_display = smn_get_quick_pick_list($customer_id);
    if ($cart->count_contents() > 0)
    {
        $quick_pick_box_display['text'] .= '<br><a href="' . smn_href_link(basename($PHP_SELF),'action=add_quck_pick_name', 'NONSSL') . '">' . smn_image_button('button_add_now.gif', IMAGE_ADD_NOW). '</a> ';
        $quick_pick_box_display['form'] =  smn_draw_form('quick_pick',  smn_href_link(basename($PHP_SELF),'action=show_saved_order', 'NONSSL', false), 'post');
    }
    }
    break;
  }
}else{
    $quick_pick_box_display = smn_get_quick_pick_list($customer_id);
    if ($cart->count_contents() > 0)
    {
        $quick_pick_box_display['text'] .= '<br><a href="' . smn_href_link(basename($PHP_SELF),'action=add_quck_pick_name', 'NONSSL') . '">' . smn_image_button('button_add_now.gif', IMAGE_ADD_NOW). '</a> ';
        $quick_pick_box_display['form'] =  smn_draw_form('quick_pick',  smn_href_link(basename($PHP_SELF),'action=show_saved_order', 'NONSSL', false), 'post');
    }
}
?>
<!-- store_categories //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_QUICK_PICK);
  new infoBoxHeading($info_box_contents, true, true);
  $info_box_contents = array();
  
  $info_box_contents[] = $quick_pick_box_display;
  new infoBox($info_box_contents);
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => ' '
                              );
  new infoBoxDefault($info_box_contents, true, true);
?>
            </td>
          </tr>
<!-- store_categories_eof //-->
