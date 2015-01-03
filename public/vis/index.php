<?php
require_once("../../includes/initialize.php");
require_once("../../includes/exams.php");
require_once("../../includes/HitCounter.php");

$ngAppName = "visualization";
$title = "Visualization";
//    spitPageHeader("HTML");
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"  lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="shortcut icon"
              href="<?php echo WEB_ROOT; ?>favicon.ico" />
        <title>Visualization | Mumbai University Result Tracker | Jugal Thakkar</title>
        <meta name="description" content="Mumbai University Result Tracker">
        <meta name="og:title" content="<?php echo $title; ?>"/>
        <meta name="og:image" content="<?php echo WEB_ROOT ?>images/test_cartoon.png"/>
        <meta name="og:url" content="<?php echo WEB_ROOT; ?>"/>
        <meta name="og:type" content="non_profit"/>
        <meta name="og:site_name" content="Mumbai University Result Tracker"/>
        <meta name="fb:admins" content="jugal"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <link href="css/bootstrap.min.css"  rel="stylesheet" />
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link href="css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="css/visualization.css" rel="stylesheet" />

        <script src="js/lib/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>    
    <body  <?php
    if ($ngAppName) {
        echo 'ng-app="' . $ngAppName . '"';
    }
    ?>>
        <div class="container">
            <!--[if lt IE 8]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
            <div class="row">
                <div class="col-xs-12">                  
                    <div ng-view></div>
                   

                </div>
            </div>
        </div> <!-- /container -->   
        <script type="text/javascript" src="js/lib/underscore-min.js" ></script>
        <script type="text/javascript" src="js/lib/jquery-1.10.2.min.js" ></script>
        <script type="text/javascript" src="js/lib/angular.min.js" ></script>
<!--            <script type="text/javascript" src="js/lib/angular.js" ></script>-->
        <script type="text/javascript" src="js/lib/angular-route.min.js" ></script>
        <script type="text/javascript" src="js/lib/angular-resource.min.js" ></script>    
        <script type="text/javascript" src="js/lib/angular-animate.min.js" ></script>    
    
<!--        <script type="text/javascript" src="js/lib/angular-route.js" ></script>
        <script type="text/javascript" src="js/lib/angular-resource.js" ></script>    -->
        <script type="text/javascript" src="js/lib/highstock.js" ></script>
        <script type="text/javascript" src="js/lib/exporting.js" ></script>
    <!--    <script type="text/javascript" src="js/lib/bootstrap.min.js" ></script>       -->
        <script type="text/javascript" src="js/lib/ui-bootstrap-tpls-0.10.0.min.js" ></script>       

<!--    <script type="text/javascript" src="http://code.angularjs.org/1.2.7/angular.js" ></script>
    <script type="text/javascript" src="http://code.angularjs.org/1.2.7/angular-route.js" ></script>
    <script type="text/javascript" src="http://code.angularjs.org/1.2.7/angular-resource.js" ></script>-->

        <script type="text/javascript" src="js/controllers/resultFilterController.js" ></script>        
        <script type="text/javascript" src="js/directives/resultFilterDirective.js" ></script>    
        <script type="text/javascript" src="js/controllers/ChartDirectiveController.js" ></script>    
        <script type="text/javascript" src="js/directives/chartDirective.js" ></script>    
        <script type="text/javascript" src="js/services/ResultServices.js" ></script>
        <script type="text/javascript" src="js/controllers/VisualizationController.js" ></script>

        <script type="text/javascript" src="js/app.js" ></script>

        <script>
                            var _gaq = [['_setAccount', 'UA-30655658-1'], ['_trackPageview']];
                            (function(d, t) {
                                var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
                                g.src = '//www.google-analytics.com/ga.js';
                                s.parentNode.insertBefore(g, s)
                            }(document, 'script'));
        </script>
    </body>
</html>
<?php require_once("../../includes/teardown.php"); ?>