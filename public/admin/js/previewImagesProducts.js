$('input[type="file"]').change(function() {
	let file = this.files[0];
	let browser = window.URL || window.webkitURL;

	let urlObject = browser.createObjectURL(file);

	$(this).siblings('img').attr('src', urlObject);
});

$('.delete-image').click(function() {
    $('#loader').show();
    let image = $(this).data('image');
    let ul = $(this).parent();
    let is_reference = !!$(this).data('is_reference');
    let product_id = $('#id').val();

    $.post('/admin/products/delete-image', {
        image,
        product_id,
        is_reference,
    }, function({status}) {
        if (status) {
            ul.siblings('img').attr('src', '/img/product-default.png');
            ul.hide();
        } else {
            $('#alert-js').html('<div class="alert alert-danger"><p>Error al intentar eliminar la ' + image + '.</p></div>');
        }
    }).always(function() {
        $('#loader').hide();
    });
});
