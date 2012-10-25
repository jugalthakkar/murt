<?php
require_once("../includes/initialize.php");
require_once("../includes/meta.php");
$downloadCount=meta::getByKey("apk_download_count");
//echo ($downloadCount->MetaValue);
$downloadCount->MetaValue++;
$downloadCount->save();
header('Content-type: application/vnd.android.package-archive');
header('Content-Disposition: attachment; filename="Mumbai_University_Result_Tracker_Beta.apk"');
readfile('Mumbai_University_Result_Tracker_Beta.apk');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
