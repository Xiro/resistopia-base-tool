
function setupAnimatedFormLabels(contentElement) {

    contentElement.find('select option[selected]').each(function () {
        var input = $(this).parent();
        var label = input.parent().children("label");

        if(!label.hasClass("move")) {
            label.addClass("no-transition");
        }

        input.addClass("has-content").delay(500, function () {
            label.removeClass("no-transition");
        });
    });

    contentElement.find("select").on("select2:opening", function () {
        $(this).parent().find("label").addClass("move");
    });
    contentElement.find("select").on("select2:close select2:select select2:unselect change", function () {
        var choices = $(this).parent().find(".select2-selection__choice");
        var search = $(this).parent().find(".select2-search__field");
        if(choices.length !== 0 || search.length !== 0) {
            if(choices.length === 0 && search.val().length === 0) {
                $(this).parent().find("label").removeClass("move");
            } else {
                $(this).parent().find("label").addClass("move");
            }
        } else {
            if(!$(this).val().length) {
                $(this).parent().find("label").removeClass("move");
            } else {
                $(this).parent().find("label").addClass("move");
            }
        }
    });

    contentElement.find('.date-picker input').on("changeDate", function () {
        if(!$(this).val().length) {
            $(this).parent().find("label").removeClass("move");
        } else {
            $(this).parent().find("label").addClass("move");
        }
    });

    contentElement.find('textarea').each(function () {
        if($(this).val() !== "" || typeof  $(this).attr('placeholder') !== "undefined") {
            var label = $(this).parent().children("label");
            label.addClass("no-transition");
            $(this).addClass("has-content").delay(500, function () {
                label.removeClass("no-transition");
            });
        }
    });

    function toggleLabelForInputs(element) {
        if((element.val() === null || element.val().length === 0) && typeof element.attr('placeholder') === 'undefined') {
            element.removeClass("has-content")
                .removeAttr("value");
        } else {
            element.addClass("has-content");
        }
    }
    var simpleElements = contentElement.find('input[type="text"], input[type="password"], select, textarea');
    simpleElements.each(function () {
        toggleLabelForInputs($(this));
    });
    simpleElements.focusout(function () {
        toggleLabelForInputs($(this));
    });

    contentElement.find(".animated-label").css("visibility", "visible");
}

if(typeof contentSetupFunctions !== "undefined") {
    contentSetupFunctions.push(setupAnimatedFormLabels);
} else {
    $(document).ready(function () {
        setupAnimatedFormLabels($("body"));
    });
}
