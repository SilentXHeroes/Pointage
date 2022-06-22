(jQuery)(function($){

    $.fn.loader = function(set){
        console.log(set);
        this.addClass('containerLoader');
        this.html(
            '<div class="circle"></div>'
            +'<div class="circle"></div>'
            +'<div class="circle"></div>'
            +'<div class="circle"></div>'
            +'<div class="circle"></div>'
            +'<div class="circle"></div>'
            +'<div class="circle"></div>'
            +'<div class="circle"></div>'
        );
        var width = set.widt !== undefined ? set.width : '150px',
            height = set.height !== undefined ? set.height : width;
        this.css({
            width: width,
            height: height
        });

        var circleW = set.circleW !== undefined ? set.circleW : '30px',
            circleH = set.circleH !== undefined ? set.circleH : circleW;
        this.find('.circle').css({
            width: circleW,
            height: circleH
        });

        var halfW = (width/2)-(circleW/2),
            halfH = (height/2)-(circleH/2);
        this.find('.circle:nth-child(1)').css({top: 0, left: 0});
        this.find('.circle:nth-child(2)').css({top: 0, left: halfW});
        this.find('.circle:nth-child(3)').css({top: 0, right: 0});
        this.find('.circle:nth-child(4)').css({top: halfH, right: 0});
        this.find('.circle:nth-child(5)').css({bottom: 0, right: 0});
        this.find('.circle:nth-child(6)').css({bottom: 0, left: halfW});
        this.find('.circle:nth-child(7)').css({bottom: 0, left: 0});
        this.find('.circle:nth-child(8)').css({top: halfW, left: 0});
    };
});