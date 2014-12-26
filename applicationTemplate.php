<div class="ui fixed inverted menu" >
    <div class="title item">
        <h3 class="ui inverted header">{{#link-to 'index'}}<abbr title="Mumbai University Result Tracker">MURT</abbr>{{/link-to}}</h3>
    </div>
    <div class="right menu">
        <div class="ui mobile dropdown link item">
            {{#link-to 'android' class='item ui icon header'}}
            <i class="green android link icon"></i> Android
            {{/link-to}}
            <a href="https://www.facebook.com/muresults" class="item ui icon header" target="_blank">
                <i class="blue facebook link icon"></i> Facebook
            </a>
            <a href="https://twitter.com/muresulttracker" class="item ui icon header" target="_blank">
                <i class="blue twitter link icon"></i> Twitter
            </a>
            <a href="http://muresulttracker.tk/rss/"  class="item ui icon header" target="_blank">
                <i class=" orange rss link icon"></i> RSS
            </a>
        </div>       
        {{#link-to 'android' class='item ui icon header'}}
        <i class="green android link icon"></i> Android
        {{/link-to}}
        <a href="https://www.facebook.com/muresults" class="item ui icon header" target="_blank">
            <i class="blue facebook link icon"></i> Facebook
        </a>
        <a href="https://twitter.com/muresulttracker" class="item ui icon header" target="_blank">
            <i class="blue twitter link icon"></i> Twitter
        </a>
        <a href="http://muresulttracker.tk/rss/"  class="item ui icon header" target="_blank">
            <i class=" orange rss link icon"></i> RSS
        </a>
    </div>
</div>
<div class="ui inverted masthead segment">
    <div class="ui page grid">
        <div class="column">            
            <img src="images/cyberscooty-tux-graduate.svg" class="ui medium image" />
            <div class="ui information">
                <h1 class="ui inverted header">
                    Mumbai University Result Tracker
                </h1>
                <h3 class="ui header">We have a history of being faster than the university site.<br /> Just Saying!</h3>

                {{#link-to 'index' class='large basic animated fade ui button'}}
                <div class="visible content">Latest Results</div>
                <div class="hidden content" {{action "onShowResult"}}>Track Live</div>
                {{/link-to}}

            </div>
        </div>
    </div>
</div>


<div class="ui inverted vertical segment" id="outlet">
    {{outlet}}
</div>


<div class="ui vertical feature segment">
    <div class="ui centered page grid">
        <div class="fourteen wide column">
            <div class="ui four column center aligned stackable divided grid">
                <div class="column">

                    {{#link-to 'android' class='ui icon header'}}
                    <i class="green android link icon"></i>
                    Android
                    {{/link-to}}

                    <p>Track results from your android devices with the MURT's very own app.</p>
                    <p>
                        {{#link-to 'android' class='ui blue right labeled icon button'}}
                        Download  <i class="right chevron icon"></i>
                        <span class="floating ui black label">{{model.androidDownloadCount}}</span>
                        {{/link-to}}
                    </p>
                </div>                

                <div class="column">
                    <a href="https://www.facebook.com/muresults" class="ui icon header" target="_blank">
                        <i class="blue facebook link icon"></i>
                        Facebook
                    </a>
                    <p>Follow live results on Facebook</p>
                    <div id="fb-root"></div>
                    <div class="fb-like-box" data-href="https://www.facebook.com/muresults" data-width="150" data-height="100" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
                </div>

                <div class="column">
                    <a  href="https://twitter.com/muresulttracker" class="ui icon header">
                        <i class="blue twitter link icon"></i>
                        Twitter
                    </a>
                    <p>Follow live results on Twitter</p>
                    <a href="https://twitter.com/muresulttracker" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @muresulttracker</a>
                </div>
                <div class="column">
                    <a  href="http://muresulttracker.tk/rss/" class="ui icon header">
                        <i class="orange rss link icon"></i>
                        RSS
                    </a>
                    <p>Subscribe to RSS feed</p>
                    <p>
                        <a href="http://muresulttracker.tk/rss/" class='ui blue right labeled icon button'>
                            Subscribe  <i class="right chevron icon"></i>                            
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="ui inverted footer vertical segment">
    <div class="ui stackable center aligned page grid">
        <div class="sixteen wide column">
            <div class="ui two column center aligned stackable grid">
                <div class="column">
                    <h5 class="ui inverted header">&copy; <a href="http://jugal.me/">Jugal Thakkar</a></h5>
                    <h5 class="ui inverted header">2010 - {{model.currentYear}}</h5>
                </div>
                <div class="column">
                    <h5 class="ui inverted header">Hits: <span class="ui default label">{{model.hitCount}}</span></h5>
                    <h5 class="ui inverted header">This site is not affiliated with Mumbai University or http://mu.ac.in/</h5>
                </div>
            </div>
        </div>
    </div>
</div>


