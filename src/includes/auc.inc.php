<?php
//-------------------------//-------------------------//-------------------------//
//---------------------   Anti-Direct Connection Include   ----------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

if (!preg_match($Allow_AUC,$HTTP_REFERER)){
echo "Unauthorized Connection Detected<br>Referer: $HTTP_REFERER<br>";
echo "IP: $REMOTE_ADDR Logged<br>";
postFooter();
$contents = '/*'."Date: `$CFU_Date' \n Logged Username: `$Pl_Value[USERNAME]' \t\t Logged Password: `$Pl_Value[PASSWORD]'\n";
$contents .= "IP: `$REMOTE_ADDR' \t\t Referer: `$HTTP_REFERER'\n";
$contents .= "REQUEST_METHOD: `$REQUEST_METHOD' \t\t SCRIPT_FILENAME: `$SCRIPT_FILENAME' \nQUERY_STRING: `$QUERY_STRING '\n";
$contents .= '_______________________________________________________';
$contents .= '_______________________________________________________*/'."\n";
$fp = fopen($AUC_Log,"r+");
fwrite($fp,$contents) or die('123');
fclose($fp);
exit;
}
?>