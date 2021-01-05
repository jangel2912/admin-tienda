@extends('admin.layout.content')
@section('title', 'Plantillas')
@section('panel-content')
<hr/>
<div class="row">
    <div class="col-md-3">
        @include('admin.settings.partials.menu', ['activeMenu' => 'templates'])
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        <div id="alert-js"></div>
        <div class="modules-header">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Escoge el color de la  plantilla que más se ajuste a tu negocio</strong></h4>
                </div>
                <div class="col-sm-12">
                        <p>1- Primero selecciona tu tipo de negocio / 2- Luego seleccione el color.</p>
                        <ul class="busines_type list-inline text-center mt-30">
                            <li>
                                <a class="{{ $business_type == 'retail' ? 'active' : '' }}" href="{{ route('admin.settings.gettemplates', ['business_type' => 'retail']) }}">Retail</a>
                            </li>
                            <li>
                                <a class="{{ $business_type == 'restaurant' ? 'active' : '' }}" href="{{ route('admin.settings.gettemplates', ['business_type' => 'restaurant']) }}">Restaurante</a>
                            </li>
                        </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="templates-content preview wizard" data-template="{{ auth_user()->shop->template->id }}" style="background-image: url('{{ '/templates/' . auth_user()->shop->template->ruta_img }}'); height: 300px; cursor: auto;"></div>
        </div>
        <div class="col-sm-12">
                @foreach ($templates as $template)
                    <a class="templates-new-content {{$layout == $template->nombre ? 'active' : ''}} " data-template="{{ $template->id }}" style="background-color: {{ $template->color }};" href="javascript:void(false);">&nbsp;</a>
                @endforeach
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/templates.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('admin/js/templates.js') }}"></script>
@endpush
