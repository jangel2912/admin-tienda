@extends('admin.layout.app')
@section('title', 'Paso 4 - Wizard')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Has finalizado la configuración básica de tu tienda<strong></h4>
                </div>
                {{--<div class="col-md-3">
                    <a href="#" id="tutorial"></a>
                </div>--}}
            </div>
        </div>
        <div class="panel-body">
            <div class="step-container">
                @include('admin.wizard.partials.steps')
                <div class="step-content">
                    <form action="{{ route('admin.wizard.fourthstep.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                @include('admin.partials.alerts')
                            </div>
                            <div class="col-md-6 col-md-offset-3">
                                <div class="templates-content" data-template="{{ auth_user()->shop->template->id }}" style="background-image: url('{{ '/templates/' . auth_user()->shop->template->ruta_img }}'); height: 300px; cursor: auto;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-sm-offset-1">
                                <a href="{{ route('admin.wizard.thirdstep.create') }}" class="btn btn-success btn-block">Anterior</a>
                            </div>
                            <div class="col-sm-2 col-sm-offset-6">
                                <button type="submit" class="btn btn-success btn-block">Finalizar</button>
                            </div>
                        </div>
                        <br>
                        <small>(*) Encuentra tus  credenciales de acceso en el la bandeja de entrada o SPAM de tu correo</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/steps.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/templates.css') }}">
@endpush
