@extends('admin.layout.content')
@section('title', 'Términos y Condiciones')
@section('panel-content')
<hr/>
<div class="row">
    <div class="col-md-3">
        @include('admin.info.partials.menu', ['activeMenu' => 'terms'])
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        <form class="form-horizontal" action="{{ route('admin.info.setterms') }}" method="POST" autocomplete="off">
            @csrf
            <div class="form-group">
                <div class="col-sm-12">
                    <textarea id="terms" name="terms">{!! $terms !!} </textarea>
                </div>
            </div>
            <div class="col-sm-3 col-sm-offset-3">
                <button type="submit" class="btn btn-success btn-block">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    <script>
        $("#terms").summernote({
            callbacks: {
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            },
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
            ]
        });
    </script>
@endpush
