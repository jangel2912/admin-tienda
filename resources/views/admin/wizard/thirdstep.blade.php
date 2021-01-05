@extends('admin.layout.app')
@section('title', 'Paso 3 - Wizard')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Puedes cambiar tu logo y descripción más adelante</strong></h4>
                    <h5>Todos los campos de este paso son opcionales, si desea, puede ir al paso siguiente</h5>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="step-container">
                @include('admin.wizard.partials.steps')
                <div class="step-content">
                    <form action="{{ route('admin.wizard.thirdstep.store') }}" method="POST" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                @include('admin.partials.alerts')
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <div class="form-group {{ $errors->has('seo_description') ? ' has-error' : '' }}">
                                    <label for="seo_description" class="col-sm-3 control-label">Descripción (Opcional):</label>
                                    <div class="col-sm-9">
                                        <textarea name="seo_description" id="seo_description" class="form-control" style="height: 100px">{{ old('seo_description', $shop->seo_description) }}</textarea>
                                        <small>Indica una breve descripción para tu tienda virtual. Esta descripción es la que mostraran los buscadores como google y en tu tienda.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="logo" class="col-sm-3 control-label">Logo (Opcional):</label>
                                    <div class="col-sm-9">
                                        <div id="load-logo">
                                            <img src="{{ image_path($shop->logo, 'logo') }}" class="img-responsive img-thumbnail preview-logo">
                                            <ul class="options options-logo {{ is_null($shop->logo) ? 'hide' : '' }}">
                                                <li title="Eliminar" class="delete-image" data-image="logo">
                                                    <i class="fas fa-trash-alt"></i>
                                                </li>
                                            </ul>
                                            <input type="file" id="logo" name="logo" class="form-control image-input">
                                        </div>
                                    </div>
                                    <small class="col-md-9 col-md-offset-3">Esta es la imagen que aparece en la página principal de la tienda. Imagen Recomendada: png, jpg o jpeg, Dimensiones: 260x80px y Peso: 50Kb.</small>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2 col-sm-offset-1">
                                <a href="{{ route('admin.wizard.secondstep.create') }}" class="btn btn-success btn-block">Anterior</a>
                            </div>
                            <div class="col-sm-2 col-sm-offset-6">
                                <button type="submit" class="btn btn-success btn-block">Siguiente</button>
                            </div>
                        </div>
                        <br>
                        <small>(*) Encuentra tus  credenciales de acceso en el la bandeja de entrada o SPAM de tu correo</small>
                    </form>
                </div>
            </div>
            @include('admin.wizard.partials.out')
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="cropper" tabindex="-1" role="dialog" aria-labelledby="cropperLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="cropperLabel">Logo para tu Tienda</h4>
                </div>
                <div class="modal-body">
                    <div id="alert-modal-js"></div>
                    <div id="upload-demo">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-3">
                            <button class="btn btn-primary btn-block" style="position: relative;"><input type="file" id="upload" value="Choose a file" accept="image/*"> Cargar</button>
                        </div>
                        <div class="col-md-3">
                            <button class="upload-result btn btn-success btn-block" disabled>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/Croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/steps.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/thirdstep.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('bower_components/Croppie/croppie.min.js') }}"></script>
    <script src="{{ asset('bower_components/exif-js/exif.js') }}"></script>
    <script>
        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            enforceBoundary: false,
            viewport: {
                width: 260,
                height: 80,
            },
            boundary: {
                width: 460,
                height: 280,
            }
        });
    </script>
    <script src="{{ asset('admin/js/previewImages.js') }}"></script>
@endpush
