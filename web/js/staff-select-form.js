
$(document).ready(function () {

    var searchList = $("#index-search-table");
    var selectionList = $("#staff-selection-table");

    function addStaff(row) {
        var id = row.data("id");
        if(selectionList.find('[data-id=' + id + ']').length === 0) {
            row = row.clone();
            selectionList.find("tbody").append(row);
            row.find(".staff-select-checkbox").attr("checked", true);
        }
    }

    function removeStaff(row) {
        row.remove();
    }

    searchList.click(function (e) {
        var target = $(e.target);
        if(target.is(".add-staff")) {
            var row = target.closest("tr");
            addStaff(row);
        }
        if(target.is(".add-all-staff")) {
            searchList.find("tbody tr").each(function () {
                addStaff($(this));
            });
        }
    });

    selectionList.click(function (e) {
        var target = $(e.target);
        if(target.is(".remove-staff")) {
            var row = target.closest("tr");
            removeStaff(row);
        }
        if(target.is(".remove-all-staff")) {
            selectionList.find("tbody tr").each(function () {
                removeStaff($(this));
            });
        }
    });


});