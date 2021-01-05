@extends('admin.layout.app')
@section('title', 'Paso 2 - Wizard')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Escoge el color de la  plantilla que más se ajuste a tu negocio</strong></h4>
                    <h5>Estas a 2 pasos de ver tu tienda en</h5>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="step-container">
                @include('admin.wizard.partials.steps')
                <div class="step-content">
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1">
                            @include('admin.partials.alerts')
                            <div id="alert-js"></div>
                        </div>
                        <div class="col-md-6 col-md-offset-3">
                            <div class="templates-content preview wizard" data-template="{{ auth_user()->shop->template->id }}" style="background-image: url('{{ '/templates/' . auth_user()->shop->template->ruta_img }}');"></div>
                        </div>
                        <div class="col-sm-12 text-center mb-30">
                            @foreach ($templates as $template)
                                <a class="templates-new-content {{$layout == $template->nombre ? 'active' : ''}} " data-template="{{ $template->id }}" style="background-color: {{ $template->color }};" href="javascript:void(false);">&nbsp;</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2 col-xs-offset-1">
                            <a href="{{ route('admin.wizard.firststep.create') }}" class="btn btn-success btn-block">Anterior</a>
                        </div>
                        <div class="col-xs-2 col-xs-offset-6">
                            <a href="{{ route('admin.wizard.thirdstep.create') }}" class="btn btn-success btn-block">Siguiente</a>
                        </div>
                    </div>
                    <br>
                </div>
                <small>(*) Encuentra tus  credenciales de acceso en el la bandeja de entrada o SPAM de tu correo</small>
            </div>
            @include('admin.wizard.partials.out')
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/steps.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/templates.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('admin/js/templates.js') }}"></script>
@endpush
