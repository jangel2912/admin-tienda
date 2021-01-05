$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.templates-new-content').click(function(event) {
	event.preventDefault();
    $('#loader').show();
	var element = $(this);
    let template = $(this).data('template');

	$.post('/admin/templates', {
		id: template
	}, function({status, template}) {
        if (status) {
            $('.templates-new-content.active').removeClass('active');
            $('.preview').css('background-image', 'url(/templates/' + template.ruta_img + ')');
            element.addClass('active');
        } else {
            $('#alert-js').html('<div class="alert alert-danger">Error al intentar cargar el ' + image + '.</div>');
        }
    }).always(function() {
        $('#loader').hide();
    });
});
