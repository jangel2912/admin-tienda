@extends('admin.layout.content')
@section('title', 'Ajustes')
@section('panel-content')
<hr/>
<div class="row">
    <div class="col-md-3">
        @include('admin.settings.partials.menu', ['activeMenu' => 'logos'])
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        <div id="alert-js"></div>
        <div class="modules-header">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Carga el logo de tu tienda y refuerza tu marca</strong></h4>
                </div>
            </div>
        </div>
            @csrf
            <div class="row divider-line-bottom">
                <div class="col-sm-offset-4 col-sm-4">
                    <div id="load-logo text-center">
                        <div class="logo-settings-container text-center">
                            <img src="{{ image_path($shop->logo, 'logo') }}" class="preview-logo">
                            <ul class="options options-logo {{ is_null($shop->logo) ? 'hide' : '' }}">
                                <li title="Eliminar" class="delete-image" data-image="logo">
                                    <i class="fas fa-trash-alt"></i>
                                </li>
                            </ul>
                        </div>
                        <label class="text-center display-block load-logo" for="logo">Actualiza tu logo</label>
                        <p class="mb-0 text-center"><small>Imágen Recomendada: png, jpg o jpeg, Dimensiones: 260x80px y Peso: 50Kb.</small></p>
                        <input type="file" id="logo" name="logo" class="form-control image-input hidden">
                        <br/>
                        <div>
                            <img class="img-responsive" src="{{ asset("/admin/img/settings-logos.jpg") }}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <form action="{{ route('admin.uploadFavicon') }}" enctype="multipart/form-data" id="formuploadfavicon" method="post">
                    <div class="col-sm-offset-4 col-sm-4 text-center">
                        <img src="{{ image_path($shop->favicon) }}" class="favicon" id="sitefavicon">
                        <label class="display-block text-center load-logo" for="favicon">Actualiza tu favicon</label>
                        <p class="mb-0 text-center"><small>Imágen Recomendada: png, jpg, jpeg o ico, Dimensiones: 30X30px y Peso: 10Kb.</small></p>
                        <input type="file" id="favicon" name="favicon" class="form-control hidden" accept="image/*">
                        <br/>
                        <div>
                            <img class="img-responsive" src="{{ asset("/admin/img/settings-favicon.jpg") }}" />
                        </div>
                    </div>
                </form>
            </div>
            {{--
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="logo" class="col-sm-3 control-label">Logo:</label>
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
                        <small class="col-sm-9 col-sm-offset-3">Esta es la imagen que aparece en la página principal de la tienda. Imagen Recomendada: png, jpg o jpeg, Dimensiones: 260x80px y Peso: 50Kb.</small>
                        <br><br>
                    </div>
                    <div class="form-group {{ $errors->has('favicon') ? ' has-error' : '' }}">
                        <label for="favicon" class="col-sm-3 control-label">Favicon:</label>
                        <div class="col-sm-3">
                            <img src="{{ image_path($shop->favicon) }}" class="img-thumbnail favicon">
                        </div>
                        <div class="col-sm-6">
                            <input type="file" id="favicon" name="favicon" class="form-control">
                        </div>
                        <small class="col-sm-9 col-sm-offset-3">Este es el Icono que aparece en la pestaña del navegador. Imagen Recomendada: png, jpg, jpeg o ico, Dimensiones: 30X30px y Peso: 10Kb.</small>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-12">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </div>--}}
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
                            <button class="btn btn-primary btn-block" style="position: relative;"><input type="file" id="upload" value="Choose a file" accept="image/*"> Buscar mi Logo</button>
                        </div>
                        <div class="col-md-3">
                            <button class="upload-result btn btn-success btn-block" disabled>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            /*background-image: url(https://pos.vendty.com/uploads/iconos/Blanco/icono_blanco-35.svg) !important;*/
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
                width: 260,
                height: 80,
            },
            boundary: {
                width: 460,
                height: 280,
            }
        });
    </script>
    <script>
        let video = 'https://www.youtube.com/embed/qWNcZ4U6HVQ';

        $('#viewVideo').on('shown.bs.modal', function () {
            $("#playerid").attr("src", video);
        });

        $('#viewVideo').on('hidden.bs.modal', function () {
            $("#playerid").attr("src", "");
        });
    </script>
    <script src="{{ asset('admin/js/previewImages.js') }}"></script>
    <script src="{{ asset('admin/js/uploadFavicon.js') }}"></script>
@endpush
