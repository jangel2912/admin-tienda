@extends('admin.layout.content')
@section('title', 'Ajustes')
@section('panel-content')
    <hr/>
<div class="row">
    <div class="col-md-3">
        @include('admin.settings.partials.menu', ['activeMenu' => 'basic'])
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        <div id="alert-js"></div>
        <div class="modules-header">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Carga la información general de tu tienda</strong></h4>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.settings.setbasic') }}" method="POST" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('shopname') ? ' has-error' : '' }}">
                        <label for="shopname" class="col-sm-3 control-label">Nombre de tu tienda *:</label>
                        <div class="col-sm-9">
                            <input type="text" name="shopname" id="shopname" value="{{ old('shopname', (!is_null($shop)) ? $shop->shopname : '') }}" class="form-control" placeholder="Ejemplo: Mi Tienda Store" required>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('dominio_local') ? ' has-error' : '' }}">
                        <label for="dominio_local" class="col-sm-3 control-label">Subdominio *:</label>
                        <div class="col-sm-9 local_domain_shop">
                            <input type="text" name="dominio_local" id="dominio_local" value="{{ old('dominio_local', (!is_null($shop)) ? $shop->dominio_local : '') }}" class="form-control local_domain" placeholder="Ejemplo: mitiendastore" required>
                            <input type="text" value=".vendty.com" class="form-control shop" readonly>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('correo') ? ' has-error' : '' }}">
                        <label for="correo" class="col-sm-3 control-label">Correo de notificaciones *:</label>
                        <div class="col-sm-9">
                            <input type="text" name="correo" id="correo" value="{{ old('correo', (!is_null($shop)) ? $shop->correo : '') }}" class="form-control" placeholder="Ejemplo: info@mitiendastore.com" required>
                        </div>
                    </div>

                    @if (count($warehouses) > 1)
                    <div class="form-group {{ $errors->has('warehouse') ? ' has-error' : '' }}">
                        <label for="warehouse" class="col-sm-3 control-label">Almacen *:</label>
                        <div class="col-sm-9">
                            <select name="warehouse" id="warehouse" class="form-control" required>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ (!is_null($shop) && $shop->id_almacen == $warehouse->id) ? 'selected' : '' }}>{{ $warehouse->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                        <input type="hidden" name="warehouse" id="warehouse" value="{{ old('warehouse', (!is_null($warehouses[0])) ? $warehouses[0]->id : '') }}" class="form-control" required>
                    @endif

                    <div class="row">
                        <div class="col-sm-3">
                            <label for="country" class="control-label">País/Zona Horaria *:</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <select name="country" id="country" class="form-control" required>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country }}" {{ old('country', auth_user()->pais) == $country ? 'selected' : '' }}>{{ $country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('timezone') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <select name="timezone" id="timezone" class="form-control" required>
                                                @foreach ($timezones as $key => $timezone)
                                                    <option value="{{ $key }}" {{ old('timezone', $default_timezone) == $key ? 'selected' : ''}}>{{ $timezone }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="country" class="control-label">Moneda/Símbolo *:</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('currency') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <select name="currency" id="currency" class="form-control" required>
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency['AlphabeticCode'] }}" {{ old('currency', option('tipo_moneda')) == $currency['AlphabeticCode'] ? 'selected' : '' }}>{{ $currency['AlphabeticCode'] . ' - ' . $currency['Currency'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('symbol') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <input type="text" name="symbol" class="form-control" value="{!! option('simbolo') !!}" placeholder="Ejemplo: $">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }}">
                        <label for="monto" class="col-sm-3 control-label">Monto a cumplir:</label>
                        <div class="col-sm-9">
                            <input type="text" name="monto" id="monto" value="{{ old('monto', (!is_null($goals)) ? $goals->monto : '') }}" class="form-control" placeholder="Ejemplo: 1000000">
                            <small>Indica un monto minimo a cumplir como reto o meta para la semana.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </div>
        </form>
        <hr/>
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6">
                <div class="form-group">
                    <p for="logo" class="col-sm-12 text-center mb-0"><strong>QR de tu tienda</strong></p>
                    <br/>
                </div>
                <div class="col-sm-12 text-center">
                    {!! QrCode::size(120)->generate($url); !!}
                    <div class="text-center">
                        <p class="sub">Tú URL: <a href="{{ $url }}">{{$url}}</a></p>
                        <div class="text-center">
                            <a href="{{ route('admin.settings.getqrcodepdf') }}"><i class="fas fa-file-pdf"></i> Descargar PDF</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <a target="_blank" href="{{ route('admin.settings.downloadqr') }}"><i class="fas fa-image"></i> Descargar Imágen</a>
                        </div>
                    </div>
                </div>
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
