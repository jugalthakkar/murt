<?php
require_once("../includes/initialize.php");
require_once("../includes/exams.php");
require_once("../includes/PageSections.php");
$ngAppName = "visualization";
$title = "Visualization";
//    spitPageHeader("HTML");
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" > <!--<![endif]-->
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
        <meta name="viewport" content="width=device-width">


        <link href="<?php echo WEB_ROOT; ?>css/bootstrap.min.css"  rel="stylesheet" />
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link href="<?php echo WEB_ROOT; ?>css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="<?php echo WEB_ROOT; ?>css/visualization.css" rel="stylesheet" />

        <script src="<?php echo WEB_ROOT; ?>JS/lib/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>    
    <body <?php
    if ($ngAppName) {
        echo 'ng-app="' . $ngAppName . '"';
    }
    ?>>
        <!--[if lt IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo WEB_ROOT; ?>">Mumbai University Result Tracker</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">                        
                        <li><a href="<?php echo WEB_ROOT; ?>">Home</a></li>
                        <li class="active"><a href="<?php echo WEB_ROOT; ?>visualization">Visualization</a></li>
                        <li><a href="<?php echo WEB_ROOT; ?>android">Android</a></li>

                    </ul>

                </div><!--/.navbar-collapse -->
            </div>
        </div>

        <div class="container" ng-controller="VisualizationCtrl">
            <div class="page-header">
                <h1>Visualization <small>for the data crunchers</small></h1>
            </div>
            <div class="row">
                <div class="btn-toolbar pull-right" role="toolbar" >
                    <button class="btn btn-default" ng-click="ToggleStacking()" ng-show="isStackable"><span class="glyphicon glyphicon-stats"></span> {{toggleStackLabel}}</button>
                    <button class="btn btn-default" ng-click="filter()"><span class="glyphicon glyphicon-filter"></span> Filter Results</button>
                </div>
            </div>
            
            <div class="row" >
                <div id="chartNavigator">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#timeline" id="timeline-link" data-toggle="tab" ng-click="showTab('timeline')">Timeline</a></li>         
                        <li ng-repeat="tab in tabs">
                            <a href="#{{tab.containerId}}" id="{{tab.containerId}}-link" data-toggle="tab" ng-click="showTab(tab.containerId)">{{tab.header}}
                            </a>
                        </li>
                        <li id="customChartLink"><a href="#customChartContainer" id='customChartContainer-link' data-toggle="tab" ng-click="showTab('customChartContainer')"><span class="glyphicon glyphicon-plus"></span></a></li>
                    </ul>
                </div>
                <div id="chartContainer" >
                    <div class="tab-content">
                        <div class="tab-pane active" id="timeline">
                            <div class="chartContainer"></div>
                        </div>
                        <div ng-repeat="tab in tabs" class="tab-pane" id="{{tab.containerId}}">
                            <div class="chartContainer"></div>
                        </div>
                        <div class="tab-pane" id="customChartContainer">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <strong>Select custom chart options & hit Go!</strong>
                                </div>
                                <div class="panel-body">
                                    <p><em>I wish to plot Results by</em>                            </p>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                            {{customGroupDefintion.groupA | uppercase}} <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li ng-repeat="option in groupingOptions" ><a href="#" ng-click="setGroupA(option)">{{option | uppercase}}</a></li>
                                        </ul>
                                    </div>
                                    &AMP;
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                            {{customGroupDefintion.groupB | uppercase}} <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li ng-repeat="option in groupingOptions" ><a href="#" ng-click="setGroupB(option)">{{option | uppercase}}</a></li>
                                        </ul>                                    
                                    </div>
                                    <button type="button" class="btn btn-default btn-success" ng-click="addChart(customGroupDefintion,selectedResultsFiltered)">Go!</span>
                                    </button>
                                </div>
                            </div>                      
                        </div>
                    </div>
                </div>  
            </div>
            <div ng-view></div>
            <hr>

            <footer>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                            return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=157208214292583";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-like-box" data-href="http://www.facebook.com/muresults" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
                <p><a href="http://jugal.me/">Jugal Thakkar</a> &copy; 2014 | <span style="text-align: right">Page Hits: <strong><?php echo HitCounter::getHitCount(); ?></strong></span>
                    | <span style="text-align: right">Site Hits: <strong><?php echo HitCounter::getTotalHits(); ?></strong></span> | <em>This Site is Not affiliated with Mumbai University or http://mu.ac.in/</em> | This is a non-profit tool</p>
            </footer>

        </div>


    </div> <!-- /container -->   
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/lib/underscore-min.js" ></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/lib/jquery-1.10.2.min.js" ></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/lib/angular.min.js" ></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/lib/angular-route.min.js" ></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/lib/angular-resource.min.js" ></script>    
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/lib/highstock.js" ></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/lib/exporting.js" ></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/lib/bootstrap.min.js" ></script>       

<!--        <script type="text/javascript" src="http://code.angularjs.org/1.2.7/angular.js" ></script>
<script type="text/javascript" src="http://code.angularjs.org/1.2.7/angular-route.js" ></script>
<script type="text/javascript" src="http://code.angularjs.org/1.2.7/angular-resource.js" ></script>-->

    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/controllers/visualization.js" ></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/app.js" ></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/services.js" ></script>
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
<?php require_once("../includes/teardown.php"); ?>