<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

  <!-- Site Properities -->
  <title>Mumbai University Result Tracker</title>
  <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="css/semantic.css" />
  <link rel="stylesheet" type="text/css" href="css/homepage.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css?ts=<?php echo time(); ?>" />
</head>
<body id="home">
<div id="murt-app" class="ui grid"></div>


<?php require_once('handleBarTemplates.php'); ?>

<script src="js/libs/jquery-1.10.2.js"></script>
<script src="js/libs/semantic.js"></script>

<script>jQuery('script[type="text/html"]').attr('type', 'text/x-handlebars');</script>
<script src="js/libs/handlebars-1.1.2.js"></script>
<script src="js/libs/ember-1.6.1.js"></script>
<script src="js/libs/moment.min.js"></script>
<script src="js/app.js"></script>
<!-- <script src="js/homepage.js"></script> -->
</body>

</html>
