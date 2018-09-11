
$.fn.tableFormSelect = function() {
    var form = this;
    var searchList = form.find(".table-form-selectable");
    var selectionList = form.find(".table-form-selected");

    function addRow(row) {
        var id = row.data("key");
        if(selectionList.find('[data-key=' + id + ']').length === 0) {
            row = row.clone();
            selectionList.find("tbody").append(row);
            row.find(".table-form-select-checkbox").attr("checked", true);
            if(typeof setupContent === "function") {
                setupContent(row);
            }
        }
    }

    function removeRow(row) {
        row.remove();
    }

    searchList.click(function (e) {
        var target = $(e.target);
        if(target.is(".add-row")) {
            var row = target.closest("tr");
            addRow(row);
        }
        if(target.is(".add-all-rows")) {
            searchList.find("tbody tr").each(function () {
                addRow($(this));
            });
        }
    });

    selectionList.click(function (e) {
        var target = $(e.target);
        if(target.is(".remove-row")) {
            var row = target.closest("tr");
            removeRow(row);
        }
        if(target.is(".remove-all-rows")) {
            selectionList.find("tbody tr").each(function () {
                removeRow($(this));
            });
        }
    });
};

$(document).ready(function () {

    $('.table-form').each(function () {
        $(this).tableFormSelect();
    });

});