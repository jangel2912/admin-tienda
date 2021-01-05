@extends('admin.layout.content')
@section('title', 'Ajustes')
@section('panel-content')
<hr/>
<div class="row">
    <div class="col-md-3">
        @include('admin.settings.partials.menu', ['activeMenu' => 'domains'])
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        <div id="alert-js"></div>
        <div class="modules-header">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Configura tu propio dominio en 3 pasos</strong></h4>
                    <h5>Recuerda tener las claves de acceso <br/> de tu administrador de dominio.</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="domain-steps">1</div>
                <form action="{{ route('admin.settings.setdomains') }}" method="POST" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 text-center mb-30"><strong>Ingresa tu dominio</strong></div>
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('dominio') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <input type="url" name="dominio" value="{{ old('dominio', (!is_null($shop) && !is_null($shop->dominio) && $shop->dominio != '') ? 'https://' . $shop->dominio : '') }}" class="form-control" placeholder="Ejemplo: https://mitienda.com">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Guardar Dominio</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
                <div class="domain-steps">2</div>
                <div class="col-sm-12 text-center mb-30"><strong>Configura tu DNS</strong></div>
                <p class="text-center">Configura estos DNS en tu administrador de Dominio</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="33%">Tipo</th>
                            <th width="33%">Nombre</th>
                            <th width="33%">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td>@</td>
                            <td>75.2.53.215</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>@</td>
                            <td>99.83.138.34</td>
                        </tr>
                        <tr>
                            <td>CNAME</td>
                            <td>WWW</td>
                            <td>mitienda.vendty.com</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-4">
                <div class="domain-steps">3</div>
                <div class="col-sm-12 text-center mb-30"><strong>Esperar propagación</strong></div>
                <p class="text-center">Antes de <strong>24 horas</strong></p>
                <p class="text-center">Tu dominio estará al aire. Recuerda que siempre podrás acceder desde tu subdominio.</p>
                <p class="text-center"><a class="text-center" href="{{ $shop->dominio_local}}.vendty.com">{{ $shop->dominio_local}}.vendty.com</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="https://ayuda.vendty.com/es/articles/3222373-configuracion-de-dominio"><ion-icon name="help-circle-outline"></ion-icon> Guía como configurar mi dominio en vendty</a>
            </div>
            <div class="col-sm-12">
                <a href="https://vendty.com/blog/pasos-para-comprar-un-dominio-en-internet/"><ion-icon name="help-circle-outline"></ion-icon> ¿Cómo y donde comprar un dominio para mi tienda?</a>
            </div>
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

        .domain-steps {
            border-radius: 50%;
            width: 60px;
            height: 60px;
            background-color: #5ca745;
            color: #fff;
            margin: 0 auto 20px auto;
            text-align: center;
            font-size: 40px;
            padding-top: 3px;
        }
        .mb-30 {
            margin-bottom: 30px !important;
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
@endpush
