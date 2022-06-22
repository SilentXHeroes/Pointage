(jQuery)(function($){

    var extraWork = {H: 0, M: 0},
        pointages = getStat('days'),
        timeSet = {
            h: $('body').find('#timeH > p').text(),
            m: $('body').find('#timeM > p').text(),
            s: $('body').find('#timeS > p').text()
        };
    setClockCss(timeSet);
    if(!inBreakingTime && !notStart && !dayOver)
        launchWorkTime();

    $.each(pointages, function(key, ptg){
        var timeToWork = program[parseInt(ptg.id_day)-1].work_time.split(':');
        $.each(timeToWork, function(key, time){
            time = parseInt(time);
        });
        var H = timeToWork[0],
            M = timeToWork[1];

        console.log('======');
        console.log(extraWork);
        console.log(ptg.time);
        console.log(timeToWork);
        if(ptg.time.H - H < 0){
            extraWork.M -= (M > ptg.time.M ? M : 60) - ptg.time.M;

            if(M < ptg.time.M)
                extraWork.H++;

            if(extraWork.M < 0){
                extraWork.H--;
                extraWork.M = 60 + extraWork.M;
            }
            extraWork.H += ptg.time.H - H;
        }else{
            extraWork.M += ptg.time.M - M;
        }
        console.log('======');

        var addH = ptg.time.H - H;
        var addM = ptg.time.M - M;
        if(extraWork.M >= 60){
            extraWork.H++;
            console.log('M => +'+addM+' => '+(extraWork.M - 60));
            extraWork.M = extraWork.M - 60;
        }else{
            console.log('M => +'+addM);
        }
        console.log('H => +'+addH);

        console.log('');
        console.log('////////////////////');
        console.log('');
    });
    $('#statsUser > #timeSupp > p').html('<span class="color">'+extraWork.H+'</span><span>h</span><span class="color">'+extraWork.M+'</span>');

    $('body').on('click', '#buttons > span', function(){
        var event;
        if($(this).is('#pause')){
            $('#buttons').addClass('pause');
            $('#time').addClass('inPause');
            event = 'BR';
            clearTimeout(upTime);
            upTime = 0;
        }
        else if($(this).is('#goToWork')){
            $('#time').removeClass('inPause');
            $('#buttons').removeClass('pause');
            launchWorkTime();
            event = 'W';
        }
        else if($(this).is('#leave')){
            $('#buttons').addClass('end');
            event = 'E';
            clearTimeout(upTime);
            upTime = 0;
        }
        else if($(this).is('#start')){
            $('#buttons').removeClass('begin');
            launchWorkTime();
            event = 'B';
        }

        $.ajax({
            url: base+'workTime/setPointage/1/'+event,
            type: 'POST',
            dataType: 'JSON',
            data: {},
            success: function(data){}
        });
    });

    $(window).on('focus', function(){
        $.ajax({
            url: base+'workTime/getEventTime/1/workTime',
            type: 'POST',
            dataType: 'JSON',
            data: {},
            success: function(time){
                if(time !== false){
                    setWorkTime({
                        h: time.H,
                        m: time.M,
                        s: time.S
                    });
                }
            }
        });
    });

    var upTime = 0;
    function launchWorkTime(){
        upTime = setTimeout(function(){
            var workTime = getWorkTime();

            workTime.s = workTime.s + 1;

            setWorkTime(workTime, true);
            launchWorkTime();
        }, 1000);
    }

    function setToTime(intVal){
        intVal = String(intVal);
        if (intVal.length === 1)
            return '0'+intVal;
        else
            return intVal;
    }

    function getWorkTime(){
        return {
            h:  parseInt($('body').find('#timeH > p').text()),
            m:  parseInt($('body').find('#timeM > p').text()),
            s:  parseInt($('body').find('#timeS > p').text())
        };
    }

    function setWorkTime(workTime, fromClock = false){
        if(workTime.s >= 60){
            do {
                workTime.m++;
                workTime.s -= 60;
            }while(workTime.s >= 60);
            if(fromClock)
                workTime.s = 0;
        }
        if(workTime.m >= 60){
            do {
                workTime.h++;
                workTime.m -= 60;
            }while(workTime.m >= 60);
            if(fromClock)
                workTime.m = 0;
        }
        workTime.h = setToTime(workTime.h);
        workTime.m = setToTime(workTime.m);
        workTime.s = setToTime(workTime.s);

        $('body').find('#timeH > p').text(workTime.h);
        $('body').find('#timeM > p').text(workTime.m);
        $('body').find('#timeS > p').text(workTime.s);
        setClockCss(workTime);
    }

    function setClockCss(time){
        if(time.h === '00')
            $('#timeH > p').addClass('null');
        else
            $('#timeH > p').removeClass('null');
        if(time.m === '00')
            $('#timeM > p').addClass('null');
        else
            $('#timeM > p').removeClass('null');
        if(time.s === '00' && time.m === '00')
            $('#timeS > p').addClass('null');
        else
            $('#timeS > p').removeClass('null');
    }
});