<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Ember Starter Kit</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <script type="text/x-handlebars">
    <h2>Welcome to Ember.js</h2>

    {{outlet}}
  </script>

  <script type="text/x-handlebars" id="index">
    <ul>
    {{#each}}
      <li>{{this}}</li>
    {{/each}}
    </ul>
  </script>

  <script src="js/libs/jquery-1.10.2.js"></script>
  <script src="js/libs/handlebars-1.1.2.js"></script>
  <script src="js/libs/ember-1.6.1.js"></script>
  <script src="js/app.js"></script>  
</body>
</html>
