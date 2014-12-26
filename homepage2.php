<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!-- Site Properities -->
    <title>Mumbai University Result Tracker</title>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="css/semantic.css" />
    <link rel="stylesheet" type="text/css" href="css/homepage.css" />
</head>
<body  id='murt-app'>
  <div class="ui inverted masthead segment">
    <div class="ui page grid">
        <div class="column">
             <div class="ui inverted blue menu">
                <div class="header item">Home</div>
                <div class="right menu">
                    <div class="ui mobile dropdown link item">
                        Menu
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <a class="item">Results</a>
                            <a class="item">Android</a>
                            <a class="item">Visualization</a>
                            <a class="item">Facebook</a>
                            <a class="item">Twitter</a>
                            <a class="item">RSS</a>
                            <a class="item">About</a>
                        </div>
                    </div>
                    <a class="item">Android</a>
                    <a class="item">Visualization</a>
                    <div class="ui dropdown link item">
                        More
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <a class="item">Facebook</a>
                            <a class="item">Twitter</a>
                            <a class="item">RSS</a>
                            <a class="item">About</a>
                        </div>
                    </div>
                </div>
            </div>
            <img src="images/cyberscooty-tux-graduate.svg" class="ui medium image" />
            <div class="ui hidden transition information">
                <h1 class="ui inverted header">
                    Mumbai University Result Tracker
                </h1>
                <p>We have a history of being faster than the university site.<br /> Just Saying!</p>

                    <div class="large basic inverted animated fade ui button">
                        <div class="visible content">Latest Results</div>
                        <div class="hidden content">Track Live</div>
                    </div>
        </div>
            </div>
        </div>
    </div>
     <div class="ui vertical feature segment">
         <div class="ui centered page grid">
      		<div class="fourteen wide column">
            	<div class="ui three column center aligned stackable divided grid">
                	<div class="column">
	                    <a href="#android" class="ui icon header">
	                        <i class="circular green android link icon"></i>
	                        Android
	                    </a>
	                    <p>Track results from your android devices with the MURT's very own app.</p>
	                    <p>
	                        <a class="ui teal right labeled icon button" href="#android">Download  <i class="right long arrow icon"></i>
	                            <span class="floating circular ui black label">1165</span>
	                        </a>
	                    </p>
	                </div>
	                <div class="column">
	                    <a href="#subscribe" class="ui icon header">
	                        <i class="circular red bullhorn link icon"></i>
	                        Live Updates
	                    </a>
	                    <p>Follow live results on Facebook, Twitter or subscribe to RSS Feed.</p>
	                    <p><a class="ui teal right labeled icon button" href="#subscribe">Subscribe <i class="right long arrow icon"></i></a></p>
	                </div>
	                <div class="column">
	                    <a  href="#visualization" class="ui icon header">
	                        <i class="circular signal purple link icon"></i>
	                        Visualization
	                    </a>
	                    <p>Analyze the trends, predict the future, do as you please with all the data.</p>
	                    <p><a class="ui teal right labeled icon button" href="#visualization">Visualize <i class="right long arrow icon"></i></a></p>
                </div>
            </div>
        </div>
    </div>
  <div class="ui inverted vertical segment">
    <div class="ui inverted page grid stackable relaxed feature segment">
        <div class="row">
            <div class="column">
                <h1 class="center aligned ui header">
                    Latest Results
                </h1>
            </div>
        </div>
        <div class="row">
            {{outlet}}
        </div>
        <div class="row">
            <div class="column">
                <div class="ui basic inverted animated button button right floated">
                    <div class="visible content">More Results</div>
                    <div class="hidden content"><i class="right arrow icon"></i></div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="ui vertical segment">
    <div class="ui stackable segment page grid" id="subscribe">
        <div class="row">
            <div class="column">
                <h1 class="center aligned ui header">
                    Get Notified, Stay Updated.
                </h1>
                <div class="ui horizontal divider"><i class="bullhorn icon"></i></div>
            </div>
        </div>
        <div class="aligned row">
            <div class="sixteen column">
                <div class="ui four column center aligned stackable grid">
                    <div class="column">
                        <i class="huge circular facebook link icon"></i>
                    </div>
                    <div class="column">
                        <i class="huge circular twitter link icon"></i>
                    </div>
                    <div class="column" id="android">
                        <i class="huge circular android link icon"></i>
                    </div>
                    <div class="column">
                        <i class="huge circular rss link icon"></i>
                    </div>
                </div>
            </div>
    </div>
    <div class="social">
    </div>
  </div>

  <div class="ui inverted footer vertical segment">
    <div class="ui stackable center aligned page grid">
      <div class="ten wide column">
        <div class="ui three column center aligned stackable grid">
          <div class="column">
            <h5 class="ui inverted header">Courses</h5>
            <div class="ui inverted link list">
              <a class="item">Registration</a>
              <a class="item">Course Calendar</a>
              <a class="item">Professors</a>
            </div>
          </div>
          <div class="column">
            <h5 class="ui inverted header">Library</h5>
            <div class="ui inverted link list">
              <a class="item">A-Z</a>
              <a class="item">Most Popular</a>
              <a class="item">Recently Changed</a>
            </div>
          </div>
          <div class="column">
            <h5 class="ui inverted header">Community</h5>
            <div class="ui inverted link list">
              <a class="item">BBS</a>
              <a class="item">Careers</a>
              <a class="item">Privacy Policy</a>
            </div>
          </div>
        </div>
      </div>
      <div class="six wide column">
        <h5 class="ui inverted header">Contact Us</h5>
        <addr>
          237 Catberry Road <br>
          Milton Keynes, London <br>
        </addr>
        <p>(404) 867-5309</p>
      </div>
        <div>
            <p>
                Image courtesy of [name of the image creator] at FreeDigitalPhotos.net
            </p>
    </div>
  </div>

    <script type="text/x-handlebars" data-template-name="index">
        <table class="ui black inverted table segment">
            <thead>
                <tr>
                    <th class="ten wide">Examination</th>
                    <th class="six wide">Discovered On</th>
                </tr>
            </thead>
            <tbody>
                {{#each}}
                <tr>
                    <td>{{name}}</td>
                    <td>{{epoch}}</td data-epoch="{{epoch}}">
                    </tr>
                    {{/each}}
                </tbody>
            </table>
        </script>	  
        <script src="js/libs/jquery-1.10.2.js"></script>
        <script>jQuery('script[type="text/html"]').attr('type', 'text/x-handlebars');</script>
        <script src="js/libs/handlebars-1.1.2.js"></script>
        <script src="js/libs/ember-1.6.1.js"></script>
        <script src="js/libs/moment.min.js"></script>
        <script src="js/app.js"></script>
        <script src="js/libs/semantic.js"></script>
        <script src="js/homepage.js"></script>
    </body>
    </html>
