if ($('#long_description').length > 0) {
    $('#long_description').summernote({ 
        tabsize: 2, 
        height: 300, 
        toolbar: [
            ['undo', ['undo',]],
            ['redo', ['redo',]],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview']],
        ],
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            }
        }
    });
}

var position = $('#button-save').position();
positionButton();

$(window).scroll(function (event) {
    positionButton()
});

function positionButton() {
    if ($(this).scrollTop() >= position.top) {
        $('#button-save').addClass('fixed');
    } else {
        $('#button-save').removeClass('fixed');
    }
}
