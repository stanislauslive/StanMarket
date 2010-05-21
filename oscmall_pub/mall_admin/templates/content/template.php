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
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
            
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
            
<?php
if ( $_GET['action'] != 'new')
{
    ?>
              <tr class="dataTableHeadingRow">
                <td align="left" class="dataTableHeadingContent"><?php echo TABLE_HEADING_TEMPLATE. '<br><br>' .TABLE_HEADING_TEMPLATE_ID;?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_TEMPLATE_NAME; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_THEMA; ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?></td>
              </tr>
<?php
    while ($template = smn_db_fetch_array($template_query)) {
      if (((!$_GET['tID']) || (@$_GET['tID'] == $template['template_id'])) && (!$tInfo) && (substr($_GET['action'], 0, 3) != 'newTheme')) {
        $tInfo = new objectInfo($template);
      }

      if ( (is_object($tInfo)) && ($template['template_id'] == $tInfo->template_id) ){
        echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEMPLATE,  'tID='  . $template['template_id'] . '&action=select') . '\'">' . "\n";
      }else{
        echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . smn_href_link(FILENAME_TEMPLATE, 'tID=' . $template['template_id']) .  '\'">' . "\n";
      }
      
?>
                <td class="dataTableContent" align="left"><?php echo number_format($template['template_id']); ?></td>
                <td align="left" class="dataTableContent"><?php echo '<a href="' . smn_href_link(FILENAME_TEMPLATE,  'tID=' . $template['template_id'].'&action=preview'). '">' . smn_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $template['template_name']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $template['thema'];?></td>
		<td class="dataTableContent" align="left"><?php if((int)$template['template_id'] == TEMPLATE_ID){ echo TEXT_IN_USE; }else{echo TEXT_NOT_IN_USE;} ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($tInfo)) && ($tInfo->template_id == $template['template_id']) ) { echo smn_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . smn_href_link(FILENAME_TEMPLATE, 'tID=' . $template['template_id']) . '">' . smn_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?></td>
              </tr>
 <?php
    }
  }
  if ( $_GET['action'] == 'new'){
?>
  <tr class="dataTableHeadingRow">
    <td align="center" class="dataTableHeadingContent"><?php echo TABLE_HEADING_NEW_TEMPLATE;?></td>
  </tr>
  <tr class="dataTableHeadingRow">
    <td class="dataTableContent" align="left"><?php echo TABLE_HEADING_NEW_TEMPLATE_INSTRUCTIONS;?></td>
  </tr>
<?php
    }
?>
                </table></td>

<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) 
  {
    case 'delete':
      $heading[] = array('text' => '&nbsp;&nbsp;<br><b>' . $tInfo->template_id . '</b><br>&nbsp;&nbsp;');
	  
 	  $contents = array('form' => smn_draw_form('template', FILENAME_TEMPLATE,  'tID='   . $tInfo->template_id . '&action=newThema'));
	  $contents[] = array('text' => '<br><b>' . $tInfo->template_id . '</b>');
	  $contents[] = array('text' => TEXT_DELETE);
      $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_default.gif', IMAGE_DEFAULT) . ' <a href="' . smn_href_link(FILENAME_TEMPLATE,  'tID='   . $_GET['tID']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
     
	  break;
    case 'new':
      $heading[] = array('text' => '<b>' . $tInfo->template_id . '</b>'); 
      $contents = array('form' => smn_draw_form('insert_template', FILENAME_TEMPLATE,  'tID='   . $_GET['tID'] . '&action=insert', 'post'));
      $contents[] = array('text' => '<br>' . smn_draw_input_field('template_name', '', 'size="30"') . '</b>');
      $contents[] = array('text' => TEXT_NEW_TEMPLATE);
      $contents[] = array('align' => 'center', 'text' => '<br>' . smn_image_submit('button_insert.gif', IMAGE_INSERT) . ' <a href="' . smn_href_link(FILENAME_TEMPLATE,  'tID='   . $_GET['tID']) . '">' . smn_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
     
	  break;
    default:
      if (is_object($tInfo)) 
      {
        $heading[] = array('text' => '&nbsp;&nbsp;<br><b>&nbsp;&nbsp;Editing ' . $tInfo->template_name .' template</b><br>&nbsp;&nbsp;');
        $contents[] = array('align' => 'left',
                            'text'  =>  '<br><b>&nbsp;&nbsp;Select As Site Thema</b><br><br>');
        
	$buttons = '<br><a href="' . smn_href_link(FILENAME_TEMPLATE,  'tID='   . $tInfo->template_id . '&action=update') . '">' . smn_image_button('button_select.gif', IMAGE_SELECT) . '</a>&nbsp;&nbsp;';
	if($store_id == 1) {
	  $buttons .= '<a href="' . smn_href_link(FILENAME_TEMPLATE,  'tID='   . $tInfo->template_id . '&action=new') . '">' . smn_image_button('button_insert_template.gif', IMAGE_INSERT) . '</a><br><br>';
	}
        $contents[] = array('align' => 'left', 'text' => $buttons);
        if ($tInfo->template_id == TEMPLATE_ID){
                $contents[] = array('text' => '</form><br><br>&nbsp;&nbsp;' .$tInfo->template_name .' is the Default template<br><br>');
        } else{
               $contents[] = array('text' => '</form><br><br>&nbsp;&nbsp;'.$tInfo->template_name .' is <b>not</b> the Default template<br><br>');
        }
      }
      break;
  }
  if ( (smn_not_null($heading)) && (smn_not_null($contents)) ) 
  {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
			</td>
          </tr>
        </table></td>
      </tr>
    </table>