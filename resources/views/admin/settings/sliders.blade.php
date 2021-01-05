@extends('admin.layout.content')
@section('title', 'Ajustes')
@section('panel-content')
<hr/>
<div class="row">
<div class="col-md-3">
	@include('admin.settings.partials.menu', ['activeMenu' => 'sliders'])
</div>
<div class="col-md-9">
    @include('admin.partials.alerts')
    <div id="alert-js"></div>
    <div class="modules-header">
        <div class="row">
            <div class="col-md-12">
                <h4><strong>Sube Banners a tu tienda y da a conocer productos y promociones</strong></h4>
                <h5>Podrás subir hasta 6 banners y cambiarlos cuando quieras</h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div id="load-logo">
                <img src="{{ image_path(auth()->user()->dbConfig->shop->slider1, 'slider') }}" class="img-responsive img-thumbnail preview-slider1">
                <ul class="options options-slider1 {{ is_null(auth()->user()->dbConfig->shop->slider1) ? 'hide' : '' }}">
                    <li title="Eliminar" class="delete-image" data-image="slider1">
                        <i class="fas fa-trash-alt"></i>
                    </li>
                </ul>
                <input type="file" id="slider1" name="slider1" class="form-control image-input">
            </div>
        </div>
        <div class="col-md-4">
            <div id="load-logo">
                <img src="{{ image_path(auth()->user()->dbConfig->shop->slider2, 'slider') }}" class="img-responsive img-thumbnail preview-slider2">
                <ul class="options options-slider2 {{ is_null(auth()->user()->dbConfig->shop->slider2) ? 'hide' : '' }}">
                    <li title="Eliminar" class="delete-image" data-image="slider2">
                        <i class="fas fa-trash-alt"></i>
                    </li>
                </ul>
                <input type="file" id="slider2" name="slider2" class="form-control image-input">
            </div>
        </div>
        <div class="col-md-4">
            <div id="load-logo">
                <img src="{{ image_path(auth()->user()->dbConfig->shop->slider3, 'slider') }}" class="img-responsive img-thumbnail preview-slider3">
                <ul class="options options-slider3 {{ is_null(auth()->user()->dbConfig->shop->slider3) ? 'hide' : '' }}">
                    <li title="Eliminar" class="delete-image" data-image="slider3">
                        <i class="fas fa-trash-alt"></i>
                    </li>
                </ul>
                <input type="file" id="slider3" name="slider3" class="form-control image-input">
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div id="load-logo">
                <img src="{{ image_path(auth()->user()->dbConfig->shop->slider4, 'slider') }}" class="img-responsive img-thumbnail preview-slider4">
                <ul class="options options-slider4 {{ is_null(auth()->user()->dbConfig->shop->slider4) ? 'hide' : '' }}">
                    <li title="Eliminar" class="delete-image" data-image="slider4">
                        <i class="fas fa-trash-alt"></i>
                    </li>
                </ul>
                <input type="file" id="slider4" name="slider4" class="form-control image-input">
            </div>
        </div>
        <div class="col-md-4">
            <div id="load-logo">
                <img src="{{ image_path(auth()->user()->dbConfig->shop->slider5, 'slider') }}" class="img-responsive img-thumbnail preview-slider5">
                <ul class="options options-slider5 {{ is_null(auth()->user()->dbConfig->shop->slider5) ? 'hide' : '' }}">
                    <li title="Eliminar" class="delete-image" data-image="slider5">
                        <i class="fas fa-trash-alt"></i>
                    </li>
                </ul>
                <input type="file" id="slider5" name="slider5" class="form-control image-input">
            </div>
        </div>
        <div class="col-md-4">
            <div id="load-logo">
                <img src="{{ image_path(auth()->user()->dbConfig->shop->slider6, 'slider') }}" class="img-responsive img-thumbnail preview-slider6">
                <ul class="options options-slider6 {{ is_null(auth()->user()->dbConfig->shop->slider6) ? 'hide' : '' }}">
                    <li title="Eliminar" class="delete-image" data-image="slider6">
                        <i class="fas fa-trash-alt"></i>
                    </li>
                </ul>
                <input type="file" id="slider6" name="slider6" class="form-control image-input">
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <small class="col-md-12">Los banners deben ser una imágenes en formato png, jpg o jpeg, de dimensiones 1200x340px y un tamaño máximo de 150Kb</small>
    </div>
    <div class="row">
        <small class="col-md-12">Utiliza esta herramienta para cambiar el tamaño de tus imágenes. Clic &nbsp;<a target="_blank" href="https://resizeyourimage.com/">AQUÍ</a></small>
    </div>
    <div class="social">
        <ul>
            <li><a id="tutorial" data-toggle="modal" data-target="#viewVideo"></a></li>
        </ul>
    </div>
