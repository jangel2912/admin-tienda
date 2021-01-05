<div id="button-save">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-2 col-xs-6 col-md-offset-8">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary btn-block">Cancelar</a>
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
        <ul id="formTabs" class="nav nav-pills" role="tablist">
            <li role="presentation" class="active">
                <a href="#general" aria-controls="general" role="tab" data-toggle="tab">
                    <h4>Información general</h4>
                    <p>Indica la información general para este cupón.</p>
                </a>
            </li>
            <li role="presentation">
                <a href="#restrictions" aria-controls="general" role="tab" data-toggle="tab"> 
                    <h4>Restricción de uso</h4>
                    <p>Restringe como tus clientes usan el cupón.</p>
                </a>
            </li>
            <li role="presentation">
                <a href="#limits" aria-controls="general" role="tab" data-toggle="tab">
                    <h4>Límites de uso</h4>
                    <p>Configura cuantas veces va a ser usado el cupón.</p>
                </a>
            </li>
            
        </ul>
    </div>
    <div class="col-sm-9">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active " id="general">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('nombre') ? 'has-error' : '' }}" >
                            <label for="nombre">Código de tu cupón*:</label>
                            <div class="input-group">
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $coupon->nombre) }}" class="form-control" autocomplete="off">
                                <span class="input-group-btn">
                                    <button id="generate-name" class="btn btn-success" type="button">Generar nombre</button>
                                </span>
                            </div>
                            <small>Código del cupón, este código será usado por los clientes en el carro de compras para aplicar el cupón. Puede generar un código automáticamente con el botón "Generar código".</small>
                            @if ($errors->has('nombre'))
                                <span class="help-block">{{ $errors->first('nombre') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $coupon->descripcion) }}</textarea>
                            <small>Esta descripción le ayudará a identificar el cupón en la página "Cupones" y en el resumen de la venta.</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group-with-help form-group {{ $errors->has('fecha_caducidad') ? 'has-error' : '' }}">
                            <label for="fecha_caducidad">Fecha de caducidad del cupón*:</label>
                            <input type="date" id="fecha_caducidad" name="fecha_caducidad" value="{{ old('fecha_caducidad', $coupon->fecha_caducidad) }}" class="form-control" />
                            <small>El cupón caducará a las 00:00:00 de esta fecha.</small>
                            @if ($errors->has('fecha_caducidad'))
                                <span class="help-block">{{ $errors->first('fecha_caducidad') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('tipo') ? 'has-error' : '' }}">
                            <label for="tipo">Tipo*:</label>
                            <select name="tipo" id="tipo" class="form-control" required>
                                <option {{ old('tipo', $coupon->tipo) == "descuento_en_porsentaje" ? "selected" : "" }} value="descuento_en_porsentaje">Descuento en porcentaje</option>
                                <option {{ old('tipo', $coupon->tipo) == "descuento_fijo_en_carrito" ? "selected" : "" }} value="descuento_fijo_en_carrito">Descuento fijo en carrito</option>
                                <option {{ old('tipo', $coupon->tipo) == "descuento_fijo_de_producto" ? "selected" : "" }} value="descuento_fijo_de_producto">Descuento fijo de producto</option>
                            </select>
                            <small>
                                <ul>
                                    <li><strong>Descuento en porcentaje:</strong> Descuenta un % del total de la venta.</li>
                                    <li><strong>Descuento fijo en carrito</strong> Descuenta una cantidad fija de dinero de la venta.</li>
                                    <li><strong>Descuento fijo de producto</strong> Descuenta una cantidad fija de dinero de cada producto adicionado al carro de compras.</li>
                                </ul>
                            </small>
                            @if ($errors->has('tipo'))
                                <span class="help-block">{{ $errors->first('tipo') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('importe') ? 'has-error' : '' }}" >
                            <label for="importe">Importe del cupón*:</label>
                            <input type="number" min="0" name="importe" id="importe" class="form-control" value="{{ old('importe', $coupon->importe) }}" step="1" />
                            <small>Valor del cupón.</small>
                            @if ($errors->has('importe'))
                                <span class="help-block">{{ $errors->first('importe') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="restrictions">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('gasto_minimo') ? 'has-error' : '' }}" >
                            <label for="gasto_minimo">Gasto mínimo de compra:</label>
                            <input placeholder="Sin mínimo" type="number" min="0" name="gasto_minimo" id="gasto_minimo" class="form-control" value="{{ old('gasto_minimo', $coupon->gasto_minimo) }}" step="1" />
                            <small>Este valor te permite establecer el gasto mínimo (subtotal) permitido para poder usar este cupón.</small>
                            @if ($errors->has('gasto_minimo'))
                                <span class="help-block">{{ $errors->first('gasto_minimo') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('gasto_maximo') ? 'has-error' : '' }}" >
                            <label for="gasto_maximo">Gasto máximo de compra:</label>
                            <input type="number" min="0" name="gasto_maximo" id="gasto_maximo" class="form-control" value="{{ old('gasto_maximo', $coupon->gasto_maximo) }}" step="1" />
                            <small>Este valor te permite establecer el gasto máximo (subtotal) permitido para poder usar este cupón.</small>
                            @if ($errors->has('gasto_maximo'))
                                <span class="help-block">{{ $errors->first('gasto_maximo') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group">
                            <table class="">
                                <tbody>
                                    <tr>
                                        <td width="80%">Uso individual:</td>
                                        <td>
                                            <label class="switch">
                                            <input type="checkbox" name="uso_individual" id="uso_individual" value="1" {{ old('uso_individual', $coupon->uso_individual) == '1' ? "checked" : ""}}/>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><small>Marca esta casilla si el cupón no se puede utilizar en combinación con otros cupones.</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group">
                            <label for="correos_electronicos">Correos electrónicos permitidos:</label>
                            <input type="text" name="correos_electronicos" id="correos_electronicos" class="form-control" value="{{ old('correos_electronicos', $coupon->correos_electronicos) }}" />
                            <small>Lista de correos electrónicos contra los que probar el correo de facturación del pedido. Separa las direcciones de correo electrónico con comas.</small>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group">
                            <table class="">
                                <tbody>
                                    <tr>
                                        <td width="80%">Incluir productos:</td>
                                        <td>
                                            <label class="switch">
                                            <input type="checkbox" name="incluir_productos" id="incluir_productos" value="1" {{ old('incluir_productos', $coupon->incluir_productos)  == '1' ? "checked" : ""}}/>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><small>Marca esta casilla si el cupón aplicará para productos específicos. Se mostrará un campo para marcar los productos a los que se aplica el cupón.</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="include_products_container" class="col-sm-12" style="{{ old('incluir_productos', $coupon->incluir_productos) == '1' ? 'display:block;' : 'display:none;'}}">
                        <div class="form-group-with-help form-group {{ $errors->has('productos') ? 'has-error' : '' }}">
                            <label for="productos">Productos incluidos:</label>
                            <select name="productos[]" id="productos" class="form-control" multiple="multiple">
                                <option></option>
                                @foreach ($products as $producto)
                                    <option value="{{$producto->id}}" {{(collect(old("productos", $coupon->products->where('tipo', 'incluido')->pluck('producto_id')->toArray()))->contains($producto->id)) ? 'selected' : '' }}>{{$producto->nombre}}</option>
                                @endforeach
                            </select>
                            <small>Productos a los que se aplicará el cupón. O que tendrán que estar en el carrito para que se aplique el &laquo;Descuento fijo en el carrito&raquo;</small>
                            @if ($errors->has('productos'))
                                <span class="help-block">{{ $errors->first('productos') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('productos_excluidos') ? 'has-error' : '' }}">
                            <label for="productos_excluidos">Productos excluidos:</label>
                            <select name="productos_excluidos[]" id="productos_excluidos" class="form-control" multiple="multiple">
                                <option></option>
                                @foreach ($products as $producto)
                                    <option value="{{$producto->id}}" {{(collect(old("productos_excluidos", $coupon->products->where('tipo', 'no_incluido')->pluck('producto_id')->toArray()))->contains($producto->id)) ? 'selected':'' }}>{{$producto->nombre}}</option>
                                @endforeach
                            </select>
                            <small>Productos a los que no se le aplicará el cupón. O que no pueden estar en el carrito para que se aplique el &laquo;Descuento fijo en el carrito&raquo;</small>
                            @if ($errors->has('productos'))
                                <span class="help-block">{{ $errors->first('productos') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group">
                            <table class="">
                                <tbody>
                                    <tr>
                                        <td width="80%">Incluir categorías:</td>
                                        <td>
                                            <label class="switch">
                                            <input type="checkbox" name="incluir_categorias" id="incluir_categorias" value="1" {{ old('incluir_categorias', $coupon->incluir_categorias)  == '1' ? "checked" : ""}}/>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><small>Marca esta casilla si el cupón aplicará para categorías específicas. Se mostrará un campo para marcar las categorías a las que aplica el cupón.</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="include_category_container" class="col-sm-12" style="{{ old('incluir_categorias', $coupon->incluir_categorias) == '1' ? 'display:block;' : 'display:none;'}}">
                        <div class="form-group-with-help form-group {{ $errors->has('categorias') ? 'has-error' : '' }}">
                            <label for="categorias">Categorías incluidas:</label>
                            <select name="categorias[]" id="categorias" class="form-control" multiple="multiple">
                                @foreach($categories->where('padre', null) as $category)
                                    @if (count($categories->where('padre', $category->id)) == 0)
                                        <option value="{{ $category->id }}" {{(collect(old("categorias", $coupon->categories->where('tipo', 'incluido')->pluck('categoria_id')->toArray()))->contains($category->id)) ? 'selected':'' }}>{{ $category->nombre }}</option>
                                    @else
                                        <option disabled style="font-weight: bold;">{{ $category->nombre }}</option>
                                        @foreach($categories->where('padre', $category->id) as $subcategory)
                                            @if (count($categories->where('padre', $subcategory->id)) == 0)
                                                <option value="{{ $subcategory->id }}" {{(collect(old("categorias", $coupon->categories->where('tipo', 'incluido')->pluck('categoria_id')->toArray()))->contains($subcategory->id)) ? 'selected':'' }}>{{ $subcategory->nombre }}</option>
                                            @else
                                                <option disabled style="font-weight: bold;">&nbsp&nbsp{{ $subcategory->nombre }}</option>
                                                @foreach($categories->where('padre', $subcategory->id) as $sub_subcategory)
                                                    <option value="{{ $sub_subcategory->id }}" {{(collect(old("categorias", $coupon->categories->where('tipo', 'incluido')->pluck('categoria_id')->toArray()))->contains($sub_subcategory->id)) ? 'selected':'' }}>&nbsp&nbsp&nbsp&nbsp{{ $sub_subcategory->nombre }}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            <small>Categorías de productos a la que se le aplicará el cupón. O que tendrán que estar en el carrito para que se aplique el &laquo;Descuento fijo en el carrito&raquo;</small>
                            @if ($errors->has('categorias'))
                                <span class="help-block">{{ $errors->first('categorias') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('categorias_excluidas') ? 'has-error' : '' }}">
                            <label for="categorias_excluidas">Categorías excluidas:</label>
                            <select name="categorias_excluidas[]" id="categorias_excluidas" class="form-control" multiple="multiple">
                                @foreach($categories->where('padre', null) as $category)
                                    @if (count($categories->where('padre', $category->id)) == 0)
                                        <option value="{{ $category->id }}" {{(collect(old("categorias_excluidas", $coupon->categories->where('tipo', 'no_incluido')->pluck('categoria_id')->toArray()))->contains($category->id)) ? 'selected':'' }}>{{ $category->nombre }}</option>
                                    @else
                                        <option disabled style="font-weight: bold;">{{ $category->nombre }}</option>
                                        @foreach($categories->where('padre', $category->id) as $subcategory)
                                            @if (count($categories->where('padre', $subcategory->id)) == 0)
                                                <option value="{{ $subcategory->id }}" {{(collect(old("categorias_excluidas", $coupon->categories->where('tipo', 'no_incluido')->pluck('categoria_id')->toArray()))->contains($subcategory->id)) ? 'selected':'' }}>{{ $subcategory->nombre }}</option>
                                            @else
                                                <option disabled style="font-weight: bold;">&nbsp&nbsp{{ $subcategory->nombre }}</option>
                                                @foreach($categories->where('padre', $subcategory->id) as $sub_subcategory)
                                                    <option value="{{ $sub_subcategory->id }}" {{(collect(old("categorias_excluidas", $coupon->categories->where('tipo', 'no_incluido')->pluck('categoria_id')->toArray()))->contains($sub_subcategory->id)) ? 'selected':'' }}>&nbsp&nbsp&nbsp&nbsp{{ $sub_subcategory->nombre }}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            <small>Categorías de productos a las que no se prodrá aplicar el cupón. O que no prodrán estar en el carrito para que se aplique el &laquo;Descuento fijo en el carrito&raquo;</small>
                            @if ($errors->has('categorias_excluidas'))
                                <span class="help-block">{{ $errors->first('categorias_excluidas') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="limits">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('limites_uso') ? 'has-error' : '' }}" >
                            <label for="limites_uso">Límite de uso por cupón:</label>
                            <input type="number" min="0" name="limites_uso" id="limites_uso" class="form-control" value="{{ old('limites_uso', $coupon->limites_uso) }}" step="1" />
                            <small>Cuántas veces se puede usar este cupón antes que se anule.</small>
                            @if ($errors->has('limites_uso'))
                                <span class="help-block">{{ $errors->first('limites_uso') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group-with-help form-group {{ $errors->has('limites_uso_usuario') ? 'has-error' : '' }}" >
                            <label for="limites_uso_usuario">Límite de uso por usuario:</label>
                            <input type="number" min="0" name="limites_uso_usuario" id="limites_uso_usuario" class="form-control" value="{{ old('limites_uso_usuario', $coupon->limites_uso_usuario) }}" step="1" />
                            <small>Cuántas veces puede usar este cupón un solo usuario.</small>
                            @if ($errors->has('limites_uso_usuario'))
                                <span class="help-block">{{ $errors->first('limites_uso_usuario') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<p class="required">* Campos requeridos</p>