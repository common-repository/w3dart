jQuery(function() {
    jQuery('#w3-settings-form input[type=radio]').change(function() {
        var radio = jQuery('#w3-visible-for-roles');
        if (radio.is(':checked')) {
            jQuery('#w3-visible-roles').show();
        } else {
            jQuery('#w3-visible-roles').hide();
        }
    });
    var radio = jQuery('#w3-visible-for-roles');
    if (radio.is(':checked')) {
        jQuery('#w3-visible-roles').show();
    }
});