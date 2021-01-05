$(document).ready(function(){

    $("#favicon").on('change', function(e){
        e.preventDefault();
        var formData = new FormData(document.getElementById("formuploadfavicon"));
        var files = $('#favicon')[0].files[0];
        formData.append('favicon', files);

        $.ajax({
            url: $("#formuploadfavicon").attr("action"),
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                console.log(response);
                if(response.status === true){
                    $("#sitefavicon").attr("src", response.favicon);
                }
            },
            failure: function(response){
                console.log(response);
            }
        });
    });

    
});