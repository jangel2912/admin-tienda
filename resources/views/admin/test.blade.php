@extends('admin.layout.content')
@section('title', 'Test')
@section('panel-content')
    <div class="content-files">
        <input type="file" id="files" multiple>
        <div class="previews">
            {{--
            <div class="preview" style="background-image: url(https://i.ytimg.com/vi/c-QZdUSV4QU/maxresdefault.jpg)"></div>
            <div class="preview" style="background-image: url(https://i.ytimg.com/vi/c-QZdUSV4QU/maxresdefault.jpg)"></div>
            <div class="preview" style="background-image: url(https://i.ytimg.com/vi/c-QZdUSV4QU/maxresdefault.jpg)"></div>
            <div class="preview" style="background-image: url(https://i.ytimg.com/vi/c-QZdUSV4QU/maxresdefault.jpg)"></div>
            --}}
        </div>
    </div>
    <input type="file" id="aux">
@endsection
@push('styles')
    <style>
        .content-files {
            border: solid 1px;
            height: 250px;
            padding: 20px;
            position: relative;
        }

        .content-files input[type="file"] {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .preview {
            width: 150px;
            height: 150px;
            background-color: #fff;
            background-position: 50% 50%;
            background-size: 100%;
            background-repeat: no-repeat;
            border: solid 1px;
            float: left;
            margin-right: 15px;
            position: relative;
        }

        .preview:first-child {
            width: 200px;
            height: 200px;
        }
    </style>
@endpush
@push('scripts')
    <script
        src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
        integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
        crossorigin="anonymous"></script>
    <script>

        var files;

        $('.previews').sortable({
            change: function (event, ui) {
                $(this).children('.preview').each(function (index, el) {
                    // console.log(index);
                    // console.log(el);

                    array_move(files, $(el).data('index'), index);
                });
            }
        });
        $('.previews').disableSelection();

        $('.content-files input[type="file"]').on('change', function (event) {
            files = event.target.files;

            let browser = window.URL || window.webKitURL;

            for (let i = 0; i < files.length; i++) {
                let objectUrl = browser.createObjectURL(files[i]);

                $('.previews').append('<div class="preview" style="background-image: url(' + objectUrl + ')" data.index="' + i + '"></div>');
            }
        });

        function array_move(arr, old_index, new_index) {
            if (new_index >= arr.length) {
                var k = new_index - arr.length + 1;
                while (k--) {
                    arr.push(undefined);
                }
            }
            arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
            return arr; // for testing
        };
    </script>
@endpush
