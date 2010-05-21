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
?>
<table width="100%" cellpadding="5" cellspacing="0" border=0>
    <tr>
     <td class="formAreaTitle" width=50% valign="top" align="right">
<?php
$mainpage_title = '<i>Welcome to the oscMall System</i>';
$mainpage_info = '
<p><big>We specialize in development using the<br><br><center><b>World Class Software Project OScommerce</b>.</center><br><br>
We want you to succeed in your goals for On Line Services.  If you are selling products, or services our E-commerce
solution is the <b>right answer</b> for your business. With our proven systems <b>Your Businesses</b> will be up and operational in a short period of time.
<p>

We are a company that thinks out of the box.  We believe in <b>Progressive Business Practices</b> and match our programming to meet these goals. 
If you have an idea and want to see it forward, we are here to help you foster and build your idea into reality. 
<br><br>With sound business knowledge and diversified technical expertise, we can show you how easy it is to for your firm to use e-commerce to <b>increase your business profits</b>. <p> 

Currently we are using our software project<b> The oscMall System </b>to run this entire site. This site is a sample of what we can offer your business.
Like what you see?  Need something different?  <br><br>Contact Us
for further information, and we will be happy to provide the answers to your questions.  We Look forward to a mutually
beneficial relationship with our clients.</big>
 <BR><BR></tr><tr align = "center"><td><b>This Site is Powered by the :</b> <br><br><a href="http://www.systemsmanager.net">' . smn_image(DIR_WS_IMAGES . 'oscMall.gif') .'</a> </td></tr><tr align = "center">
</tr>';


  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => $mainpage_title );
  new infoBoxModuleHeading($info_box_contents, true, true);

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => $mainpage_info);
new infoBox($info_box_contents);

$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => ' '
                              );
  new infoBoxModuleDefault($info_box_contents, true, true);
?>

</td>
<TR>
</table>
<!-- MAIN PAGE EXAMPLE END //-->
