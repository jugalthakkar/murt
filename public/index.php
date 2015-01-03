<?php
require_once ("includes/initialize.php");
require_once ('includes/HitCounter.php');
require_once("includes/meta.php");
require_once("includes/exams.php");

?><!DOCTYPE html>
<html>
    <head>
        <!-- Standard Meta -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- Site Properities -->
        <title>Mumbai University Result Tracker</title>        
        <!--        <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700" rel="stylesheet" type="text/css" />-->
        <link rel="stylesheet" type="text/css" href="css/semantic.css" />
        <link rel="stylesheet" type="text/css" href="css/homepage.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css?ts=<?php echo time(); ?>" />
    </head>
    <body id="home">
        <div id="murt-app">
            <div id="noJs">
                <div class="ui bottom attached negative message" id="resultError">
                    <div class="header">
                        <i class="warning sign icon"></i> Error
                    </div>
                    <p>Please Enable Javascript</p>
                </div>
            </div>        
        </div>
        <script type="text/javascript">
            var element = document.getElementById("noJs");
            element.parentNode.removeChild(element);
        </script>
        <input type="hidden" name="hitCount" id="hitCount" value="<?php echo HitCounter::getTotalHits();//TODO     ?>" />
        <input type="hidden" id="androidDownloadCount" value="<?php echo meta::getValue("apk_download_count"); ?>" />    
        <input type="hidden" id="lastTenResults" value='<?php echo json_encode(exam::GetLatestResultsByCount(10)); ?>' />
        <input type="hidden" id="WEB_ROOT" value='<?php echo WEB_ROOT; ?>' />


        <?php require_once('handleBarTemplates.php'); ?>
        <script src="js/libs/jquery-1.11.2.js"></script>
        <script src="js/libs/semantic.js"></script>

        <script>jQuery('script[type="text/html"]').attr('type', 'text/x-handlebars');</script>
        <script src="js/libs/handlebars-v2.0.0.js"></script>
        <script src="js/libs/ember-1.9.js"></script>
        <script src="js/libs/moment.min.js"></script>
        <script src="js/app.js"></script>

        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=157208214292583&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <script>!function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + '://platform.twitter.com/widgets.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, 'script', 'twitter-wjs');</script>

                <!-- <script src="js/homepage.js"></script> -->
    </body>

</html>
