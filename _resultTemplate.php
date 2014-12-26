<div class="row">
    <div class="column center aligned ">
        <h1 class="ui inverted header">{{model.ExamName}}</h1>
    </div>
</div>

<div class="row">
    <div class="column center aligned">
        <div class="ui attached message">
            <div class="ui steps inverted center aligned">
                <a class="active step">
                    <div class="content">
                        <div class="title">Details</div>
                        <div class="description">Exam Details</div>
                    </div>
                </a>
                <a class="step">
                    <div class="content">
                        <div class="title">Result</div>
                        <div class="description">View Result</div>
                    </div>
                </a>
            </div>
        </div>
        
        <form action="http://muresulttracker.tk/showResult.php" method="post" class="ui form attached fluid segment stepInput">
            
            <div class="two fields">
                <div class="field">
                    <label>Seat Number of Student</label>
                    <input name="seat_no"  placeholder="Seat No." type="text" />
                </div>
                <div class="field">
                    <label>Name of Examination</label>
                    {{input value=model.name readonly="readonly"  placeholder=model.ExamName type="text"}}
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Year of Examination</label>
                    <input name="exam_year" placeholder="Year" type="text" />
                </div>
                <div class="field">
                    <label>Month of Examination</label>
                    <select name="exam_month">
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                    </select>
                </div>
            </div>
            {{input value=model.Id type="hidden" name="exam_id"}}
            <div class="ui blue submit button" type="submit" value="Submit" >Submit</div>
        </form>
        <div class="ui bottom attached warning message stepInput">
            <i class="info circle icon"></i>
            Accuracy of Year & Month is critical
        </div>
        <div class="ui bottom attached positive message" id="resultPass">
            <i class="close icon"></i>
            <div class="header">
                Pass
            </div>
            <p>Congratulations! Result...</p>
        </div>

        <div class="ui bottom attached negative message" id="resultFail">
            <div class="header">
                Fail
            </div>
            <p>Sorry. Result...</p>
        </div>


        <div class="ui bottom attached blue message" id="resultUnknown">
            <p>Unknown Result...</p>
        </div>

        <div class="ui bottom attached negative message" id="resultError">
            <div class="header">
                <i class="warning sign icon"></i> Error
            </div>
            <p>Please try again</p>
        </div>
    </div>

</div>
