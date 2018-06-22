
function ajaxActionGetHtml(actionUrl, data, callback) {
    data = typeof data === "undefined" ? [] : data;
    $.get({
        url: actionUrl,
        data: data,
        dataType: "html"
    }).done(function (html) {
        callback(html);
    })
}

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/****************
 * FLASH MESSAGES
 *****************/

var boxCount = 0;
var alertBoxes = $("#flash-messages");

function addMessage(data) {
    var type = data.type;
    if(!type) {
        type = data.status;
    }
    var messageText = data.message;
    if (!type) {
        type = "success";
    }

    // message visibility based on word count
    // 210 W/m (3.5 W/s) + 2 seconds reaction time and buffer
    var wordCount = messageText.trim().split(/\s+/).length;
    var messageVisibilityTime = (wordCount / 3.5 + 2) * 1000;

    // status aliases
    switch (type) {
        case "error":
            type = "danger";break;
        case "skipped":
            type = "info";
    }

    var messageId = 'w4-' + type + '-' + boxCount;
    var msgHtml = '<div class="alert alert-' + type + '" id="' + messageId + '">';
    msgHtml += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    msgHtml += messageText;
    msgHtml += '</div>';

    if(alertBoxes.find(".alert").length >= 3) {
        alertBoxes.find(".alert").last().remove();
    }
    alertBoxes.prepend(msgHtml);
    alertBoxes.find("#" + messageId)
        .slideDown()
        .delay(messageVisibilityTime)
        .slideUp(function () {
            $(this).remove();
        })
    ;
    boxCount++;
}

$(document).ready(function () {
    // close initially loaded flash messages
    var messagesData = $("#flash-messages").data("messages");
    $.each(messagesData, function () {
        addMessage(this);
    });
});

var contentSetupFunctions = [];

function setupContent(contentElement) {
    for (var n = 0; n < contentSetupFunctions.length; n++) {
        contentSetupFunctions[n](contentElement);
    }
}

function setupAjaxDialog(contentElement) {
    contentElement.find("a.ajax-dialog").click(function (e) {
        e.preventDefault();
        var actionUrl = $(this).attr("href");
        var size = $(this).data("size");
        size = size ? size : "lg";
        ajaxActionGetHtml(actionUrl, [], function (content) {
            new Dialog({
                size: size,
                buttons: [],
                content: content,
                start: function (dialog) {
                    setupContent(dialog.contentElement);
                }
            });
        });
    });
}

contentSetupFunctions.push(setupAjaxDialog);

$(document).ready(function () {

    setupContent($("body"));

    $(document).ready(function(){
        $('.dropdown-toggle').dropdown()
    });
    $('.dropdown').hover(function () {
        $(this).children(".dropdown-menu").show();
    }, function () {
        $(this).children(".dropdown-menu").hide();
    });

    // input masks

    $('.mask-date').mask('00.00.0000', {placeholder: 'dd.mm.yyyy'}).addClass('has-content');

});