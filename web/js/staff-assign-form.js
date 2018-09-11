
$.fn.tableFormAssign = function() {
    var form = this;
    var leftList = form.find(".table-form-selectable");
    var rightList = form.find(".table-form-selected");

    function addRow(row, list, checked) {
        var id = row.data("key");
        if(list.find('[data-key=' + id + ']').length === 0) {
            row = row.clone();
            list.find("tbody").append(row);
            var checkbox = row.find(".table-form-select-checkbox");
            checkbox.attr("checked", checked);
            if(typeof setupContent === "function") {
                setupContent(row);
            }
        }
    }

    function removeRow(row) {
        row.remove();
    }

    function handleClick(e, thisList, otherList, checked) {
        var target = $(e.target);
        if(target.is(".add-row")) {
            var row = target.closest("tr");
            addRow(row, otherList, checked);
            removeRow(row);
        }
        if(target.is(".add-all-rows")) {
            thisList.find("tbody tr").each(function () {
                addRow($(this), otherList, checked);
                removeRow($(this));
            });
        }
    }

    leftList.click(function (e) {
        handleClick(e, leftList, rightList, true);
    });

    rightList.click(function (e) {
        handleClick(e, rightList, leftList, false);
    });
};

$(document).ready(function () {

    $('.table-form').each(function () {
        $(this).tableFormAssign();
    });

});