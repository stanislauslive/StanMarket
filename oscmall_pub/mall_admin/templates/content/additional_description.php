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
    </tr>
   </table></td>
  </tr>
  <tr>
   <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td valign="top">
              
<?php
if (($_POST['task'] == '')&&($task=='')) {
echo "<FORM name='add' action='$PHP_SELF' method='post'>";
echo "<select name = 'what_info'>";
while (list($key,$value)=each($additional_info_array)) {
echo "<option value='$value'>$value</option>";
}
echo "</select>";
echo "<input type='hidden' name='task' value='gen_entry_form'>";
echo "<input type='submit' name='submit' value='submit'>";

echo "</FORM>";

}

if ($_POST['task']=='gen_entry_form') {

echo "<form name='add2' action='$PHP_SELF' method='post'>";
echo "<input type='hidden' name='task' value='enter_data'>";
if     ($_POST['what_info']== 'CATEGORY' || $_POST['what_info']== 'CATLEVEL') {

$cat_query = "select cd.categories_name object_name,cd.categories_id object_id
                    from ".TABLE_CATEGORIES_DESCRIPTION." cd,
                   ".TABLE_LANGUAGES." l
               where 1=1
               and   cd.language_id = l.languages_id
               and   l.directory  = '$language' ";
} elseif ($_POST['what_info']== 'MANUFACTURER') {
$cat_query = "select cd.manufacturers_name object_name,
                     cd.manufacturers_id   object_id
              from ".TABLE_MANUFACTURERS." cd
              where 1=1       ";
}
$cat_result = smn_db_query($cat_query);

echo "<TABLE>";
echo "<tr><th colspan='2'></th>";
while ( $cat_array_first=smn_db_fetch_array($cat_result)) {

echo "<tr><td>".$cat_array_first['object_name']."</td>\n
     <td valign='top'><a href='".$PHP_SELF."?task=prep_edit_form&what_info=$what_info&what_info_id=".$cat_array_first['object_id']."'>
         <img src='includes/languages/".$language."/images/buttons/button_edit.gif' border='0'></a></td></tr>";

}
echo "</table>";
}          

if ($task == 'prep_edit_form') {
   echo "<form name='edit_form' action='$PHP_SELF' method='post'>\n";
  $n = count($languages);
  reset($languages);
  for ($i=0;$i<$n;$i++) {

  $additional_info_query_raw = "SELECT add_desc_id,
			context,
			context_value,
			additional_description,
			language,
			sort_order 
	FROM ".TABLE_ADD_INFO." where context='$what_info'
             and    context_value='$what_info_id'
             and    language = '".$languages[$i]['directory']."'
             order by sort_order,language  ";
 

  $additional_info_query = smn_db_query($additional_info_query_raw);
  
  if (mysql_num_rows($additional_info_query) =='1') { $action = 'update'; } 
  else {  $action ='insert' ; }
  
  $additional_info = smn_db_fetch_array($additional_info_query); 
echo "<input type='hidden' name='action[]' value='$action'>\n";
  echo smn_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']);
  echo "<br>\n"; 
  echo  smn_draw_textarea_field('description[]', 'soft', '70', '10',$additional_info['additional_description'] );
  echo "<input type='hidden' name='lang[]' value='".$languages[$i]['directory']."'><br>\n";
      }


 echo "<input type='hidden' name='context' value='$what_info'>\n";
 echo "<input type='hidden' name='context_value'  value='$what_info_id'>\n";
 echo "<input type='submit' name='submit' value='submit'>\n";
 echo "<input type='hidden' name='task' value='process_edit'>\n";
 
 echo "</form>\n";
}

if ($_POST['task']=='process_edit') {

    $n_action = count($_POST['action']);
    reset ( $_POST['action']);
      for  ($ia=0;$ia<$n_action;$ia++) {
  
    $add_text = $_POST['description'][$ia];
    //   $add_text = nl2br($add_text);
    $add_language =  $_POST['lang'][$ia];
    
     if ($_POST['action'][$ia] == 'insert') {
                      $sql = "insert into ".TABLE_ADD_INFO." 
                 (add_desc_id ,context,context_value,additional_description,language,sort_order)
     values ('','".$_POST['context']."','".$_POST['context_value']."','".$add_text."','$add_language','0') ";
      } elseif ($_POST['action'][$ia] == 'update') {
    $sql = "update ".TABLE_ADD_INFO." 
    set additional_description = '$add_text'
    where context = '".$_POST['context']."'
    and   context_value = '".$_POST['context_value']."'
    and   language = '$add_language' ";
         }
//echo $sql;	
$ress = smn_db_query($sql);
  }
if (!mysql_error()) { echo ICON_SUCCESS; } 
 else { echo ICON_ERROR; }

  
}
   
   echo '     </td>' . "\n";
  
?>
    </tr>
   </table></td>
  </tr>
 </table>