<script type="text/javascript">
    var maxCount;
    var refreshTime;
    var AutoRefreshTime=<?php echo isset($_GET['refTime'])?$_GET['refTime']:"5"; ?>;
    var animTime=1500;
    $(function(){            
        maxCount=(<?php echo $Maxcount; ?>);        
        refreshTime=0;
        AutoRefresh();
                
    });


    function refreshCounter(){
        $("#hitCounter").children("*").remove("*");
        $("#hitCounter").html('<img src="http://www.website-hit-counters.com/cgi-bin/image.pl?URL=431051-8171" alt="hit counter" />');
        
    }

    function showPBar(){
        var ele='<tr id="inProgress" style="background-color: red;background-image: url(\'../images/pBar3.png\');"}><th colspan="2">Searching New Results...</th></tr>';
        $("#tHeader").after(ele);
    }
    function hidePBar(){
        $("#inProgress").remove();
    }
    function setCaption(htmlStr){
        $("#tCaption").html(htmlStr);
    }

    function getNewResults(count){
        refreshTime=-1;
        showPBar();
        setCaption("&nbsp;");

        var now  = new Date();
        var fromID=$(".examRow :first").attr("id");
        
        $.ajax({
            url: "../Services.php",
            dataType: 'json',
            data: "s=get&count="+count + "&ts=" + now.getTime()+ "&after=" + fromID,
            success: addNewResults
        });
        
    }

    function AutoRefresh(){
        if(refreshTime>0){
            setCaption("Auto Refresh in " + refreshTime + " Seconds. Or <a href=\"#\" onclick='refreshTime=0;return false;'>Refresh Now</a>");
        }else if(refreshTime==0){
            getNewResults(1);
        }
        refreshTime--;
        setTimeout(AutoRefresh,1000);
    }

    function addNewResults(data){
        var json=data;
        var table="";
        var newCount=0;
        $.each(json,function(i,item){
            var row="";
            row += "<tr class='examRow'>";
            row +=  "<td id=\""+ item.Id +"\"><a href=\"<?php echo WEB_ROOT; ?>ExamDetails.php?exam_id=" + item.Id + "\">" + item.ExamName + "</a></td>";
            row +=  "<td class='timestamp'>" + $.aqStamp(item.Discovered) + "</td>";
            row +=  "</tr>";
            table +=row;
            newCount++;
        });
        hidePBar();
        $("#tHeader").after(table);
        setCaption("&nbsp;");
        if(newCount>0){
            alert("New Result Link Discovered for "+ $("td :first").text());
            getNewResults(1);
        }else{
            refreshTime=60*AutoRefreshTime;
        }
    }
</script>
<?php
/*
Application ID
    157208214292583
API Key
    8094dc0fb86b77c58d41f8eb8e52361c
Application Secret
    7b94ea3febf04305c7f3fe5f90f7c068
Site URL
    http://jugalthakkar.x10.mx/MU/
*/

?>