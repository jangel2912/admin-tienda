@extends('admin.layout.content')
@section('title', 'Nuevo Producto')
@section('panel-content')
    <hr>
    @include('admin.partials.alerts')
    <form action="{{ route('admin.products.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div id="button-save">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-md-2 col-xs-6 col-md-offset-8">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-block">Cancelar</a>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <button id="submit-all" class="btn btn-success btn-block" type="submit">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <h4>Información general</h4>
                <p>Indica la información general para este producto.</p>
            </div>
            <div class="col-sm-9">
                <div class="col-sm-12">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Nombre de tu producto*:</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code">Código de tu producto*:</label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control" placeholder="ABC123" required>
                        <small>Puede contener letras y números, tener entre 1 y 15 caracteres. Servirá para identificar tu producto en la tienda</small>
                        @if ($errors->has('code'))
                            <span class="help-block">{{ $errors->first('code') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                        <label for="quantity">Cantidad de productos*:</label>
                        <input type="number" name="quantity" id="quantity" min="0" value="{{ old('quantity') }}" class="form-control" required>
                        @if ($errors->has('quantity'))
                            <span class="help-block">{{ $errors->first('quantity') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Destacado:</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="featured" id="featured">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Vender sin existencia de productos:</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="sell_without_stock" id="sell_without_stock">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mostrar inventario:</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="show_stock" id="show_stock">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h4>Información Adicional</h4>
                <hr>
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                        <label for="category">Categoría*:</label>
                        <select name="category" id="category" class="form-control" required>
                            @foreach($categories->where('padre', null) as $category)
                                @if (count($categories->where('padre', $category->id)) == 0)
                                    <option value="{{ $category->id }}" {{ $category->id == old('category') ? 'selected' : '' }}>{{ $category->nombre }}</option>
                                @else
                                    <option disabled style="font-weight: bold;">{{ $category->nombre }}</option>
                                    @foreach($categories->where('padre', $category->id) as $subcategory)
                                        @if (count($categories->where('padre', $subcategory->id)) == 0)
                                            <option value="{{ $subcategory->id }}" {{ $subcategory->id == old('category') ? 'selected' : '' }}>{{ $subcategory->nombre }}</option>
                                        @else
                                            <option disabled style="font-weight: bold;">&nbsp&nbsp{{ $subcategory->nombre }}</option>
                                            @foreach($categories->where('padre', $subcategory->id) as $sub_subcategory)
                                                <option value="{{ $sub_subcategory->id }}" {{ $sub_subcategory->id == old('category') ? 'selected' : '' }}>&nbsp&nbsp&nbsp&nbsp{{ $sub_subcategory->nombre }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('category'))
                            <span class="help-block">{{ $errors->first('category') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description">Descripción*:</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" required>
                        @if ($errors->has('description'))
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="long_description">Descripción larga:</label>
                        <small>Puede indicar una descripción mas amplia, incluyendo imagenes y videos.</small>
                        <textarea name="long_description" id="long_description" class="form-control">{{ old('long_description') }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="files">Imagenes:</label>
                        <small>Las imagenes deben tener un tamaño de: 260x80px y un peso máximo de: 50kb.</small>
                        <div class="row">
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <div id="load-logo">
                                    <label for="files">Imagen principal</label>
                                    <img src="{{ product_path(null) }}" class="img-responsive img-thumbnail preview-imagen1" style="border: 2px solid #EF6437;" placeholder="Imagen Principal">
                                    <input type="file" id="imagen" name="imagen" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="files">Imagen 2</label>
                                <div id="load-logo">
                                    <img src="{{ product_path(null) }}" class="img-responsive img-thumbnail preview-imagen2">
                                    <input type="file" id="imagen1" name="imagen1" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="files">Imagen 3</label>
                                <div id="load-logo">
                                    <img src="{{ product_path(null) }}" class="img-responsive img-thumbnail preview-imagen3">
                                    <input type="file" id="imagen2" name="imagen2" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="files">Imagen 4</label>
                                <div id="load-logo">
                                    <img src="{{ product_path(null) }}" class="img-responsive img-thumbnail preview-imagen4">
                                    <input type="file" id="imagen3" name="imagen3" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="files">Imagen 5</label>
                                <div id="load-logo">
                                    <img src="{{ product_path(null) }}" class="img-responsive img-thumbnail preview-imagen5">
                                    <input type="file" id="imagen4" name="imagen4" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="files">Imagen 6</label>
                                <div id="load-logo">
                                    <img src="{{ product_path(null) }}" class="img-responsive img-thumbnail preview-imagen5">
                                    <input type="file" id="imagen5" name="imagen5" class="form-control image-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4>Precio</h4>
                <hr>
                @if (count($taxes) > 0)
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('tax') ? ' has-error' : '' }}" style="padding-right: 20px;">
                            <label for="tax">Impuesto *:</label>
                            <select name="tax" id="tax" class="form-control" required>
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->id_impuesto }}" data-percentage="{{ $tax->porciento }}" {{ $tax->id_impuesto == old('tax') ? 'selected' : '' }}>{{ $tax->nombre_impuesto }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                            <label for="price">Precio de venta con impuesto*:</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ option('simbolo') }}</span>
                                <input type="number" min="0" name="price" id="price" class="form-control" value="{{ old('price', 0) }}" step=".01" required>
                            </div>
                            <small>Este precio sera publicado en tu tienda.</small>
                            @if ($errors->has('price'))
                                <span class="help-block">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('sale_price') ? 'has-error' : '' }}" style="padding-right: 20px;">
                            <label for="sale_price">Precio de venta sin impuesto*:</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ option('simbolo') }}</span>
                                <input type="number" min="0" name="sale_price" id="sale_price" class="form-control" value="{{ old('sale_price', 0) }}" step=".01" required readonly>
                            </div>
                            @if ($errors->has('sale_price'))
                                <span class="help-block">{{ $errors->first('sale_price') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('buy_price') ? 'has-error' : '' }}">
                            <label for="buy_price">Precio de compra*:</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ option('simbolo') }}</span>
                                <input type="number" min="0" name="buy_price" id="buy_price" class="form-control" step=".01"  value="{{ old('buy_price', 0) }}" required>
                            </div>
                            <small>Este precio no se vera en tu tienda virtual. Servirá para calcular la utilidad en el sistema POS</small>
                            @if ($errors->has('buy_price'))
                                <span class="help-block">{{ $errors->first('buy_price') }}</span>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('sale_price') ? 'has-error' : '' }}" style="padding-right: 20px;">
                            <label for="sale_price">Precio de venta*:</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ option('simbolo') }}</span>
                                <input type="text" name="sale_price" id="sale_price" class="form-control" value="{{ old('sale_price') }}" required>
                            </div>
                            <small>Este precio sera publicado en tu tienda.</small>
                            @if ($errors->has('sale_price'))
                                <span class="help-block">{{ $errors->first('sale_price') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('buy_price') ? 'has-error' : '' }}">
                            <label for="buy_price">Precio de compra*:</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ option('simbolo') }}</span>
                                <input type="text" name="buy_price" id="buy_price" class="form-control" value="{{ old('buy_price') }}" required step=".01" >
                            </div>
                            <small>Este precio no se vera en tu tienda virtual. Servirá para calcular la utilidad en el sistema POS</small>
                            @if ($errors->has('buy_price'))
                                <span class="help-block">{{ $errors->first('buy_price') }}</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <p class="required">* Campos requeridos</p>
    </form>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/handleFiles.css') }}">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    <script src="{{ asset('js/products.js') }}"></script>
    <script src="{{ asset('admin/js/handleFiles.js') }}"></script>
    <script src="{{ asset('admin/js/previewImagesProducts.js') }}"></script>
    @if (count($taxes) > 0)
        <script>
            $('#tax').change(function() {
                calculateSalePrice();
            });

            $('#price').keyup(function() {
                calculateSalePrice();
            });

            $('#price').focusout(function() {
                calculateSalePrice();

                if ($('#price').val() < 0 || $('#price').val() == '') {
                    $('#price').val(0);
                    $('#sale_price').val(0);
                }
            });

            function calculateSalePrice() {
                let percentage = $('#tax option:selected').data('percentage');
                let price = $('#price').val();

                $('#sale_price').val(Number.parseFloat(price / (1 + (percentage / 100))).toFixed(2));
            }

            $(function() {
                calculateSalePrice();
            });
        </script>
    @endif
@endpush
