@extends('admin.layout.content')
@section('title', 'Meta Semanal')
@section('panel-content')
<div class="col-md-3">
	@include('admin.settings.partials.menu')
</div>
<div class="col-md-9">
	@include('admin.partials.alerts')
    <div class="modules-header">
        <div class="row">
            <div class="col-md-12">
                <h4><strong>Define la meta de ventas para la semana</strong></h4>
            </div>
        </div>
    </div>
	<form action="{{ route('admin.settings.setgoals') }}" method="POST" class="form-horizontal" autocomplete="off">
		@csrf
		<div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }}">
            <label for="monto" class="col-sm-3 control-label">Monto a cumplir:</label>
			<div class="col-sm-9">
				<input type="text" name="monto" id="monto" value="{{ old('monto', (!is_null($goals)) ? $goals->monto : '') }}" class="form-control" placeholder="Ejemplo: 1000000">
				<small>Indica un monto minimo a cumplir como reto o meta para la semana.</small>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
				<br>
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
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('admin/css/steps.css') }}"> -->
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
        let video = 'https://www.youtube.com/embed/s5Gu5S7DpeQ';

        $('#viewVideo').on('shown.bs.modal', function () {
            $("#playerid").attr("src", video);
        });

        $('#viewVideo').on('hidden.bs.modal', function () {
            $("#playerid").attr("src", "");
        });
    </script>
@endpush
