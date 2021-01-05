@extends('admin.layout.content')
@section('title', 'Nuevo Producto con Atributos')
@section('panel-content')
    <hr>
    @include('admin.partials.alerts')
    <form action="{{ route('admin.products.storeWithAttributes') }}" method="POST" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
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
                                <td>Mostrar Inventario:</td>
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
                        <label for="long_description">Descripción Larga:</label>
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
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h4>Atributos</h4>
                <p>Indica los atributos con sus respectivos detalles para este producto.</p><hr>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="col-sm-3">
                        <h5>Atributo 1</h5>
                        <input type="text" name="attributes[]" id="attribute1" class="form-control" value="{{ old('attribute1', 'TALLA') }}" onkeyup="this.value = this.value.toUpperCase();" required>
                    </div>
                    <div class="col-sm-9">
                        <h5>Detalles</h5>
                        <input type="text" name="details[]" id="detail1" class="form-control" value="{{ old('detail1') }}" required>
                        <small>Puede indicar los detalles correspodientes a este atributo separados por comas.</small>
                    </div>
                </div>
            </div>
            <div id="attributes"></div>
            <div class="col-sm-12">
                <button id="add-attribute" class="btn btn-success" type="button">Añadir atributo</button>
                <hr>
            </div>
            <div id="products"></div>
        </div>
        <p class="required">* Campos requeridos</p>
    </form>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/handleFiles.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/tag-editor.css') }}">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    <script src="{{ asset('js/products.js') }}"></script>
    <script src="{{ asset('admin/js/handleFiles.js') }}"></script>
    <script src="{{ asset('admin/js/previewImagesProducts.js') }}"></script>
    <script src="{{ asset('admin/js/caret.min.js') }}"></script>
    <script src="{{ asset('admin/js/tag-editor.min.js') }}"></script>
    <script>
        let attributes = 1;
        let maxAttributes = 3;
        let attributeNames = ['TALLA', 'COLOR', 'MATERIAL'];

        $('#add-attribute').click(function() {
            attributes++;

            if (attributes <= maxAttributes) {
                $('.attribute-delete').addClass('hide');

                $('#attributes').append(
                    '<div id="containerAttribute' + attributes + '">' +
                        '<div class="col-sm-12">' +
                            '<div class="form-group">' +
                                '<div class="col-sm-3">' +
                                    '<h5>Atributo ' + attributes + '</h5>' +
                                    '<input type="text" name="attributes[]" id="attribute' + attributes + '" class="form-control" value="' + attributeNames[attributes - 1] + '" onkeyup="this.value = this.value.toUpperCase();" required>' +
                                '</div>' +
                                '<div class="col-sm-9">' +
                                    '<h5 class="col-xs-9" style="padding: 0;">Detalles</h5>' +
                                    '<div class="col-xs-3 text-right attribute-delete attribute-delete-' + attributes + '" style="padding: 0; padding-top: 10px;">' +
                                        '<a href="javascript:void(0);" onclick="deleteAttribute();">Eliminar</a>' +
                                    '</div>' +
                                    '<input type="text" name="details[]" id="detail' + attributes + '" class="form-control" required>' +
                                    '<small>Puede indicar los detalles correspodientes a este atributo separados por comas.</small>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                );

                $('#detail' + attributes).tagEditor({
                    delimiter: ',',
                    onChange: makeProducts,
                }).css('display', 'block').attr('readonly', true);
            }

            if (attributes >= maxAttributes) {
                $(this).addClass('hide');
            }
        });

        function deleteAttribute() {
            if (attributes > 1) {
                $('#containerAttribute' + attributes).remove();
                attributes--;
                $('.attribute-delete-' + attributes).removeClass('hide');
                makeProducts();
            }

            if (attributes < maxAttributes) {
                $('#add-attribute').removeClass('hide');
            }
        }

        function makeProducts() {
            let products = [];

            for (let index = 1; index <= attributes; index++) {
                products[index - 1] = $('#detail' + index).tagEditor('getTags')[0].tags;
            }

            products = products.filter(product => product.length > 0);
            products = allPossibleProducts(products);
            $('#products').empty();

            for (let product in products) {
                $('#products').append(
                    '<div id="product-' + product + '">' +
                        '<div class="col-xs-3">' +
                            '<label for="product' + product + '"></label>' +
                            '<h5>' + products[product] + '</h6>' +
                            '<input type="hidden" name="products[]" id="product' + product + '" value="' + products[product] + '">' +
                        '</div>' +
                        '<div class="col-xs-2">' +
                            '<label for="code' + product + '">Código</label>' +
                            '<input type="text" name="codes[]" id="code' + product + '" class="form-control">' +
                        '</div>' +
                        '<div class="col-xs-2">' +
                            '<label for="quantity' + product + '">Cantidad</label>' +
                            '<input type="number" name="quantities[]" id="quantity' + product + '" min="0" value="0" class="form-control">' +
                        '</div>' +
                        '<div class="col-xs-2">' +
                            '<label for="sale_price' + product + '">Precio Venta</label>' +
                            '<input type="number" name="sale_prices[]" id="sale_price' + product + '" min="0" value="0" class="form-control">' +
                        '</div>' +
                        '<div class="col-xs-2">' +
                            '<label for="buy_price' + product + '">Precio Compra</label>' +
                            '<input type="number" name="buy_prices[]" id="buy_price' + product + '" min="0" value="0" class="form-control">' +
                        '</div>' +
                        '<div class="col-xs-1">' +
                            '<label>Eliminar</label>' +
                            '<button class="btn" onclick="deleteProduct(' + product + ')"><i class="fa fa-trash"></i></button>' +
                        '</div>' +
                        '<div class="col-xs-12"><hr></div>' +
                    '</div>'
                );
            }
        }

        function allPossibleProducts(products) {
            if (products.length === 0) {
                return [];
            } else if (products.length === 1) {
                return products[0].map(product => product.toUpperCase());
            } else {
                let result = [];
                let allProductsOfRest = allPossibleProducts(products.slice(1));

                for (let product in allProductsOfRest) {
                    for (var i = 0; i < products[0].length; i++) {
                        result.push((products[0][i] + '/' + allProductsOfRest[product]).toUpperCase());
                    }
                }

                return result;
            }
        }

        function deleteProduct(product) {
            $('#product-' + product).remove();
        }

        $(function() {
            $('#detail1').tagEditor({
                delimiter: ',',
                onChange: makeProducts,
            }).css('display', 'block').attr('readonly', true);
        });
    </script>
@endpush
