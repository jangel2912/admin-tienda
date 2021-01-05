$('.image-input').click(function(event) {
    event.preventDefault();
    $('#cropper').data('image', $(this).attr('name'));
    $('#cropperTittle').html($(this).attr('name'));
    $('#alert-modal-js').html('');
    $('#cropper').modal('show');
});

$('#upload').on('change', function () {
    readFile(this);
});

$('.upload-result').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'original'
    }).then(function (base64_image) {
        $('#loader').show();
        let image = $('#cropper').data('image');
        $.post('/admin/upload-image', {
            image,
            base64_image,
        }, function ({status}) {
            if (status) {
                $('.preview-' + image).attr('src', base64_image);
                $('#cropper').modal('hide');
                $('.options-' + image).show();
            } else {
                $('#alert-modal-js').html('<div class="alert alert-danger">Error al intentar cargar el ' + image + '.</div>');
            }
        }).always(function() {
            $('#loader').hide();
        });
    });
});

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.upload-demo').addClass('ready');
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function() {
                $('.upload-result').prop("disabled", false);
            });
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        alert("Error al intentar cargar la imagen");
    }
}

$('.delete-image').click(function() {
    $('#loader').show();
	let image = $(this).data('image');
	let ul = $(this).parent();

    $.post('/admin/delete-image', {
		image
	}, function({status}) {
		if (status) {
            let default_image = image.toLowerCase().indexOf('slider') >= 0 ? '/img/1200x340.png' : '/img/260x80.png';
            ul.siblings('img').attr('src', default_image);
            ul.hide();
        } else {
            $('#alert-js').html('<div class="alert alert-danger"><p>Error al intentar eliminar el ' + image + '.</p></div>');
        }
    }).always(function() {
        $('#loader').hide();
    });
});