</div>
</div>
@endsection

@push('modals')
    <div class="modal fade" id="cropper" tabindex="-1" role="dialog" aria-labelledby="cropperLabel">
        <div class="modal-dialog" role="document" style="width: 1300px !important">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="cropperLabel">Elige el <strong id="cropperTittle"></strong></h4>
                </div>
                <div class="modal-body" style="padding: 0 !important">
                    <div id="alert-modal-js"></div>
                    <div id="upload-demo">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-3">
                            <button class="btn btn-primary btn-block" style="position: relative;"><input type="file" id="upload" value="Choose a file" accept="image/*"> Buscar mi Baner</button>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
    <style>
        #tutorial {
            display: inline-block;
            margin: 0;
            float: right;
            color: #fff;
            background: #5ca745;
            text-decoration: none;
            border-radius: 5px;
            background-image: url(https://pos.vendty.com/uploads/iconos/Blanco/icono_blanco-35.svg) !important;
            background-image: url(https://pos.vendty.com/uploads/iconos/Blanco/icono_blanco-35.svg) !important;
            background-repeat: no-repeat;
            background-size: 25px;
            background-position: center;
        }

        #tutorial:after {
            color: #000;
            text-align: center;
            font-size: 11px;
            position: absolute;
            right: 27px;
            bottom: -38px;
            width: 100px;
        }
        .social {
            position: fixed;
            right: 0;
            top: 50vh;
            z-index: 2000;
        }
        .social ul li a {
            display: inline-block;
            width: 47px;
            height: 47px;
            color: #fff;
            background: #5ca745;
            text-decoration: none;
            -webkit-transition: all 500ms ease;
            -o-transition: all 500ms ease;
            transition: all 500ms ease;
            border-radius: 5px 0px 0px 5px;
            background-image: url(../../uploads/iconos/Blanco/icono_blanco-35.svg) !important;
            background-repeat: no-repeat;
            background-size: 35px;
            background-position: center;
            cursor: pointer;
        }
        .social ul {
            list-style: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('bower_components/Croppie/croppie.min.js') }}"></script>
    <script src="{{ asset('bower_components/exif-js/exif.js') }}"></script>
    <script>
        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            enforceBoundary: false,
            viewport: {
                width: 1200,
                height: 340,
            },
            boundary: {
                width: 1250,
                height: 390,
            }
        });
    </script>
    <script>
        let video = 'https://www.youtube.com/embed/uRQesv9Ibrc';

        $('#viewVideo').on('shown.bs.modal', function () {
            $("#playerid").attr("src", video);
        });

        $('#viewVideo').on('hidden.bs.modal', function () {
            $("#playerid").attr("src", "");
        });
    </script>
    <script src="{{ asset('admin/js/previewImages.js') }}"></script>
@endpush

@push('modals')
    <!-- Modal -->
    <body>
        <div class="modal fade" id="viewVideo" tabindex="-1" role="dialog" aria-labelledby="uploadExcelLabel">
            <div class="modal-dialog" role="document" style="width: 900px;">
                <div class="modal-body">
                    <iframe id="playerid" width="800" height="538" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </body>
@endpush
