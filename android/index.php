<?php
require_once("../includes/initialize.php");
require_once("../includes/PageSections.php");
require_once("../includes/meta.php");
spitPageHeader("Android"); ?>
<p class="highlight-3"><a href="downloadApk.php"><strong>Download .apk HERE</strong></a>. Downloaded <strong><?php echo meta::getByKey("apk_download_count")->MetaValue;?></strong> times</p>
<p class="highlight-1">This a beta version. There may be few bugs. If you find any you can report them on our <a href="http://facebook.com/muresults/">facebook page</p>
<h3>More on android app @ <a href="http://www.facebook.com/media/set/?set=a.379651982054589.92345.149360911750365">Facebook</a></h3>

<h3>Screenshots</h3>
<img src="ss2.png" style="width: 450px" alt="Screenshot 1" /> <br />
<img src="ss1.png" style="width: 450px" alt="Screenshot 2" /><br />
<?php spitPageFooter(); ?>       
<?php
$database->close_connection();
ob_end_flush();
?>