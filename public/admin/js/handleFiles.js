var files;

$('.previews').sortable({
    change: function (event, ui) {
        $(this).children('.preview').each(function (index, el) {
            //
        });
    }
});

$('.previews').disableSelection();

$('.content-files input[type="file"]').on('change', function (event) {
    files = event.target.files;

    let browser = window.URL || window.webKitURL;

    $('.previews').html('');

    for (let i = 0; i < 6; i++) {
        let objectUrl = browser.createObjectURL(files[i]);

        $('.previews').append('<div class="preview" style="background-image: url(' + objectUrl + ')" data.index="' + i + '"></div>');
    }
});

