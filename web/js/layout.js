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

$.fn.alertBox.options.theme = 'black';
$.fn.alertBox.options.enableHeading = false;

function addMessage(data) {
    $('body').alertBox(data);
}

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

    $('.table-search-form').each(function () {
        var targetTable = $($(this).data('target-table'));
        targetTable.on('update', function () {
            setupContent($(this));
        });
    });

    $(document).ready(function () {
        $('.dropdown-toggle').dropdown()
    });
    $('.dropdown').hover(function () {
        $(this).children(".dropdown-menu").show();
    }, function () {
        $(this).children(".dropdown-menu").hide();
    });

    // input masks

    $('.mask-date').mask('00.00.0000', {placeholder: 'dd.mm.yyyy'}).addClass('has-content');
    $('.mask-datetime').mask('00.00.0000 00:00', {placeholder: 'dd.mm.yyyy HH:ii'}).addClass('has-content');
    $('.mask-duration').mask('00:00', {placeholder: 'HH:MM', reverse: true}).addClass('has-content');
    $('.mask-rpn').mask('AA-00000', {
        onKeyPress: function(cep, event, currentField, options){
            function isNumber(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }
            if(isNumber(cep.substr(0, 1)) || isNumber(cep.substr(1, 1))) {
                cep = "";
            }
            cep = cep.substr(0, 2).toUpperCase() + cep.substr(2);
            currentField.val(cep);
        }
    });

    // rotating icons

    $('.rotate').each(function () {
        var element = $(this);
        var width = element.width();
        var height = element.height();
        var speed = typeof element.attr('speed') !== 'undefined' ? parseInt(element.attr('speed')) : 2000;
        console.log(speed);

        element.shrink = function (callback) {
            element.animate({
                width: 0,
                height: height
            }, speed, callback);
        };
        element.extend = function (callback) {
            element.animate({
                width: width,
                height: height
            }, speed, callback);
        };
        element.flip = function() {
            if(element.css('transform') === "matrix(-1, 0, 0, 1, 0, 0)") {
                element.css({
                    '-webkit-transform': '',
                    transform: ''
                });
            } else {
                element.css({
                    '-webkit-transform': 'scaleX(-1)',
                    transform: 'scaleX(-1)'
                });
            }
        };

        element.rotate = function() {
            element.shrink(function () {
                element.flip();
                element.extend(function () {
                    element.shrink(function () {
                        element.flip();
                        element.extend(element.rotate);
                    });
                });
            });
        };
        element.rotate();
    });

    // reload button

    var ContentReloadHandle = new function () {
        var handle = this;
        handle.timer = null;
        handle.target = $('.reload-target');
        handle.url = location.href;

        handle.start = function () {
            if (handle.target.length === 0) {
                console.error('No reload target found');
            }
            $.get(handle.url).success(function (html) {
                handle.target.html(html);
            });
            handle.timer = setTimeout(handle.start, 5000);
        };

        handle.stop = function () {
            if (handle.timer) {
                clearTimeout(handle.timer);
            }
        };
    };

    if ($('.btn-auto-reload.active').length !== 0) {
        ContentReloadHandle.start();
    }
    $('.btn-auto-reload').click(function () {
        var btn = $(this);

        if (btn.is('.active')) {
            btn.removeClass('active');
            ContentReloadHandle.stop();
        } else {
            btn.addClass('active');
            ContentReloadHandle.start();
        }
    });

    // checkbox groups

    $(".group-control-checkbox").click(function () {
        var groupDiv = $(this).closest(".checkbox-group");
        var groupedCheckboxes = groupDiv.find("input[type=checkbox]");
        if ($(this).prop("checked") === true) {
            groupedCheckboxes.prop("checked", true);
        } else {
            groupedCheckboxes.prop("checked", false);
        }
    });
    $(".checkbox-group input[type=checkbox]:not(.group-control-checkbox)").click(function () {
        var groupControlCheckbox = $(this).parents(".checkbox-group").find(".group-control-checkbox");
        groupControlCheckbox.prop("checked", false);
    });
    $(".checkbox-group").each(function () {
        var checkboxGroup = $(this);
        var checkboxes = checkboxGroup.find("input[type=checkbox]:not(.group-control-checkbox)");
        var checkedCheckboxes = checkboxGroup.find("input[type=checkbox]:not(.group-control-checkbox):checked");
        if (checkboxes.length === checkedCheckboxes.length) {
            var groupControlCheckbox = checkboxGroup.find(".group-control-checkbox");
            groupControlCheckbox.prop("checked", true);
        }
    });

});