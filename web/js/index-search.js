
$(document).ready(function () {

    // searching results

    var form = $("#index-search-form");
    var searchResultTarget = $("#index-search-table").find("tbody");
    var formFields = $("[form='index-search-form']");
    var formInputs = $("input[form='index-search-form']");
    var formSelects = $("select[form='index-search-form']");
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

    $(".search-clear").click(function () {
        formInputs.val("");
        formSelects.select2("val", "");
    });

    // ajax dialogs


    // function ajaxActionGetHtml(actionUrl, data, callback) {
    //     data = typeof data === "undefined" ? [] : data;
    //     $.get({
    //         url: actionUrl,
    //         data: data,
    //         dataType: "html"
    //     }).done(function (html) {
    //         callback(html);
    //     })
    // }
    //
    // $("a.ajax-dialog").click(function (e) {
    //     e.preventDefault();
    //     var actionUrl = $(this).attr("href");
    //     var size = $(this).data("size");
    //     size = size ? size : "lg";
    //     ajaxActionGetHtml(actionUrl, [], function (content) {
    //         var AjaxDialog = new Dialog({
    //             size: size,
    //             buttons: [],
    //             content: content,
    //             start: function (dialog) {
    //                 setupAnimatedFormLabels(dialog.contentElement);
    //                 console.log("loaded");
    //
    //             }
    //         });
    //     });
    // });

});