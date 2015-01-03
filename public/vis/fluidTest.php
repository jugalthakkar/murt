<?php
require_once("../includes/initialize.php");
$ngAppName = "visualization";
$title = "Visualization";
//    spitPageHeader("HTML");
?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
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
    <body>
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                &lt;h1&gt;what?<span>&lt;/h1&gt;</span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            Panel content
                        </div>
                        <div class="panel-footer">
                            Panel footer
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-8 column">
                            <h3 class="text-success">
                                h3. Lorem sdasdasd dolor sit amet.
                            </h3>
                        </div>
                        <div class="col-md-4 column">
                            <p>
                                Lorem ipsum dolor sit amet, <strong>consectetur adipiscing elit</strong>. Aliquam eget sapien sapien. Curabitur in metus urna. In hac habitasse platea dictumst. Phasellus eu sem sapien, sed vestibulum velit. Nam purus nibh, lacinia non faucibus et, pharetra in dolor. Sed iaculis posuere diam ut cursus. <em>Morbi commodo sodales nisi id sodales. Proin consectetur, nisi id commodo imperdiet, metus nunc consequat lectus, id bibendum diam velit et dui.</em> Proin massa magna, vulputate nec bibendum nec, posuere nec lacus. <small>Aliquam mi erat, aliquam vel luctus eu, pharetra quis elit. Nulla euismod ultrices massa, et feugiat ipsum consequat eu.</small>
                            </p>
                        </div>
                    </div>
                    <ul>
                        <li>
                            Lorem ipsum dolor sit amet
                        </li>
                        <li>
                            Consectetur adipiscing elit
                        </li>
                        <li>
                            Integer molestie lorem at massa
                        </li>
                        <li>
                            Facilisis in pretium nisl aliquet
                        </li>
                        <li>
                            Nulla volutpat aliquam velit
                        </li>
                        <li>
                            Faucibus porta lacus fringilla vel
                        </li>
                        <li>
                            Aenean sit amet erat nunc
                        </li>
                        <li>
                            Eget porttitor lorem
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
