
$.fn.ticker = function() {
    var ticker = $(this);
    var refreshUrl = ticker.data('refresh');
    var screenWidth = $(window).width();

    ticker.MessagesBlock = function(messages) {
        var block = $('<div class="ticker-block"></div>');
        ticker.append(block);

        if(messages.length > 0) {
            block.append('<span class="delimiter">' + $.fn.ticker.options.delimiter + '</span>');
        }
        $.each(messages, function (i, message) {
            block.append('<span class="message">' + message + '</span>');
            block.append('<span class="delimiter">' + $.fn.ticker.options.delimiter + '</span>');
        });

        var blockWidth = 0;
        $.each(block.children(), function () {
            blockWidth += $(this).width();
        });

        var animationTime = blockWidth / $.fn.ticker.options.speed * 1000;
        block.css({
            'left': screenWidth
        });
        block.animate({
            left: -blockWidth - screenWidth,
            easing: 'linear'
        }, animationTime, function () {
            block.remove();
            ticker.loadMessages();
        })
    };

    ticker.loadMessages = function() {
        $.get({
            url: refreshUrl,
            type: 'json',
            success: function (data) {
                var messages = JSON.parse(data);
                ticker.MessagesBlock(messages);
            }
        });
    };

    ticker.loadMessages();
};
$.fn.ticker.options = {
  speed: 30,
  delimiter: ' +++ '
};

$(document).ready(function () {
    $('.ticker').ticker();
});