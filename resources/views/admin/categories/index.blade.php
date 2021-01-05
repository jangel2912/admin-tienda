@extends('admin.layout.content')
@section('title', 'Categorías')
@section('panel-content')
    <hr>
    @include('admin.partials.alerts')
    <div class="row">
        <div class="col-md-4">
            <form action="/admin/categories" method="get" style="display:flex;">
                {{ csrf_field() }}
                <input class="text-input" name="search_text" placeholder="Nombre de la categoría" style="padding: 6px 12px;margin-top: 0px;width: calc(100% - 40px);border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="q" value="{{ request()->search_text }}" />
                <button class="btn btn-success btn-block" type="submit" style="width: 100px;height: 10%;border-top-left-radius: 0;border-bottom-left-radius: 0;" value="Submit">Buscar</button>
            </form>
        </div>
        <div class="col-md-2 col-md-offset-6">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-block">Nueva Categoría</a>
        </div>
    </div>
    <br>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{{ route('admin.products.index') }}">Lista de Productos</a></li>
        <li role="presentation" class="active"><a href="#">Lista de Categorías</a></li>
    </ul>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Subcategorías</th>
            <th>Sub-subcategorías</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->codigo }}</td>
                <td>{{ $category->nombre }}</td>
                <td>{{ $category->present()->subcategories() }}</td>
                <td>{{ $category->present()->sub_subcategories() }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="options">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm">Editar</a>
                        <a href="{{ route('admin.categories.destroy', $category) }}" class="btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById('destroy-category-{{ $category->id }}').submit();">Eliminar</a>
                    </div>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" id="destroy-category-{{ $category->id }}" style="display: none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
@endsection

@push('styles')
<style>
    .text-input{
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 3px #ddd;
        border-radius: 4px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 12px;
        padding-bottom: 12px;
    }
</style>
@endpush
