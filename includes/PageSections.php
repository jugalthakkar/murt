<?php
require_once ('HitCounter.php');
require_once ('constants.php');

function spitPageHeader($title = "") {
    if ($title != "") {
        $title = $title . " | Mumbai University Result Tracker | Jugal Thakkar";
    } else {
        $title = "Mumbai University Result Tracker | Jugal Thakkar";
    }
    ?><!DOCTYPE html>
    <html lang="en">
        <head>
            <title><?php echo $title; ?></title>
            <meta charset="UTF-8" />
            <link rel="shortcut icon"
                  href="<?php echo WEB_ROOT; ?>favicon.ico" />
            <meta name="description" content="Mumbai University Result Tracker">
            <meta name="og:title" content="<?php echo $title; ?>"/>
            <meta name="og:image" content="<?php echo WEB_ROOT ?>images/test_cartoon.png"/>
            <meta name="og:url" content="<?php echo WEB_ROOT; ?>"/>
            <meta name="og:type" content="non_profit"/>
            <meta name="og:site_name" content="Mumbai University Result Tracker"/>
            <meta name="fb:admins" content="jugal"/>
            <link rel="stylesheet" href="<?php echo WEB_ROOT; ?>css/main.css">        
            <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/jQuery/jquery-1.7.1.min.js"></script>
            <script type="text/javascript" src="<?php echo WEB_ROOT; ?>JS/jQuery/jquery.aqstamp.js"></script>    
            <script type="text/javascript">

                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-30655658-1']);
                _gaq.push(['_trackPageview']);

                (function() {
                    var ga = document.createElement('script');
                    ga.type = 'text/javascript';
                    ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(ga, s);
                })();

            </script>
        </head>
        <body>
            <div id="a">
                <a href="http://jugal.me/" title="Visit my home page">
                    <header>
                        <img src="<?php echo WEB_ROOT; ?>images/jugal-thakkar.png" alt="Jugal Thakkar"  style="border: none;"/>
                    </header>
                </a>
                <div id="b">
                    <article>
                        <h1>Mumbai University Result Tracker</h1>
                        <div class="mainSection">
                        <?php } ?>



                        <?php

                        function spitPageFooter() { ?>
                        </div>

                        <br/>
                        <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                        <fb:like-box profile_id="149360911750365" width="300" height="75" show_faces="false" stream="false" header="false"></fb:like-box>
                        <br />
                        <div id="fb-root"></div> <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id))
                                    return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                        <div class="fb-post" data-href="https://www.facebook.com/questions/211792548840534" data-width="470">
                            <div class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/questions/211792548840534">Post</a> by <a href="http://www.facebook.com/muresults">Mumbai University Result Tracker</a>.</div></div>

                        <br /><br />
                        <p class="highlight-1"><em>This Site is Not affiliated with Mumbai University or http://mu.ac.in/</em></p>



                        <script type="text/javascript">
                            $(function() {
                                $(".timestamp").each(function() {
                                    $(this).text($.aqStamp(($(this).text())));
                                });
                            });
                        </script>

                        <section class="meta">
                            <p>Author: <a href="http://jugal.me/">Jugal Thakkar</a></p>
                            <ul>
                                <li><a href="#" rel="tag">Mumbai University</a></li>
                                <li><a href="#" rel="tag">Results</a></li>
                                <li><a href="#" rel="tag">MU Results</a></li>
                                <li><a href="#" rel="tag">Android</a></li>
                                <li><a href="#" rel="tag">Facebook</a></li>
                                <li><a href="#" rel="tag">Mobile</a></li>
                            </ul>
                        </section>
                    </article>
                    <aside>
                        <h4>About the Author</h4>
                        <div id="c">
                            <img src="<?php echo WEB_ROOT ?>images/jugal-thakkar.jpg" alt="Jugal Thakkar">
                            <p>Hi, it's me <a href="http://jugal.me/">Jugal Thakkar</a>.</p>
                            <p>Hope my work helps in making your world a `lil simpler if not better.</p>
                        </div>
                        <nav>
                            <h4>App Ek Roop Anek</h4>
                            <ul>
                                <li><a href="<?php echo WEB_ROOT ?>android/">Android</a></li>
                                  <li><a href="<?php echo WEB_ROOT ?>visualization/">Visualization</a></li>
                                <li><a href="<?php echo WEB_ROOT ?>SL/">Rich UI</a></li>
                                <li><a href="<?php echo WEB_ROOT ?>JS/">Standard</a></li>
                                <li><a href="<?php echo WEB_ROOT ?>mobile/">Mobile</a></li>
                                <li><a href="<?php echo WEB_ROOT ?>rss/">RSS</a></li>
                                <li><a href="<?php echo WEB_ROOT ?>JS/all.php">All Results</a></li>                            
                                <li><a href="http://facebook.com/muresults/">Facebook</a></li>
                                <li><a href="https://twitter.com/muresulttracker">Twitter</a></li>
                            </ul>
                        </nav>
                    </aside>
                </div>
                <footer>
                    <!--
                            ### LICENSE
                            ############

                            This W3C-compliant, CSS-based website template has a
                            Creative Commons Attribution-Share Alike 3.0 Unported License.

                            http://creativecommons.org/licenses/by-sa/3.0/

                            In short, you must:
                            + keep the credit links in the footer intact
                            + not change the license (e.g. copywriting my work)


                            ### BREAKING THE LICENSE
                            #########################

                            Breaking the rules of the license will result in me initiating
                            the necessary legal procedures and publicly shaming you here:

                            http://owmx.com/hall-of-shame/
                    -->
                    <p><a href="http://jugal.me/">Jugal Thakkar</a> &copy; 2012
                        | <span style="text-align: right">Page Hits: <strong><?php echo HitCounter::getHitCount(); ?></strong></span>
                        | <span style="text-align: right">Site Hits: <strong><?php echo HitCounter::getTotalHits(); ?></strong></span>
                        <br />Template Design &amp; Markup by <a href="http://jabz.net/contact/jonas-jacek">Jonas Jacek</a> | <a href="http://owmx.com/" title="Free HTML5 &amp; CSS3 Web Templates">Free Web Templates</a>.</p>
                </footer>
            </div>

            <script type="text/javascript">
                $(function() {
                    $('a').filter(
                            '[href="' + window.location.href + '"],[href="'
                            + window.location.pathname + window.location.search.substring() +
                            '"]'
                            ).each(function() {
                        $(this).replaceWith($(this).html());
                    });
                });
            </script>
        </body>
    </html>

<?php } ?>