$(document).ready(function () {

    var missionLeadInput = $('#missiongateform-mission_lead_rpn');

    missionLeadInput.on('input', function () {
        var rpn = $(this).val();
        if(!rpn.match(/([A-Z]{2}\-[0-9]{5})/)) {
            return null;
        }
        window.location.replace($(this).data('load') + '?id=' + rpn)
    });

    missionLeadInput.on('focus', function () {
        console.log('focus');
        $(this).val('');
    });

});