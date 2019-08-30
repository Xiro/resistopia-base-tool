$(document).ready(function () {

    var missionLeadInput = $('#missiongateform-mission_lead_sid');

    missionLeadInput.on('input', function () {
        var sid = $(this).val();
        if(!sid.match(/([A-Z]{2}\-[0-9]{5})/)) {
            return null;
        }
        window.location.replace($(this).data('load') + '?id=' + sid)
    });

    missionLeadInput.on('focus', function () {
        console.log('focus');
        $(this).val('');
    });

});