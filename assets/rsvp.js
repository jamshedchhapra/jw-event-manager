/**
 * ==========================================
 * JWEM RSVP JS (DEBUG + FINAL FIX)
 * ==========================================
 */

jQuery(document).ready(function($){

    console.log('JWEM JS LOADED ✅');

    /* ===== FINAL FIX — Prevent blocking View Details links ===== */
/* Now RSVP toggle works ONLY on real RSVP button */

$(document).on('click', '.jwem-rsvp-toggle', function(e){

    console.log('RSVP TOGGLE CLICKED ✅');

    e.preventDefault();

    $(this).closest('.mt-4').find('.jwem-rsvp-form').first().slideToggle();

});

    /**
     * Submit RSVP Form
     */
    $(document).on('submit','#jwem-rsvp-form',function(e){

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
