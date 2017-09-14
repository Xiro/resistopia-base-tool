
$(document).ready(function () {

    // searching results

    var form = $("#index-search-form");
    var searchResultTarget = $("#index-search-table").find("tbody");
    var formFields = $("[form='index-search-form']");
    var formInputs = $("input[form='index-search-form']");
    var formSelects = $("select[form='index-search-form']");
    var datePicker = $(".date-picker input[form='index-search-form']");
    var sendTimeOut;

    function sendSearchForm() {
        var actionUrl = form.attr("action");
        var formData = formFields.serialize();
        $.ajax({
            method: "get",
            url: actionUrl,
            data: formData,
            dataType: "html"
        }).done(function (data) {
            searchResultTarget.html(data);
        });
    }

    formInputs.on("keyup", function () {
        clearTimeout(sendTimeOut);
        sendTimeOut = setTimeout(function () {
            sendSearchForm();
        }, 400);
    });
    formSelects.on("change", function () {
        sendSearchForm();
    });
    datePicker.on("changeDate", function () {
        sendSearchForm();
    });

    $(".search-clear").click(function () {
        formInputs.val("");
        formSelects.select2("val", "");
    });

});