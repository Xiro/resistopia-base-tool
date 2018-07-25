jQuery.fn.outerHTML = function (s) {
    return s
        ? this.before(s).remove()
        : jQuery("<p>").append(this.eq(0).clone()).html();
};

function setupInjuriesAfterActiveForm() {
    $(document).ready(function () {

        var form = $("#medicine-form");
        var injuryRowsContainer = $(".injury-rows");
        var injuryRowCount = injuryRowsContainer.find(".injury-row").length - 1; // minus template

        var injuryTemplate = injuryRowsContainer.find(".injury-row-template");
        var injuryTemplateHtml = injuryTemplate.outerHTML();
        injuryTemplate.remove();

        var injuryImage = $('.injury-select-img');
        var injuryMarkTemplate = $('<div class="injury-mark"><span class="glyphicon glyphicon-screenshot"></span><span class="badge"></span></div>');

        // reset form validation
        var defaultValidators = [];
        var formAttributes = form.data("yiiActiveForm").attributes;
        $.each(formAttributes, function (i, data) {
            if (
                typeof data !== "undefined"  &&
                (
                    data.id.indexOf("medicinecheckupinjury") !== -1
                    || data.id.indexOf("medicinetreatmentinjury") !== -1
                )
            ) {
                if (data.input.indexOf("__id__") !== -1) {
                    defaultValidators.push(data);
                    delete formAttributes[i];
                } else {
                    var key = $(data.container).parents("[data-key]").data("key");
                    data.id += "-" + key;
                }
            }
        });

        function addInjuryRow(e) {
            var newMark = injuryMarkTemplate.clone();
            var relativeY = (e.pageY - injuryImage.offset().top) / injuryImage.height() * 100;
            var relativeX = (e.pageX - injuryImage.offset().left) / injuryImage.width() * 100;
            newMark.css({
                top: relativeY + '%',
                left: relativeX + '%'
            });
            var markCount = injuryImage.find('.injury-mark').length + 1;
            newMark.find('.badge').html(markCount);
            newMark.attr('data-key', markCount);
            injuryImage.append(newMark);

            var key = 'new' + injuryRowCount;
            var newRow = $(injuryTemplateHtml.replace(/__id__/g, key))
                .removeClass("injury-row-template")
                .data("key", key)
                .attr('data-mark', markCount)
                .show();

            console.log(newRow.find('.input-x'));
            newRow.find('.input-x input').val(relativeX);
            newRow.find('.input-y input').val(relativeY);

            $.each(defaultValidators, function () {
                var validation = $.extend(true, {}, this); // clone default object
                validation.container = validation.container.replace(/__id__/g, key);
                validation.input = validation.input.replace(/__id__/g, key);
                validation.id += '-' + key;
                form.yiiActiveForm("add", validation);
            });

            injuryRowsContainer.append(newRow);
            injuryRowCount++;
            newRow.find('select').select2();
            newRow.find('.select2-container').addClass('select2-container--krajee');
            setupAnimatedFormLabels(injuryRowsContainer);
            updateMarkOrder();
            setupRemoveButton(newRow);
        }

        function updateMarkOrder() {
            var order = 0;
            injuryRowsContainer.find(".injury-row").each(function () {
                order++;
                $(this).attr('data-mark', order);
            });
            order = 0;
            injuryImage.find('.injury-mark').each(function () {
                order++;
                $(this).attr('data-key', order);
                $(this).find('.badge').html(order);
            });
        }

        function setupRemoveButton(rows) {
            rows = typeof rows === "undefined" ? injuryRowsContainer.find(".injury-row") : rows;
            rows.each(function () {
                var row = $(this);
                row.find(".remove-injury-row").click(function (e) {
                    e.preventDefault();
                    var key = row.data("key");
                    var formAttributes = form.data("yiiActiveForm").attributes;
                    $.each(formAttributes, function (i, data) {
                        if (typeof data !== "undefined" && data.id.indexOf(key) !== -1) {
                            delete formAttributes[i];
                        }
                    });
                    injuryImage.find('.injury-mark[data-key="' + row.attr('data-mark') + '"]').remove();
                    row.remove();
                    updateMarkOrder();
                });
            });
        }

        updateMarkOrder();
        setupRemoveButton();

        injuryImage.click(function (e) {
            addInjuryRow(e);
        });

    });
}

function setupMedicationsAfterActiveForm() {
    $(document).ready(function () {
        var form = $("#medicine-form");
        var medicationRowsContainer = $(".medication-rows");
        var newMedicationButton = $("button.new-medication-row");
        var medicationRowCount = medicationRowsContainer.find(".medication-row").length - 1; // minus template

        var medicationTemplate = medicationRowsContainer.find(".medication-row-template");
        var medicationTemplateHtml = medicationTemplate.outerHTML();
        medicationTemplate.remove();

        // reset form validation
        var defaultValidators = [];
        var formAttributes = form.data("yiiActiveForm").attributes;
        $.each(formAttributes, function (i, data) {
            if (typeof data !== "undefined" && data.id.indexOf("medicinetreatmentmedication") !== -1) {
                if (data.input.indexOf("__id__") !== -1) {
                    defaultValidators.push(data);
                    delete formAttributes[i];
                } else {
                    var key = $(data.container).parents("[data-key]").data("key");
                    data.id += "-" + key;
                }
            }
        });

        function addMedicationRow() {
            var key = 'new' + medicationRowCount;
            var newRow = $(medicationTemplateHtml.replace(/__id__/g, key))
                .removeClass("medication-row-template")
                .data("key", key)
                .show();

            $.each(defaultValidators, function () {
                var validation = $.extend(true, {}, this); // clone default object
                validation.container = validation.container.replace(/__id__/g, key);
                validation.input = validation.input.replace(/__id__/g, key);
                validation.id += '-' + key;
                form.yiiActiveForm("add", validation);
            });

            medicationRowsContainer.append(newRow);
            medicationRowCount++;

            newRow.find('.select-location').select2();
            newRow.find('.select-drug').select2({
                tags: true
            });
            newRow.find('.select2-container').addClass('select2-container--krajee');

            setupAnimatedFormLabels(medicationRowsContainer);
            setupRemoveButton(newRow);
        }

        function setupRemoveButton(rows) {
            rows = typeof rows === "undefined" ? medicationRowsContainer.find(".medication-row") : rows;
            rows.each(function () {
                var row = $(this);
                row.find(".remove-medication-row").click(function (e) {
                    e.preventDefault();
                    var key = row.data("key");
                    var formAttributes = form.data("yiiActiveForm").attributes;
                    $.each(formAttributes, function (i, data) {
                        if (typeof data !== "undefined" && data.id.indexOf(key) !== -1) {
                            delete formAttributes[i];
                        }
                    });
                    row.remove();
                });
            });
        }

        setupRemoveButton();

        newMedicationButton.on("click", function (e) {
            e.preventDefault();
            addMedicationRow();
        });

    });
}
