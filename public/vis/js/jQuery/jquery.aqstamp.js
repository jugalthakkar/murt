(function($){
    $.aqStamp = function($seed,$span) {
        var _now = new Date();
        var _d = Math.ceil(_now.getTime() / 1000) - $seed;
        var _string = '';
        var _t = $.aqStamp.text;

        if (_d < 60) _string = _t.seconds;
        else if (_d < 120) _string = _t.minute;
        else if (_d < 3600) _string = Math.round(_d/60) +' '+ _t.minutes;
        else if (_d < 7200) _string = _t.hour;
        else if (_d < 86400) _string = Math.round(_d/3600) +' '+ _t.hours;
        else if (_d < 172800) _string = _t.day;
        else if (_d < 2678400) _string = Math.round(_d/86400) +' '+ _t.days;
        else if (_d < 5356800) _string = _t.month;
        else if (_d < 31536000) _string = Math.round(_d/2678400) +' '+ _t.months;
        else if (_d < 63072000) _string = _t.year;
        else _string = Math.round(_d/31536000) +' '+ _t.years;
        if ($span) {
            _now = new Date ($seed*1000);
            return '<span title="'+_now.toLocaleString()+'">'+_string + ' '
            + _t.ago+'<\/span>';
        }
        return _string + ' ' + _t.ago;
    };
    $.aqStamp.text = {
        seconds: 'few seconds',
        minute:  'about a minute',
        minutes: 'minutes',
        hour:    'over an hour',
        hours:   'hours',
        day:     'over a day',
        days:    'days',
        month:   'over a month',
        months:  'months',
        year:    'over a year',
        years:   'years',
        ago:     'ago'
    };
})(jQuery);