@extends('admin.layout.content')
@section('title', 'Chatbot y WhatsApp')
@section('panel-content')
<div class="col-md-3">
	@include('admin.settings.partials.menu', ['activeMenu' => 'whatsapp'])
</div>
<div class="col-md-9">
	@include('admin.partials.alerts')
    <div class="modules-header">
        <div class="row">
            <div class="col-md-12">
                <h4><strong>Agrega un sistema de chat a tu tienda virtual</strong></h4>
                <h5>En el siguiente cuadro podrás ingresar el código JavaScript que te entrega tu proveedor de mensajería por chat para que tus clientes se comuniquen contigo en tiempo real</h5>
            </div>
        </div>
    </div>
	<form action="{{ route('admin.settings.setscriptchat') }}" method="POST" class="form-horizontal" autocomplete="off">
		@csrf
		<div class="form-group  {{ $errors->has('javascript') ? ' has-error' : '' }}">
            <label for="javascript" class="col-sm-3 control-label">JavaScript del chat:</i></label>
            <div class="col-sm-9">
                <textarea name="javascript" id="codeJavascript" class="form-control">{{ old('javascript', (!is_null($scriptchat)) ? $scriptchat->javascript : '') }}</textarea>
			</div>
		</div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <a target="_blank" href="https://bluecaribu.zendesk.com/hc/es-419/articles/360035627034-Instalaci%C3%B3n-C%C3%B3digo-del-chatbot">¿Dónde encuentro mi código de integración BlueCaribu?</a>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                Crea tu cuenta para ChatBot, WhatsApp y CRM &nbsp;<a target="_blank" href="https://app.bluecaribu.com/signup">AQUÍ</a>
            </div>
        </div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
				<button type="submit" class="btn btn-success">Actualizar</button>
			</div>
		</div>
	</form>
    <div class="social">
        <ul>
            <li><a id="tutorial" data-toggle="modal" data-target="#viewVideo"></a></li>
        </ul>
    </div>
</div>
@endsection

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

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/codemirror/lib/codemirror.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/settings.css') }}">
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
<script src="{{ asset('admin/codemirror/lib/codemirror.js') }}"></script>
<script src="{{ asset('admin/codemirror/mode/javascript/javascript.js') }}"></script>
<script>
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('codeJavascript'), {
	lineNumbers: true,
	mode: "javascript"

});
        let video = 'https://www.youtube.com/embed/MxeNuZ2KyGM';

        $('#viewVideo').on('shown.bs.modal', function () {
            $("#playerid").attr("src", video);
        });

        $('#viewVideo').on('hidden.bs.modal', function () {
            $("#playerid").attr("src", "");
        });
    </script>
@endpush
