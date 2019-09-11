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

    // input masks

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    $('.mask-date').mask('00.00.0000', {placeholder: 'dd.mm.yyyy'}).addClass('has-content');
    $('.mask-datetime').mask('00.00.0000 00:00', {placeholder: 'dd.mm.yyyy HH:ii'}).addClass('has-content');
    $('.mask-duration').mask('00:00', {placeholder: 'HH:MM', reverse: true}).addClass('has-content');
    $('.mask-sid').mask('AA-00000', {
        onKeyPress: function(cep, event, currentField, options){
            if(isNumber(cep.substr(0, 1)) || isNumber(cep.substr(1, 1))) {
                cep = "";
            }
            cep = cep.substr(0, 2).toUpperCase() + cep.substr(2);
            currentField.val(cep);
        }
    });
    $('.mask-callsign').mask('AA-00', {
        onKeyPress: function(cep, event, currentField, options){
            if(isNumber(cep.substr(0, 1)) || isNumber(cep.substr(1, 1))) {
                cep = "";
            }
            cep = cep.substr(0, 2).toUpperCase() + cep.substr(2);
            currentField.val(cep);
        }
    });

    // rotating icons

    $('img.rotate').each(function () {
        var element = $(this);
        var width = element.width();
        var height = element.height();
        var speed = typeof element.attr('speed') !== 'undefined' ? parseInt(element.attr('speed')) : 2000;
        var images = typeof element.attr('images') !== 'undefined' ? JSON.parse(element.attr('images')) : [element.attr('src')];
        var currentImage = 0;
        var flipped = false;
        element.attr('src', images[currentImage]);

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
            if(flipped === true) {
                element.css({
                    '-webkit-transform': '',
                    transform: ''
                });
                flipped = false;
            } else {
                element.css({
                    '-webkit-transform': 'scaleX(-1)',
                    transform: 'scaleX(-1)'
                });
                flipped = true;
            }
        };
        element.nextImage = function() {
            currentImage++;
            if(typeof images[currentImage] === "undefined") {
                currentImage = 0;
            }
            element.attr('src', images[currentImage]);
        };

        element.rotate = function() {
            element.shrink(function () {
                element.flip();
                element.nextImage();
                element.extend(function () {
                    element.shrink(function () {
                        element.flip();
                        element.nextImage();
                        element.extend(element.rotate);
                    });
                });
            });
        };

        var maxChecks = 100;
        var checkAmount = 0;
        element.startCheck = function() {
            checkAmount++;
            width = element.width();
            height = element.height();
            if(width === 0 && height === 0 && maxChecks <= maxChecks) {
                setTimeout(element.startCheck, 5);
            } else {
                element.rotate();
            }
        };
        element.startCheck();
    });

    // system failure

    var isLockedUrl = $("#check-lock-url").data('url');
    var isLocked = null;
    $.get(isLockedUrl).done(function (response) {
        isLocked = response;
    });
    var checkLockLoop = function () {
        setTimeout(function () {
            $.get(isLockedUrl).done(function (response) {
                if (response !== isLocked) {
                    window.location.reload();
                }
                checkLockLoop();
            });
        }, 20000);
    };
    checkLockLoop();

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
                setupContent(handle.target);
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

    // accordion

    var accordionSpeed = 250;
    $(".accordion-toggle").click(function (e) {
        if($(e.target).is("a") || $(e.target).parents("a").length !== 0) {
            return null;
        }
        var accordionSelect = $(this).data("toggle");
        var accordionContent = $(accordionSelect);

        var toggleButton = $(this).hasClass("accordion-button") ? $(this) : $(this).find(".accordion-button");

        if(accordionContent.is(":visible")) {
            toggleButton.removeClass("glyphicon-menu-up").addClass("glyphicon-menu-down");
            accordionContent.slideUp(accordionSpeed);
        } else {
            toggleButton.removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
            accordionContent.slideDown(accordionSpeed);
        }
    });

});