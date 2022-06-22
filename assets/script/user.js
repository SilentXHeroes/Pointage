(jQuery)(function($){
    setClock($('#setBeginTime, #setBreakTime, #setWorkTime, #setEndTime'));

    $('body').on('click', '.setClock span', function(){
        var input = $(this).parent().find('> input'),
            set,
            to = input.val().length > 0 ? parseInt(input.val()) : 0,
            $clock = $(this).parents('.setClock').parent();

        if($(this).is('.hours')){
            set = 'hours';
            if($(this).is('.up')){
                to++;
                if(to > 11)
                    to = 0;
            }else{
                to--;
                if(to < 0)
                    to = 11;
            }
        }else{
            set = 'minutes';
            if($(this).is('.up')){
                to += 5;
                if(to > 55)
                    to = 0;
            }else{
                to -= 5;
                if(to < 0)
                    to = 55;
            }
        }

        // On définit l'heure
        input.val((to < 10 ? '0' : '') + to);

        controlClock($clock, set, to);
    });

    $('#connectInfos > div').on('click', function(){
        $(this).find('input').focus();
    });

    $('#connectInfos input').on('focus blur', function(evt){
        $('#connectInfos > div').removeClass('error');
        $('#errorMessage').hide();
        if(evt.type === 'focus')
            $(this).parent().addClass('focus');
        else
            $(this).parent().removeClass('focus');
    });

    $('#footerConnect button').on('click', function(){
        if($(this).is('#connectBtn')){
            $.ajax({
                url: base + 'user/connectUser',
                type: 'POST',
                dataType: 'JSON',
                data: {email: $('#email').val(), mdp: $('#mdp').val()},
                success: function(result){
                    if(result.error){
                        $('#errorMessage').show().text(result.message);
                        $('#errorMessage, #connectInfos > div').addClass('error');
                    }else{
                        $('a.home').click();
                        $('#connect').animate({
                                opacity: 0
                            }, 300, function() {
                                $('#connect').hide();
                                $('#main').removeClass('connect');
                        });
                    }
                }
            });
        }else{
        }
    });

    function setClock($elem){
        var clock =
            '<div class="clock">'
                +'<div class="feature high"></div>'
                +'<div class="feature clock5"></div>'
                +'<div class="feature clock10"></div>'
                +'<div class="feature clock15"></div>'
                +'<div class="feature clock20"></div>'
                +'<div class="feature clock25"></div>'
                +'<div class="feature needle small">'
                    +'<div></div>'
                +'</div>'
                +'<div class="feature needle big">'
                     +'<div></div>'
                +'</div>'
                +'<div class="center"></div>'
            +'</div>'
            +'<div class="setClock">'
                +'<div class="setHours">'
                    +'<div>'
                        +'<span class="icon-arrow-up up hours"></span>'
                        +'<input type="text"/>'
                        +'<span class="icon-arrow-down down hours"></span>'
                   +' </div>'
                    +'<p>heures</p>'
                +'</div>'
                +'<div class="setMinutes">'
                    +'<div>'
                        +'<span class="icon-arrow-up up minutes"></span>'
                        +'<input type="text"/>'
                        +'<span class="icon-arrow-down down minutes"></span>'
                    +'</div>'
                    +'<p>minutes</p>'
                +'</div>'
            +'</div>';

        $elem.css('position', 'relative');
        $elem.html(clock);

        $elem.each(function(){
            setViewClock($(this).find('> .clock'));
        });
    }

    function setViewClock($clock){
        var W = $clock.width(),
            H = $clock.height(),
            $all = $clock.find('.feature'),
            $features = $clock.find('.feature:not(.needle)'),
            $needles = $clock.find('.feature.needle'),
            $center = $clock.find('.center');

        $center.css({
            top: (H / 2) - ($center.height() / 2),
            left: (W / 2) - ($center.width() / 2)
        });

        $all.each(function(){
            var border = parseFloat($(this).css('border-bottom').split(' ')[0]);
            $(this).css({
                left: (H / 2) - ($(this).width() / 2),
                height: H - (border * 2)
            });
        });
    }

    function controlClock($clock, set, to){
        var needle,
            deg;

        if(set === 'hours'){
            needle = $clock.find('.needle.small');
        }else{
            needle = $clock.find('.needle.big');
            to = to / 5;
        }
        deg = 30 * to;
        needle.css('transform', 'rotate('+deg+'deg)');
    }
});