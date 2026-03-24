/*
jQuery(document).on('submit','#jwem-rsvp',function(e){

e.preventDefault();

let form = jQuery(this);

jQuery.post(jwem.ajax,{
action:'jwem_rsvp',
event_id:form.find('[name=event_id]').val(),
name:form.find('[name=name]').val(),
email:form.find('[name=email]').val()
},function(res){

jQuery('#jwem-msg').html(res);

});

}); */

/**
 * ==========================================
 * JWEM RSVP JS (FIXED VERSION)
 * ==========================================
 */

jQuery(document).ready(function($){

    /**
     * Toggle RSVP Form
     */
    $('.jwem-btn').on('click', function(e){
        e.preventDefault();

        $('.jwem-rsvp-form').slideToggle();
    });

    /**
     * Submit RSVP Form
     */
    $(document).on('submit','#jwem-rsvp',function(e){

        e.preventDefault();

        let form = $(this);

        $.post(jwem.ajax,{
            action:'jwem_rsvp',
            event_id:form.find('[name=event_id]').val(),
            name:form.find('[name=name]').val(),
            email:form.find('[name=email]').val(),
            jwem_nonce: jwem.nonce // ✅ FIXED
        },function(res){

            $('#jwem-msg').html(res);

        });

    });

});