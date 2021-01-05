@extends('admin.layout.content')
@section('title', 'Promociones')
@section('panel-content')
    @include('admin.partials.alerts')
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Lista de Promociones</a></li>
        <li role="presentation"><a href="{{ route('admin.promotions.create') }}">Nueva Promoción</a></li>
    </ul>
    <table id="promotions" class="table">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($promotions as $promotion)
            <tr>
                <td>{{ $promotion->nombre }}</td>
                <td>{{ $promotion->start_in->format('d/m/Y h:i a') }} <small>({{ $promotion->start_in->diffForHumans() }})</small></td>
                <td>{{ $promotion->ends_in->format('d/m/Y h:i a') }} <small>({{ $promotion->ends_in->diffForHumans() }})</small></td>
                <td>{{ $promotion->present()->status() }}</td>
                <td>
                    @if($promotion->activo)
                        <div class="btn-group" role="group" aria-label="options">
                            <a href="{{ route('admin.promotions.edit', $promotion) }}" class="btn btn-warning btn-sm">Editar</a>
                            <a href="{{ route('admin.promotions.deactivate', $promotion) }}" onclick="event.preventDefault(); document.getElementById('deactivate-promotion-{{ $promotion->id }}').submit();" class="btn btn-danger btn-sm">Desactivar</a>
                        </div>
                        <form id="deactivate-promotion-{{ $promotion->id }}" action="{{ route('admin.promotions.deactivate', $promotion) }}" method="POST">
                            @csrf
                        </form>
                    @else
                        <div class="btn-group" role="group" aria-label="options">
                            <a href="{{ route('admin.promotions.edit', $promotion) }}" class="btn btn-warning btn-sm">Editar</a>
                            <a href="{{ route('admin.promotions.activate', $promotion) }}" onclick="event.preventDefault(); document.getElementById('activate-promotion-{{ $promotion->id }}').submit();" class="btn btn-success btn-sm">Activar</a>
                        </div>
                        <form id="activate-promotion-{{ $promotion->id }}" action="{{ route('admin.promotions.activate', $promotion) }}" method="POST">
                            @csrf
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
