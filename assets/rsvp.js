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

});