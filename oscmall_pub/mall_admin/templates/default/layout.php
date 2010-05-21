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

  if (!isset($_GET['ajaxContent'])){
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
  <title><?php echo TITLE; ?></title>
  <link rel="stylesheet" type="text/css" href="templates/default/stylesheet.css">
  <script language="javascript" src="includes/general.js"></script>
  <?php echo $jQuery->getHeadOutput();?>
  <script language="javascript" type="text/javascript" src="../ext/tinymce/tiny_mce.js"></script>
  <script language="Javascript">
      $(document).ready(function (){
          <?php echo $jQuery->getScriptOutput();?>
          $('#leftColumnDiv').css('width', '217px');

          var newHeight = jQuery(window).height();
          newHeight -= $('#headerTable').height();
          newHeight -= $('#footerTable').height();
          
          $('#contentTable').css('height', newHeight);
          $('#leftColumnDiv').css('height', newHeight);
          $('#contentColumnDiv').css('height', newHeight);
          
          $(window).resize(function (){
              var newHeight = jQuery(window).height();
              newHeight -= $('#headerTable').height();
              newHeight -= $('#footerTable').height();
              
              $('#contentTable').css('height', newHeight);
              $('#leftColumnDiv').css('height', newHeight);
              $('#contentColumnDiv').css('height', newHeight);
          });
          
          $('.pageHeading').each(function (){
              var leftCol = jQuery('<td class="pageHeading_left">&nbsp;</td>');
              var rightCol = jQuery('<td class="pageHeading_right">&nbsp;</td>');
              $(this).parent().prepend(leftCol);
              $(this).parent().append(rightCol);
          });
      });
  </script>
 </head>
 <body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php
      if (!isset($ignoreHeader)){
          echo '<!-- header //-->';
          require(DIR_WS_INCLUDES . 'header.php');
          echo '<!-- header_eof //-->';
      }
?>

<!-- body //-->
  <table border="0" width="100%" cellspacing="0" cellpadding="0" id="contentTable">
   <tr>
<?php   
      if (!isset($ignoreColumn) && JQUERY_MENU == 'accordion_menu'){
          echo '<!-- left_navigation //-->';
          echo '<td valign="top">';
          require(DIR_WS_INCLUDES . 'column_left.php');
          echo '</td>';
          echo '<!-- left_navigation_eof //-->';
      }
?>
<!-- body_text //-->
    <td width="100%" valign="top"><div style="<?php echo (JQUERY_MENU == 'jd_menu' ? 'padding-left:15px;' : '');?>padding-right:15px;overflow:auto" id="contentColumnDiv"><?php
  }
  
  require('templates/content/' . $content_page);
  
  if (!isset($_GET['ajaxContent'])){
    ?></div></td>
<!-- body_text_eof //-->
   </tr>
  </table>
<!-- body_eof //-->

<?php
      if (!isset($ignoreFooter)){
          echo '<!-- footer //-->';
          require(DIR_WS_INCLUDES . 'footer.php');
          echo '<!-- footer_eof //-->';
      }
?>
</body>
</html>
<?php
  }
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>