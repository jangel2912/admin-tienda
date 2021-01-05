@extends('admin.layout.content')
@section('title', 'Editar Atributo - ' . $product->attributes . ' - Producto - ' . $product->name)
@section('panel-content')
    <hr>
    @include('admin.partials.alerts')
    <form action="{{ route('admin.products.updateWithAttributes', $product->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div id="button-save">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-md-2 col-xs-6 col-md-offset-8">
                            <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Regresar</a>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <button id="submit-all" class="btn btn-success btn-block" type="submit">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <h4>Imagenes</h4>
                    <hr>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="files">Imagenes:</label>
                        <small>Las imagenes deben tener un tamaño de: 260x80px y un peso máximo de: 50kb.</small>

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="alert-js"></div>
                            </div>
                            <div class="col-md-2 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen">Imagen principal</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->imagen) }}" class="img-responsive img-thumbnail preview-imagen1" style="border: 2px solid #EF6437;" placeholder="Imagen Principal">
                                    <ul class="options options-imagen {{ is_null($product->imagen) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen" name="imagen" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen1">Imagen 2</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->imagen1) }}" class="img-responsive img-thumbnail preview-imagen2">
                                    <ul class="options options-imagen2 {{ is_null($product->imagen1) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen1">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen1" name="imagen1" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen2">Imagen 3</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->imagen2) }}" class="img-responsive img-thumbnail preview-imagen3">
                                    <ul class="options options-imagen2 {{ is_null($product->imagen2) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen2">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen2" name="imagen2" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen3">Imagen 4</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->imagen3) }}" class="img-responsive img-thumbnail preview-imagen4">
                                    <ul class="options options-imagen3 {{ is_null($product->imagen3) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen3">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen3" name="imagen3" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen4">Imagen 5</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->imagen4) }}" class="img-responsive img-thumbnail preview-imagen5">
                                    <ul class="options options-imagen4 {{ is_null($product->imagen4) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen4">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen4" name="imagen4" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen5">Imagen 6</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->imagen5) }}" class="img-responsive img-thumbnail preview-imagen5">
                                    <ul class="options options-imagen5 {{ is_null($product->imagen5) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen5">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen5" name="imagen5" class="form-control image-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="id" value="{{ $product->id }}">
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/products.js') }}"></script>
    <script src="{{ asset('admin/js/previewImagesProducts.js') }}"></script>
@endpush
