<?php
 if (isset($_POST['feedback']) && !empty($_POST['feedback'])){
    mail('sales@systemsmanager.net', 'Feedback about osC-Mall admin', addslashes($_POST['feedback']));
    echo 'Input sent.<br>You\'re input is greatly appreciated.<br>You can close this window and the feedback popup window.<br>Thank you, <br> Systemsmanager.net Development Team';
    exit;
 }
?>