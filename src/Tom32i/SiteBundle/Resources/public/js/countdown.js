function play(target, to)
{
    console.log("%o : %s", target, to);

    var aa = target.find("li.from");
    var bb = target.find("li.to");
    var from = bb.find('.inn').first().html();

    aa.find('.inn').html(from);

    target.removeClass("play");

    aa.removeClass("active").removeClass("before");
    bb.removeClass("active").removeClass("before");

    bb.find('.inn').html(to);

    aa.addClass("before");
    bb.addClass("active");

    setTimeout(function () {  target.addClass("play"); }, 1);
}

function refresh()
{
    var new_diff = Math.floor(newyear - ( new Date().getTime() / 1000 ));

    if(new_diff != diff)
    {
        if(new_diff <= 0)
        {
            clearInterval(interval);

            play( y3, 3 );

            play( s1, 0 );
            play( s0, 0 );
            play( m1, 0 );
            play( m0, 0 );

            $("body").addClass("new");
        }
        else
        {
            diff = new_diff;

            var diff_minutes = Math.floor(diff / 60);
            var diff_seconds = diff - (diff_minutes * 60);

            diff_minutes = ( diff_minutes < 10 ? "0" : "" ) + diff_minutes.toString();
            diff_seconds = ( diff_seconds < 10 ? "0" : "" ) + diff_seconds.toString();

            var minutes_0 = diff_minutes.charAt(0);
            var minutes_1 = diff_minutes.charAt(1);
            var seconds_0 = diff_seconds.charAt(0);

            play( s1, diff_seconds.charAt(1) );

            if(seconds_0 != seconds[0])
            {
                play( s0, seconds_0 );
                seconds[0] = seconds_0;
            }

            if(minutes_1 != minutes[1])
            {
                play( m1, minutes_1 );
                minutes[1] = minutes_1;
            }

            if(minutes_0 != minutes[0])
            {
                play( m0, minutes_0 );
                minutes[0] = minutes_0;
            } 
        }
        
    }
}

var interval, newyear, diff, seconds, minutes, s0, s1, m0, m1, y3;

$(function() 
{
    $('body').on('click', function() {
        document.documentElement.webkitRequestFullScreen();
    });

    newyear = new Date("January 1, 2013 00:00:00").getTime() / 1000;
    //newyear = (new Date().getTime() / 1000) + 10;

    seconds = [0, 0];
    minutes = [0, 0];

    s0 = $("#seconds_0");
    s1 = $("#seconds_1");
    m0 = $("#minutes_0");
    m1 = $("#minutes_1");
    y3 = $("#year_3");

    $(".background.pink").show();
    $("#happynewyear").show();

    interval = setInterval(function () { refresh(); }, 10);
});