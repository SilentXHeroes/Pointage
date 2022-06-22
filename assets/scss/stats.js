(jQuery)(function($){
    console.log(stats);
    var extraWork = {H: 0,M: 0},
        pointages = getStat('days');

    $.each(pointages, function(key, ptg){
        var timeToWork = program[parseInt(ptg.id_day)-1].work_time.split(':'),
            H = timeToWork[0],
            M = timeToWork[1];

        console.log('======');
        console.log(extraWork);
        extraWork.H += ptg.time.H - H;
        extraWork.M += ptg.time.M - M;
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

        console.log(extraWork);
        console.log('');
        console.log('////////////////////');
        console.log('');
    });
});

function getStats(what = 'hours_worked_moy', when = 'day', total = false){
    var getMax = 0,
        reperesX,
        legendes = {
            X: 'Jours de la semaine',
            Y: 'Heures de travail'
        };

    if(what.match(/hours/)){
        var maxDay,
            maxM = 0,
            datesList = getStat('months'),
            daysList = [];
    }

    switch(what){
        case 'hours_worked_total':
            $.each(datesList, function(key, days){
                $.each(days, function(key, day){
                    if(daysList[day.id_day] === undefined){
                        daysList[day.id_day] = day.time;
                    }else{
                        daysList[day.id_day] = addTime(day.time, daysList[day.id_day]);
                    }
                });
            });

            $.each(daysList, function(day, times){
                var before = getMax;
                if(times !== undefined){
                    getMax = Math.max(getMax, timeToMinutes(times));
                    if(getMax > before){
                        maxDay = day;
                        maxM = times.M;
                    }
                    if(getMax === before && times.M > maxM)
                        maxM = times.H;
                }
            });
            getMax = minutesToTime(getMax).H;
            break;

        case 'hours_worked_moy':
            var moy,
                maxMoy = 0;
            $.each(datesList, function(key, days){
                $.each(days, function(key, day){
                    moy = timeToMinutes(day.time);
                    if(daysList[day.id_day] === undefined){
                        daysList[day.id_day] = {
                            time: moy,
                            nbDays: 1
                        };
                    }else{
                        daysList[day.id_day].time += moy;
                        daysList[day.id_day].nbDays += 1;
                    }
                });
            });

            var listMoy = {};
            $.each(daysList, function(day, infos){
                if(infos !== undefined){
                    var minutes = infos.time / infos.nbDays;
                    listMoy[day] = minutesToTime(minutes);
                    if(listMoy[day].H > maxMoy)
                        getMax = listMoy[day].H;
                    maxMoy = Math.max(listMoy[day].H, maxMoy);
                }
            });

            daysList = listMoy;
            break;
    }

    getMax += 5;
    reperesX = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    valuesX = [daysList[1],daysList[2],daysList[3],daysList[4],daysList[5],daysList[6],daysList[7]];

    setYBars(getMax, 1, legendes.Y);
    setXBars(getMax, reperesX, valuesX, legendes.X);
}

function getStat(what){
    var data = [];

    switch(what){
        case 'days':
            $.each(stats, function(year, months){
                $.each(months, function(month, monthDays){
                    $.each(monthDays, function(index, days){
                        data.push(days);
                    });
                });
            });
            break;

        case 'months':
            $.each(stats, function(year, months){
                $.each(months, function(month, monthDays){
                    data.push(monthDays);
                });
            });
            break;

        case 'years':
            break;
    }

    return data;
}



function setYBars(max, pas = 1, legende = ''){
    $('#stats > .legende.Y').text(legende);
    $('#stats > .legende.Y').css('top', 0 - $('#stats > .legende.Y').height() - 10);
    for(var i = 0; i < max; i = i + pas){
        $barre = $('<div class="barre Y" data-Y="'+(i*pas)+'"></div>');
        $repere = $('<div class="repere Y" data-Y="'+(i*pas)+'"><p></p></div>');
        $('#stats').append($barre);
        if(i % 5 === 0){
            $('#stats').append($repere);
            $barre.addClass('level');
            $repere.find('> p').text(i);
            $repere.css({
                bottom: (statsH / max) * i,
                left: 0 - $repere.width()
            });
        }
        $barre.css('bottom', (statsH / max) * i);
    }
}

function setXBars(max, cols, values, legende){
    var baseLeft = statsW / cols.length,
        toLeft = 0;
    $.each(cols, function(index, col){
        var $repereX = $('<div class="repere X day-'+(index+1)+'" data-id="'+index+'">'+col+'</div>'),
            $barreX = $('<div class="barre X" data-repere="day-'+(index+1)+'"></div>');
        $('#stats').append($repereX);
        $('#stats').append($barreX);
        if(values[index] !== undefined){
            var prct = (values[index].H / max) * 100;
            $barreX.css('height', (statsH * prct) / 100);
        }else{
            $barreX.css('height', 5);
        }
        $repereX.css({
            width: statsW / cols.length,
            bottom: 0 - $repereX.height() - 15
        });
        $barreX.css('width', baseLeft / 2);
        $repereX.css('left', toLeft);

        toLeft += baseLeft;
    });

    $('#stats > .barre.X').each(function(index, elem){
        $(this).css('left', (baseLeft * index) + (baseLeft / 2) - ($(this).width() / 2));
    });
}

function addTime(time, add){
    time.S += add.S;
    if(time.S >= 60){
        time.S = time.S - 60;
        time.M++;
    }
    time.M += add.M;
    if(time.M >= 60){
        time.M = time.M - 60;
        time.H++;
    }
    time.H += add.H;

    return time;
}

function timeToMinutes(time){
    return (time.H*60) + time.M + (time.S / 60);
}

function minutesToTime(minutes){
    var H = parseInt(minutes / 60),
        M = minutes - (H * 60),
        S = (minutes - parseInt(minutes)) * 60;

    return {
        'H': H,
        'M': parseInt(M),
        'S': parseInt(S)
    };
}