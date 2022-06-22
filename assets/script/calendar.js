(jQuery)(function($){

    $('body').on('click', '#displayCalendar > .changeMonth', function(){
        var dateCalendar = date.calendar;
        if($(this).is('#backMonth'))
            dateCalendar.setMonth(dateCalendar.getMonth() - 1);
        else
            dateCalendar.setMonth(dateCalendar.getMonth() + 1);

        date.calendar = new Date( Date.parse( dateCalendar.toDateString() ) );

        setCalendar();
    });
});