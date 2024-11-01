jQuery(document).ready(function() {

    jQuery('ul.ocwdc-tabs li').click(function(){
        var tab_id = jQuery(this).attr('data-tab');
        jQuery('ul.ocwdc-tabs li').removeClass('ocwdc-current');
        jQuery('.ocwdc-tab-content').removeClass('ocwdc-current');
        jQuery(this).addClass('ocwdc-current');
        jQuery("#"+tab_id).addClass('ocwdc-current');
    });

});