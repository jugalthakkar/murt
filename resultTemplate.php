<div class="row">
    <div class="column">
        <h1 class="center aligned ui inverted header">
            {{name}}
        </h1>
    </div>
</div>
<div class="row">
    <div class="column center aligned" id="examInputs">
        <div class="ui form inverted fluid segment stepInput">            
            <div class="ui big fluid input required field">                
                {{input type="text" value=seat placeholder="Seat No." name="seat" }}
            </div>
            <div class="ui big fluid input required  field">   
                <div class="ui selection dropdown">
                    {{input type="hidden" value=selectedMonth name="month" }}                
                    <div class="default text">Month of Examination</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        {{#each monthOption in monthOptions}}
                        <div class="item" {{bind-attr data-value=monthOption.value}}>{{monthOption.display}}</div>
                        {{/each}}           
                    </div>
                </div>             
            </div>            
            <div {{bind-attr class=":ui :blue :message model.isInput:hidden"}} class="ui blue message" id="result">
                <div class="header">
                    {{result}}
                    <div {{bind-attr class="model.isLoading::hidden"}} >
                        <div class="ui active inline loader"></div>
                        <p>Best of Luck!</p>
                    </div>
                </div>      
            </div>    
            <div>
                <div class="ui blue submit button" {{action "GetResult"}}>
                    <i class="thumbs up icon"></i> I Am Feeling Lucky</div>                
            </div>    

        </div>
        <div class="ui inverted fluid segment stepInput"> 
            <div class="ui warning message">
                <i class="info circle icon"></i>
                Accuracy of Year & Month is critical
            </div>
        </div>


    </div>

</div>
