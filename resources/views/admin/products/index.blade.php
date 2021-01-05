@extends('admin.layout.content')
@section('title', 'Productos')
@section('panel-content')
    <hr>
    @include('admin.partials.alerts')
    <form action="{{ route('admin.products.sellallwithoutstock') }}" method="POST" id="sell-all-without-stock" style="display: none">
        @csrf
        @method('PUT')
    </form>
    <form action="{{ route('admin.products.sellallonlywithStock') }}" method="POST" id="sell-all-only-with-Stock" style="display: none">
        @csrf
        @method('PUT')
    </form>
    <form action="{{ route('admin.products.showstock') }}" method="POST" id="show-stock-of-all-products" style="display: none">
        @csrf
        @method('PUT')
    </form>
    <form action="{{ route('admin.products.hidestock') }}" method="POST" id="hide-stock-of-all-products" style="display: none">
        @csrf
        @method('PUT')
    </form>
    <div class="row">
        <div class="col-md-4">
            <form action="/admin/products" method="get"  style="display:flex;">
                {{ csrf_field() }}
                <input class="text-input" name="search_text" placeholder="Nombre del producto" style="padding: 6px 12px;margin-top: 0px;width: calc(100% - 40px);border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="q" value="{{ request()->search_text }}" />
                <button class="btn btn-success btn-block" type="submit" style="width: 100px;height: 10%;border-top-left-radius: 0;border-bottom-left-radius: 0;" value="Submit">Buscar</button>
            </form>
        </div>
        <div class="col-md-6 col-md-offset-2 text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Nuevo <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.products.create') }}">Nuevo Producto</a></li>
                    <li><a href="{{ route('admin.products.createWithAttributes') }}">Nuevo Producto con Atributo</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mas Opciones <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.products.sellallwithoutstock') }}" onclick="event.preventDefault();document.getElementById('sell-all-without-stock').submit();">Vender todos sin stock</a></li>
                    <li><a href="{{ route('admin.products.sellallonlywithStock') }}" onclick="event.preventDefault();document.getElementById('sell-all-only-with-Stock').submit();">Vender todos solo con stock</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('admin.products.showstock') }}" onclick="event.preventDefault();document.getElementById('show-stock-of-all-products').submit();">Mostrar el stock en todos los productos</a></li>
                    <li><a href="{{ route('admin.products.hidestock') }}" onclick="event.preventDefault();document.getElementById('hide-stock-of-all-products').submit();">Ocultar el stock en todos los productos</a></li>
                </ul>
            </div>
            <a href="{{ route('admin.products.upload.excel') }}" class="btn btn-primary">Importar desde Excel</a>
        </div>
    </div>
    <br>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Lista de Productos</a></li>
        <li role="presentation"><a href="{{ route('admin.categories.index') }}">Lista de Categorías</a></li>
    </ul>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Estado</th>
            <th>Destacado</th>
            <th>Vender sin Stock</th>
            <th>Mostrar Stock</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->codigo }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->present()->price() }}</td>
                <td>{{ $product->currentStock ? $product->currentStock->unidades : 0 }}</td>
                <td><a href="{{ route('admin.categories.edit', $product->category) }}">{{ $product->category->nombre }}</a></td>
                <td>{{ $product->present()->status() }}</td>
                <td>{{ $product->present()->featured() }}</td>
                <td>{{ $product->present()->sellWithoutStock() }}</td>
                <td>{{ $product->present()->showStock() }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="options">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-danger btn-sm">Desactivar</a>
                    </div>
                </td>
            </tr>
            <form action="{{ route('admin.products.featured', $product) }}" method="POST" id="featured-{{ $product->id }}">
                @csrf
                @method('PUT')
            </form>
        @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
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
