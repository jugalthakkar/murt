<div class="row">
    <div class="column">
        <h1 class="center aligned ui inverted header">
            Last {{model.length}} Results
        </h1>
    </div>
</div>
<div class="row">
    <div class="sixteen column wide">    
        <table class="ui black inverted table segment">
            <thead>
                <tr>
                    <th class="ten wide">Examination</th>
                    <th class="six wide">Discovered On</th>
                </tr>
            </thead>

            <tbody>
                {{#each exam in model}}
                <tr>
                    <td>{{#link-to 'result' exam.Id exam.ExamName}}{{exam.ExamName}}{{/link-to}}</td>
                    <td {{bind-attr data-epoch=exam.Discovered}} title="{{longTime Discovered}}">{{readableTime Discovered}}</td>
                </tr>
                {{/each}}
            </tbody>
        </table>
    </div>
</div>