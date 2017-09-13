
$(document).ready(function () {

    var form = $("#staff-search-form");
    var searchResultTarget = $("#staff-table").find("tbody");
    var formFields = $("[form='staff-search-form']");
    var formInputs = $("input[form='staff-search-form']");
    var formSelects = $("select[form='staff-search-form']");
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
        }, 800);
    });
    formSelects.on("change", function () {
        sendSearchForm();
    });

    $(".search-clear").click(function () {
        formInputs.val("");
        formSelects.select2("val", "");
    });
});