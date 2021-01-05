@extends('admin.layout.content')
@section('title', 'Editar Producto - ' . $product->name)
@section('panel-content')
    <hr>
    @include('admin.partials.alerts')
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
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
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                @if (is_null($product->reference))
                    <div class="col-sm-12">
                        <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                            <label for="code">Código de tu producto*:</label>
                            <input type="text" name="code" id="code" value="{{ old('code', $product->code) }}" class="form-control" placeholder="ABC123" required>
                            <small>Puede contener letras y números, tener entre 1 y 15 caracteres. Servirá para identificar tu producto en la tienda</small>
                            @if ($errors->has('code'))
                                <span class="help-block">{{ $errors->first('code') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                            <label for="quantity">Cantidad de Productos*:</label>
                            <input type="number" name="quantity" id="quantity" min="0" value="{{ old('quantity', $product->currentStock ? $product->currentStock->unidades : 0) }}" class="form-control" required>
                            @if ($errors->has('quantity'))
                                <span class="help-block">{{ $errors->first('quantity') }}</span>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="form-group">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Destacado:</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="featured" id="featured" {{ ($product->destacado_tienda) ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Vender sin existencia de productos:</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="sell_without_stock" id="sell_without_stock" {{ ($product->vendernegativo) ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mostrar Inventario:</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="show_stock" id="show_stock" {{ ($product->mostrar_stock) ? 'checked' : '' }}>
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
                                    <option value="{{ $category->id }}" {{ $category->id == old('category', $product->categoria_id) ? 'selected' : '' }}>{{ $category->nombre }}</option>
                                @else
                                    <option disabled style="font-weight: bold;">{{ $category->nombre }}</option>
                                    @foreach($categories->where('padre', $category->id) as $subcategory)
                                        @if (count($categories->where('padre', $subcategory->id)) == 0)
                                            <option value="{{ $subcategory->id }}" {{ $subcategory->id == old('category', $product->categoria_id) ? 'selected' : '' }}>{{ $subcategory->nombre }}</option>
                                        @else
                                            <option disabled style="font-weight: bold;">&nbsp&nbsp{{ $subcategory->nombre }}</option>
                                            @foreach($categories->where('padre', $subcategory->id) as $sub_subcategory)
                                                <option value="{{ $sub_subcategory->id }}" {{ $sub_subcategory->id == old('category', $product->categoria_id) ? 'selected' : '' }}>&nbsp&nbsp&nbsp&nbsp{{ $sub_subcategory->nombre }}</option>
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
                        <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $product->description) }}" required>
                        @if ($errors->has('description'))
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="long_description">Descripción Larga:</label>
                        <small>Puede indicar una descripción mas amplia, incluyendo imagenes y videos.</small>
                        <textarea name="long_description" id="long_description" class="form-control">{{ old('long_description', $product->long_description) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="files">Imagenes:</label>
                        <small>Las imagenes deben tener un tamaño de: 260x80px y un peso máximo de: 50kb.</small>

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="alert-js"></div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen">Imagen principal</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->image) }}" class="img-responsive img-thumbnail preview-imagen1" style="border: 2px solid #EF6437;" placeholder="Imagen Principal">
                                    <ul class="options options-imagen {{ is_null($product->image) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen" data-is_reference="true">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen" name="imagen" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen1">Imagen 2</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->image1) }}" class="img-responsive img-thumbnail preview-imagen2">
                                    <ul class="options options-imagen2 {{ is_null($product->image1) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen1" data-is_reference="true">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen1" name="imagen1" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen2">Imagen 3</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->image2) }}" class="img-responsive img-thumbnail preview-imagen3">
                                    <ul class="options options-imagen2 {{ is_null($product->image2) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen2" data-is_reference="true">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen2" name="imagen2" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen3">Imagen 4</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->image3) }}" class="img-responsive img-thumbnail preview-imagen4">
                                    <ul class="options options-imagen3 {{ is_null($product->image3) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen3" data-is_reference="true">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen3" name="imagen3" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen4">Imagen 5</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->image4) }}" class="img-responsive img-thumbnail preview-imagen5">
                                    <ul class="options options-imagen4 {{ is_null($product->image4) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen4" data-is_reference="true">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen4" name="imagen4" class="form-control image-input">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="imagen5">Imagen 6</label>
                                <div id="load-logo">
                                    <img src="{{ product_path($product->image5) }}" class="img-responsive img-thumbnail preview-imagen5">
                                    <ul class="options options-imagen5 {{ is_null($product->image5) ? 'hide' : '' }}">
                                        <li title="Eliminar" class="delete-image" data-image="imagen5" data-is_reference="true">
                                            <i class="fas fa-trash-alt"></i>
                                        </li>
                                    </ul>
                                    <input type="file" id="imagen5" name="imagen5" class="form-control image-input">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (!is_null($product->reference))
                        <div class="form-group">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td width="2">Mostrar imagenes por cada producto</td>
                                        <td style="text-align:center" width="1">
                                            <label class="switch">
                                                <input type="checkbox" name="images" {{ ($product->reference->imagenes) ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td style="text-align:right" width="2">Mostrar imagenes generales</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <h4>Precio</h4>
                <hr>
                @if (count($taxes) > 0)
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('tax') ? ' has-error' : '' }}" style="padding-right: 20px;">
                            <label for="tax">Impuesto *:</label>
                            <select name="tax" id="tax" class="form-control" required>
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->id_impuesto }}" data-percentage="{{ $tax->porciento }}" {{ $tax->id_impuesto == old('tax', $product->impuesto) ? 'selected' : '' }}>{{ $tax->nombre_impuesto }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                            <label for="price">Precio de venta con impuesto*:</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ option('simbolo') }}</span>
                                <input type="number" min="0" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" step=".01" required>
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
                                <input type="number" min="0" name="sale_price" id="sale_price" class="form-control" value="{{ old('sale_price', $product->precio_venta) }}" required readonly>
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
                                <input type="number" min="0" name="buy_price" id="buy_price" class="form-control" value="{{ old('buy_price', $product->precio_compra) }}" step=".01" required>
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
                                <input type="text" name="buy_price" id="buy_price" class="form-control" value="{{ old('buy_price') }}" required>
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
        @if (!is_null($product->reference))
            <div class="row">
                <div class="col-sm-12">
                    <h4>Atributos</h4>
                    <p>Indica los atributos con sus respectivos detalles para este producto.</p><hr>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <h5>Atributo 1</h5>
                            <input type="text" name="attributes[]" id="attribute1" class="form-control" value="{{ old('attributes.0', $product->reference->attributes[0]->nombre_atributo) }}" onkeyup="this.value = this.value.toUpperCase();" required>
                        </div>
                        <div class="col-sm-9">
                            <h5>Detalles</h5>
                            <input type="text" name="details[]" id="detail1" class="form-control" value="{{ old('details.0', $product->reference->attributes[0]->details_string) }}" required>
                            <small>Puede indicar los detalles correspodientes a este atributo separados por comas.</small>
                        </div>
                    </div>
                </div>
                <div id="attributes">
                    @foreach ($product->reference->attributes as $key => $attribute)
                        @if ($key > 0)
                            <div id="containerAttribute{{ $key + 1 }}">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <h5>Atributo {{ $key + 1 }}</h5>
                                            <input type="text" name="attributes[]" id="attribute{{ $key + 1 }}" class="form-control" value="{{ old('attributes.' . $key, $attribute->nombre_atributo) }}" onkeyup="this.value = this.value.toUpperCase();" required>
                                        </div>
                                        <div class="col-sm-9">
                                            <h5 class="col-xs-9" style="padding: 0;">Detalles</h5>
                                            <div class="col-xs-3 text-right attribute-delete attribute-delete-{{ $key + 1 }} hide" style="padding: 0; padding-top: 10px;">
                                                <a href="javascript:void(0);" onclick="deleteAttribute();">Eliminar</a>
                                            </div>
                                            <input type="text" name="details[]" id="detail{{ $key + 1 }}" class="form-control" value="{{ old('details.' . $key, $attribute->details_string) }}" required>
                                            <small>Puede indicar los detalles correspodientes a este atributo separados por comas.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm-12">
                    <button id="add-attribute" class="btn btn-success {{ count($product->reference->attributes) >= 3 ? 'hide' : '' }}" type="button">Añadir atributo</button>
                    <hr>
                </div>
                <div id="products">
                    @foreach ($product->reference->products as $key => $variant)
                        <div id="product-{{ $key }}" class="product-{{ strtolower(str_replace('/', '-', $variant->attributes)) }}">
                            <div class="col-xs-3">
                                <label for="product{{ $key }}"></label>
                                <h5>{{ $variant->attributes }}</h6>
                                <input type="hidden" name="products[]" id="product{{ $key }}" value="{{ $variant->attributes }}">
                            </div>
                            <div class="col-xs-2">
                                <label for="code{{ $key }}">Código</label>
                                <input type="text" name="codes[]" id="code{{ $key }}" value="{{ old('codes.' . $key, $variant->codigo) }}" class="form-control">
                            </div>
                            <div class="col-xs-1">
                                <label for="quantity{{ $key }}">Cantidad</label>
                                <input type="number" name="quantities[]" id="quantity{{ $key }}" min="0" value="{{ old('quantity' . $key, $variant->currentStock ? $variant->currentStock->unidades : 0) }}" class="form-control">
                            </div>
                            <div class="col-xs-2">
                                <label for="sale_price{{ $key }}">Precio Venta</label>
                                <input type="number" name="sale_prices[]" id="sale_price{{ $key }}" min="0" value="{{ old('sale_price' . $key, $variant->price) }}" class="form-control" step=".01">
                            </div>
                            <div class="col-xs-2">
                                <label for="buy_price{{ $key }}">Precio Compra</label>
                                <input type="number" name="buy_prices[]" id="buy_price{{ $key }}" min="0" value="{{ old('buy_price' . $key, $variant->precio_compra) }}" class="form-control" step=".01">
                            </div>
                            <div class="col-xs-2">
                                <label>Opciones</label>
                                <div class="col-12">
                                    <button class="btn option" onclick="deleteProduct({{ $key }})" title="Eliminar"><i class="fa fa-trash"></i></button>
                                    <a class="btn option{{ $variant->has_images ? ' has_images' : '' }}" href="{{ route('admin.products.editWithAttributes', ['product' => $variant->id ]) }}" title="Editar"><i class="fa fa-image"></i></a>
                                </div>
                            </div>
                            <div class="col-xs-12"><hr></div>
                        </div>
                    @endforeach
                </div>
            </div>
            <input type="hidden" name="reference" value="{{ $product->reference->id }}">
        @endif
        <input type="hidden" id="id" value="{{ $product->id }}">
        <p class="required">* Campos requeridos</p>
    </form>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/handleFiles.css') }}">
    @if (!is_null($product->reference))
        <link rel="stylesheet" href="{{ asset('admin/css/tag-editor.css') }}">
    @endif
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    <script src="{{ asset('js/products.js') }}"></script>
    <script src="{{ asset('admin/js/handleFiles.js') }}"></script>
    <script src="{{ asset('admin/js/previewImagesProducts.js') }}"></script>
    @if (!is_null($product->reference))
        <script src="{{ asset('admin/js/caret.min.js') }}"></script>
        <script src="{{ asset('admin/js/tag-editor.min.js') }}"></script>
        <script>
            let attributes = '{{ count($product->reference->attributes) }}';
            let productsQuantity = '{{ count($product->reference->products) }}';
            let maxAttributes = 3;
            let attributeNames = ['TALLA', 'COLOR', 'MATERIAL'];
            let taxes = (new Boolean('{{ count($taxes) > 100 }}')).valueOf();

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
                $('#loader').show();
                let products = [];
                let general_buy_price = $('#buy_price').val();
                let general_sale_price = $('#sale_price').val();

                for (let index = 1; index <= attributes; index++) {
                    products[index - 1] = $('#detail' + index).tagEditor('getTags')[0].tags;
                }

                products = products.filter(product => product.length > 0);
                products = allPossibleProducts(products);
                $('#products').empty();

                axios.post('/admin/products/check', {
                    products,
                    reference_id : '{{ $product->reference->id }}'
                }).then(function ({data}) {
                    for (let product in data) {
                        let code = data[product] != null && data[product].codigo != null ? data[product].codigo : '';
                        let quantity = data[product] != null && data[product].current_stock != null ? data[product].current_stock.unidades : 0;
                        let sale_price = data[product] != null ? data[product].precio_venta : general_sale_price;
                        let buy_price = data[product] != null ? data[product].precio_compra : general_buy_price;


                        $('#products').append(
                            '<div id="product-' + product + '">' +
                                '<div class="col-xs-3">' +
                                    '<label for="product' + product + '"></label>' +
                                    '<h5>' + products[product] + '</h6>' +
                                    '<input type="hidden" name="products[]" id="product' + product + '" value="' + products[product] + '">' +
                                '</div>' +
                                '<div class="col-xs-2">' +
                                    '<label for="code1">Código</label>' +
                                    '<input type="text" name="codes[]" id="code' + product + '" value="' + code + '" class="form-control">' +
                                '</div>' +
                                '<div class="col-xs-2">' +
                                    '<label for="quantity1">Cantidad</label>' +
                                    '<input type="number" name="quantities[]" id="quantity' + product + '" min="0" value="' + quantity + '" class="form-control">' +
                                '</div>' +
                                '<div class="col-xs-2">' +
                                    '<label for="sale_price1">Precio Venta</label>' +
                                    '<input type="number" name="sale_prices[]" id="sale_price' + product + '" min="0" value="' + sale_price + '" class="form-control" step=".01">' +
                                '</div>' +
                                '<div class="col-xs-2">' +
                                    '<label for="buy_price1">Precio Compra</label>' +
                                    '<input type="number" name="buy_prices[]" id="buy_price' + product + '" min="0" value="' + buy_price + '" class="form-control" step=".01">' +
                                '</div>' +
                                '<div class="col-xs-1">' +
                                    '<label>Eliminar</label>' +
                                    '<button class="btn" onclick="deleteProduct(' + product + ')"><i class="fa fa-trash"></i></button>' +
                                '</div>' +
                                '<div class="col-xs-12"><hr></div>' +
                            '</div>'
                        );
                    }
                }).catch(function (err) {
                    console.error(err);
                }).always(function() {
                    $('#loader').hide();
                });
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
                $('input[name="details[]"]').tagEditor({
                    delimiter: ',',
                    onChange: makeProducts,
                }).css('display', 'block').attr('readonly', true);

                $('.attribute-delete-' + attributes).removeClass('hide');
            });
        </script>
    @endif

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
        </script>
    @endif
@endpush
