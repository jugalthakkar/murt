<?php
require_once ("../includes/initialize.php");
require_once ("../includes/murtUtilities.php");

if (isset($_GET['_escaped_fragment_']))
{
    require_once("../includes/SnapshotService.php");
    echo SnapshotService::GetSnapshot(urldecode($_GET['_escaped_fragment_']));
    exit;
}
//if ($murtUtilities->isBot($_SERVER['HTTP_USER_AGENT']))
//{
//    $fragment = isset($_GET['_escaped_fragment_']) ? $_GET['_escaped_fragment_'] : '/';
//    require_once("../includes/SnapshotService.php");
//    echo SnapshotService::GetSnapshot(urldecode($fragment));
//    //echo 'BOT DETECTED<br/>'.$fragment;
//    exit;
//}
//if (isset($_GET['_escaped_fragment_']))
//{
//    header("Location: " . WEB_ROOT . "#!" . $_GET['_escaped_fragment_'], TRUE, 301);
//    exit;
//}
require_once ('../includes/HitCounter.php');
require_once("../includes/meta.php");

?><!DOCTYPE html>
<html>
    <head>    
        <!-- Standard Meta -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="fragment" content="!">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="shortcut icon"
              href="<?php echo WEB_ROOT; ?>favicon.ico" />
        <meta name="description" content="Track the latest Mumbai University Results as they happen. We have a history of being faster than the university site.Just Saying!">
        <meta name="canonical" href="<?php echo WEB_ROOT; ?>#!/"/>
        <meta property="og:title" content="Latest Results | Mumbai University Result Tracker | Jugal Thakkar"/>
        <meta property="og:site_name" content="Mumbai University Result Tracker"/>
        <meta property="og:url" content="<?php echo WEB_ROOT; ?>#!/"/>        
        <meta property="og:description" content="Track the latest Mumbai University Results as they happen. We have a history of being faster than the university site.Just Saying!">
        <meta property="og:image" content="<?php echo WEB_ROOT ?>images/murt_fb.png"/>
        <meta name="fb:app_id" content="muresults"/>
        <meta name="fb:admins" content="jugal"/>

        <!-- Site Properities -->
        <title>Mumbai University Result Tracker</title>        
        <!--        <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700" rel="stylesheet" type="text/css" />-->
        <link rel="stylesheet" type="text/css" href="css/semantic.min.css" />
        <link rel="stylesheet" type="text/css" href="css/homepage.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css?ts=<?php echo time(); ?>" />

    </head>
    <body id="home">


        <div id="murt-app">  
        </div>      
        <noscript>
        <div class="ui bottom attached negative message" id="resultError">
            <div class="header">
                <i class="warning sign icon"></i> Error
            </div>
            <p>Please Enable Javascript</p>
        </div>
        </noscript>  
        <!-- Google Tag Manager -->
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-52XVTN"
                          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script>(function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({'gtm.start':
                        new Date().getTime(), event: 'gtm.js'});
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    '//www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-52XVTN');</script>
        <!-- End Google Tag Manager -->
        <input type="hidden" name="hitCount" id="hitCount" value="<?php echo HitCounter::getHitCountForURI("/");//TODO                           ?>" />
        <input type="hidden" id="androidDownloadCount" value="<?php echo meta::getValue("apk_download_count"); ?>" />            
        <input type="hidden" id="WEB_ROOT" value='<?php echo WEB_ROOT; ?>' />


        <?php require_once('../templates/handleBarTemplates.php'); ?>
        <script src="js/libs/jquery-1.11.2.min.js"></script>
        <script src="js/libs/semantic.min.js"></script>

        <script>jQuery('script[type="text/html"]').attr('type', 'text/x-handlebars');</script>
        <script src="js/libs/handlebars-v2.0.0.min.js"></script>
        <script src="js/libs/ember-1.9.min.js"></script>
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
<?php 
require_once ("../includes/teardown.php");