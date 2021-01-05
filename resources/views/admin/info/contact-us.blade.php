@extends('admin.layout.content')
@section('title', 'Contáctanos')
@section('panel-content')
    <hr/>
    <div class="row">
    <div class="col-md-3">
        @include('admin.info.partials.menu', ['activeMenu' => 'contact'])
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        <form class="form-horizontal" action="{{ route('admin.info.setcontactus') }}" method="POST" autocomplete="off">
            @csrf
            <div class="form-group">
                <label class="col-sm-3 control-label" for="google_maps">Mapa de tu tienda:</label>
                <div class="col-sm-9">
                    <input type="text" name="google_maps" id="google_maps" class="form-control" value="{{ (!is_null($contactUs) && !is_null($contactUs->google_maps)) ? $contactUs->google_maps : '' }}" placeholder="Ejemplo: <iframe src='https://maps.google.com/?ll=23.135249' height='600'></iframe>">
                </div>
                <small class="col-sm-9 col-sm-offset-3">Inserta un mapa de Google Maps en tu pagina de Contacto. Ver como insertar un mapa <a target="_blank" href="https://ayuda.vendty.com/es/articles/4032957-como-insertar-un-mapa-de-google-map-en-mi-tiendahttps://ayuda.vendty.com/es/articles/4032957-como-insertar-un-mapa-de-google-map-en-mi-tienda">AQUI</a></small>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="address">Dirección:</label>
                <div class="col-sm-9">
                    <input type="text" name="address" id="address" class="form-control" value="{{ (!is_null($contactUs) && !is_null($contactUs->address)) ? $contactUs->address : '' }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="phone">Teléfono:</label>
                <div class="col-sm-2">
                    <select id="prefix_phone" name="prefix_phone" class="form-control">
                        <option value="57" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '57') || old('prefix_phone') == '57') ? 'selected' : '' }}>🇨🇴 +57</option>
                        <option value="54" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '54') || old('prefix_phone') == '54') ? 'selected' : '' }}>🇦🇷 +54</option>
                        <option value="591" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '591') || old('prefix_phone') == '591') ? 'selected' : '' }}>🇧🇴 +591</option>
                        <option value="55" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '55') || old('prefix_phone') == '55') ? 'selected' : '' }}>🇧🇷 +55</option>
                        <option value="56" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '56') || old('prefix_phone') == '56') ? 'selected' : '' }}>🇨🇱 +56</option>
                        <option value="506" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '506') || old('prefix_phone') == '506') ? 'selected' : '' }}>🇨🇷 +506</option>
                        <option value="593" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '593') || old('prefix_phone') == '593') ? 'selected' : '' }}>🇪🇨 +593</option>
                        <option value="503" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '503') || old('prefix_phone') == '503') ? 'selected' : '' }}>🇸🇻 +503</option>
                        <option value="502" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '502') || old('prefix_phone') == '502') ? 'selected' : '' }}>🇬🇹 +502</option>
                        <option value="504" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '504') || old('prefix_phone') == '504') ? 'selected' : '' }}>🇭🇳 +504</option>
                        <option value="52" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '52') || old('prefix_phone') == '52') ? 'selected' : '' }}>🇲🇽 +52</option>
                        <option value="505" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '505') || old('prefix_phone') == '505') ? 'selected' : '' }}>🇳🇮 +505</option>
                        <option value="51" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '51') || old('prefix_phone') == '51') ? 'selected' : '' }}>🇵🇪 +51</option>
                        <option value="595" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '595') || old('prefix_phone') == '595') ? 'selected' : '' }}>🇵🇾 +595</option>
                        <option value="1" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '1') || old('prefix_phone') == '1') ? 'selected' : '' }}>🇵🇷 +1</option>
                        <option value="598" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '598') || old('prefix_phone') == '598') ? 'selected' : '' }}>🇺🇾 +598</option>
                        <option value="58" {{ ((!is_null($contactUs) && $contactUs->prefix_phone == '58') || old('prefix_phone') == '58') ? 'selected' : '' }}>🇻🇪 +58</option>
                    </select>
                </div>
                <div class="col-sm-7">
                    <input type="tel" name="phone" id="phone" class="form-control" value="{{ (!is_null($contactUs) && !is_null($contactUs->phone)) ? $contactUs->phone : '' }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="phone">Celular:</label>
                <div class="col-sm-2">
                    <select id="prefix_cellphone" name="prefix_cellphone" class="form-control">
                        <option value="57" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '57') || old('prefix_cellphone') == '57') ? 'selected' : '' }}>🇨🇴 +57</option>
                        <option value="54" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '54') || old('prefix_cellphone') == '54') ? 'selected' : '' }}>🇦🇷 +54</option>
                        <option value="591" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '591') || old('prefix_cellphone') == '591') ? 'selected' : '' }}>🇧🇴 +591</option>
                        <option value="55" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '55') || old('prefix_cellphone') == '55') ? 'selected' : '' }}>🇧🇷 +55</option>
                        <option value="56" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '56') || old('prefix_cellphone') == '56') ? 'selected' : '' }}>🇨🇱 +56</option>
                        <option value="506" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '506') || old('prefix_cellphone') == '506') ? 'selected' : '' }}>🇨🇷 +506</option>
                        <option value="593" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '593') || old('prefix_cellphone') == '593') ? 'selected' : '' }}>🇪🇨 +593</option>
                        <option value="503" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '503') || old('prefix_cellphone') == '503') ? 'selected' : '' }}>🇸🇻 +503</option>
                        <option value="502" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '502') || old('prefix_cellphone') == '502') ? 'selected' : '' }}>🇬🇹 +502</option>
                        <option value="504" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '504') || old('prefix_cellphone') == '504') ? 'selected' : '' }}>🇭🇳 +504</option>
                        <option value="52" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '52') || old('prefix_cellphone') == '52') ? 'selected' : '' }}>🇲🇽 +52</option>
                        <option value="505" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '505') || old('prefix_cellphone') == '505') ? 'selected' : '' }}>🇳🇮 +505</option>
                        <option value="51" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '51') || old('prefix_cellphone') == '51') ? 'selected' : '' }}>🇵🇪 +51</option>
                        <option value="595" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '595') || old('prefix_cellphone') == '595') ? 'selected' : '' }}>🇵🇾 +595</option>
                        <option value="1" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '1') || old('prefix_cellphone') == '1') ? 'selected' : '' }}>🇵🇷 +1</option>
                        <option value="598" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '598') || old('prefix_cellphone') == '598') ? 'selected' : '' }}>🇺🇾 +598</option>
                        <option value="58" {{ ((!is_null($contactUs) && $contactUs->prefix_cellphone == '58') || old('prefix_cellphone') == '58') ? 'selected' : '' }}>🇻🇪 +58</option>
                    </select>
                </div>
                <div class="col-sm-7">
                    <input type="tel" name="cellphone" id="cellphone" class="form-control" value="{{ (!is_null($contactUs) && !is_null($contactUs->cellphone)) ? $contactUs->cellphone : '' }}">
                </div>
                <small class="col-sm-7 col-sm-offset-5">En este n&uacute;mero recibirás un MENSAJE DE TEXTO  cuando tengas ventas en tu tienda</small>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="phone">WhatsApp:</label>
                <div class="col-sm-2">
                    <select id="prefix_whatsapp" name="prefix_whatsapp" class="form-control">
                        <option value="57" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '57') || old('prefix_whatsapp') == '57') ? 'selected' : '' }}>🇨🇴 +57</option>
                        <option value="54" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '54') || old('prefix_whatsapp') == '54') ? 'selected' : '' }}>🇦🇷 +54</option>
                        <option value="591" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '591') || old('prefix_whatsapp') == '591') ? 'selected' : '' }}>🇧🇴 +591</option>
                        <option value="55" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '55') || old('prefix_whatsapp') == '55') ? 'selected' : '' }}>🇧🇷 +55</option>
                        <option value="56" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '56') || old('prefix_whatsapp') == '56') ? 'selected' : '' }}>🇨🇱 +56</option>
                        <option value="506" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '506') || old('prefix_whatsapp') == '506') ? 'selected' : '' }}>🇨🇷 +506</option>
                        <option value="593" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '593') || old('prefix_whatsapp') == '593') ? 'selected' : '' }}>🇪🇨 +593</option>
                        <option value="503" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '503') || old('prefix_whatsapp') == '503') ? 'selected' : '' }}>🇸🇻 +503</option>
                        <option value="502" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '502') || old('prefix_whatsapp') == '502') ? 'selected' : '' }}>🇬🇹 +502</option>
                        <option value="504" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '504') || old('prefix_whatsapp') == '504') ? 'selected' : '' }}>🇭🇳 +504</option>
                        <option value="52" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '52') || old('prefix_whatsapp') == '52') ? 'selected' : '' }}>🇲🇽 +52</option>
                        <option value="505" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '505') || old('prefix_whatsapp') == '505') ? 'selected' : '' }}>🇳🇮 +505</option>
                        <option value="51" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '51') || old('prefix_whatsapp') == '51') ? 'selected' : '' }}>🇵🇪 +51</option>
                        <option value="595" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '595') || old('prefix_whatsapp') == '595') ? 'selected' : '' }}>🇵🇾 +595</option>
                        <option value="1" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '1') || old('prefix_whatsapp') == '1') ? 'selected' : '' }}>🇵🇷 +1</option>
                        <option value="598" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '598') || old('prefix_whatsapp') == '598') ? 'selected' : '' }}>🇺🇾 +598</option>
                        <option value="58" {{ ((!is_null($contactUs) && $contactUs->prefix_whatsapp == '58') || old('prefix_whatsapp') == '58') ? 'selected' : '' }}>🇻🇪 +58</option>
                    </select>
                </div>
                <div class="col-sm-7">
                    <input type="tel" name="whatsapp" id="whatsapp" class="form-control" value="{{ (!is_null($contactUs) && !is_null($contactUs->whatsapp)) ? $contactUs->whatsapp : '' }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">Mensaje de WhatsApp:</label>
                <div class="col-sm-9">
                    <input type="text" name="whatsapp_default_message" id="whatsapp_default_message" class="form-control" value="{{ (!is_null($contactUs) && !is_null($contactUs->whatsapp_default_message)) ? $contactUs->whatsapp_default_message : '¿Quiéres hacer un pedido y no sabes cómo? Nosotros te asesoramos, comunícate con nosotros via WhatsApp' }}">
                </div>
                <small class="col-sm-9 col-sm-offset-3">Mensaje que aparecera por defecto cuando se abra WhatsApp desde tu tienda</small>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">Correo Electrónico de Contacto:</label>
                <div class="col-sm-9">
                    <input type="email" name="email" id="email" class="form-control" value="{{ (!is_null($contactUs) && !is_null($contactUs->email)) ? $contactUs->email : '' }}">
                </div>
            </div>
            <div class="col-sm-3 col-sm-offset-3">
                <button type="submit" class="btn btn-success btn-block">Guardar</button>
            </div>
        </form>
    </div>
    </div>
    <div class="social">
        <ul>
            <li><a id="tutorial" data-toggle="modal" data-target="#viewVideo"></a></li>
        </ul>
    </div>
@endsection
@push('styles')
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

@push('scripts')
    <script>
        let video = 'https://www.youtube.com/embed/FXYPBgIXQso';

        $('#viewVideo').on('shown.bs.modal', function () {
            $("#playerid").attr("src", video);
        });

        $('#viewVideo').on('hidden.bs.modal', function () {
            $("#playerid").attr("src", "");
        });
    </script>
@endpush
