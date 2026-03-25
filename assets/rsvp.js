/**
 * ==========================================
 * JWEM RSVP JS (DEBUG + FINAL FIX)
 * ==========================================
 */

jQuery(document).ready(function($){

    console.log('JWEM JS LOADED ✅');

    /**
     * Toggle RSVP Form (FORCE BIND)
     */
    $(document).on('click', '.jwem-btn', function(e){

        console.log('RSVP BUTTON CLICKED ✅');

        e.preventDefault();

        $('.jwem-rsvp-form').slideToggle();

    });

    /**
     * Submit RSVP Form
     */
    $(document).on('submit','#jwem-rsvp',function(e){

        console.log('FORM SUBMIT TRIGGERED ✅');

        e.preventDefault();

        let form = $(this);

        $.post(jwem.ajax,{
            action:'jwem_rsvp',
            event_id:form.find('[name=event_id]').val(),
            name:form.find('[name=name]').val(),
            email:form.find('[name=email]').val(),
            jwem_nonce: jwem.nonce
        },function(res){

            $('#jwem-msg').html(res);

        });

    });

});