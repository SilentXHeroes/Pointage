var statsW = $('#stats').width(),
    statsH = $('#stats').height(),
    showStats = 'totalTimeWorkedByDay',
    activeController = 'workTime';

(jQuery)(function($){

	$('header > nav a').on('click', function(){
		var controller = $(this).data('href');

		if(controller === 'user'){

		}else{
			$('#window > .window').removeClass('next');
			$('#'+controller+'_container').addClass('next');

			$('#window > .window').addClass('inactive');
			$('#'+controller+'_container').removeClass('inactive');

			if(activeController !== controller){
				switch(controller){
					case 'calendar':
						setCalendar();
						break;
					case 'stats':
						getStats();
						break;
				}
			}
			activeController = controller;
		}
	});

	$('body').on('click', '#days > div', function(){
		$(this).toggleClass('selected');
	});

	$('body').on('click', '.checkBoxes', function(){
		if(!$(this).find('input').is(':checked')){
			$(this).find('input').attr('checked', true);
		}
		else{
			$(this).find('input').removeAttr('checked');
		}
	});
});

/******
	GLOBALS FUNCTIONS
*******/

function setCalendar(action = ''){
	date.now = new Date();
    hideLoader();
    var getMonth = date.calendar.getMonth(),
        getYear  = date.calendar.getFullYear(),
        browseMonth = new Date(getYear, getMonth),
        days = [];

    while(getMonth === browseMonth.getMonth()){
    	days.push(browseMonth.getDate());

        browseMonth.setDate(browseMonth.getDate() + 1);
        browseMonth = new Date( Date.parse( browseMonth.toDateString() ) );
    };

    var dateCase = '';
    $.each(days, function(index, day) {
        key = parseInt(day);
        if(key === 1)
            dateCase += '<div class="caseContainer">';
        dateCase += '<div class="case hide'+(day == date.now.getDate() && getMonth == date.now.getMonth() && getYear == date.now.getFullYear() ? ' activeDay' : '')+'">'
                        +'<p>'+day+'</p>'
                    +'</div>';
        if(key % 7 === 0 && key > 0)
            dateCase += '</div><div class="caseContainer">';
    });

    $('#calendar_container #displayDays').html(dateCase);
    $('#infosCalendar > .activeMonth').text(months[getMonth]);
    $('#infosCalendar > .activeYear').text(getYear);
    setTimeout(function(){
        showLoader();
    }, 200);
}

function showLoader(){
    var delay = 0;
    $('.case').each(function(){
    	$(this).css('transition-delay', delay+'s');
    	delay += 0.01;
    });
    $('.case').removeClass('hide');
    setTimeout(function(){
		$('.case').css('transition-delay', '0s');
    },30);
}
function hideLoader(){
	$('.case').css('transition-delay', '0s');
    $('.case').addClass('hide');
}