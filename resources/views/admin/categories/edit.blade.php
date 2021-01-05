@extends('admin.layout.content')
@section('title', 'Editar Categoría - ' . $category->nombre)
@section('panel-content')
    <hr>
    @include('admin.partials.alerts')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="form-horizontal" autocomplete="off">
        @csrf
        @method('PUT')
        <div id="button-save">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-md-2 col-xs-6 col-md-offset-8">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-block">Cancelar</a>
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
                <p>Indica la información general para esta categoría.</p>
            </div>
            <div class="col-sm-9">
                <div class="col-sm-12">
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code">Código *:</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $category->codigo) }}" required>
                        @if ($errors->has('code'))
                            <span class="help-block">{{ $errors->first('code') }}</span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Nombre *:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->nombre) }}" required>
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h4>Subcategorías (opcional)</h4>
                <p>Indica las subcategorías con sus respectivas sub-subcategorías para este producto.</p><hr>
            </div>
            <div id="subcategories">
                @foreach($category->subcategories as $key => $subcategory)
                    <div id="containerSubcategory{{ $key + 1 }}">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <h5>Subcategoría {{ $key + 1 }} *</h5>
                                    <input type="text" name="subcategories[]" id="subcategory{{ $key + 1 }}" class="form-control" value="{{ old('subcategories.' . $key, $subcategory->nombre) }}" required>
                                </div>
                                <div class="col-sm-9">
                                    <h5 class="col-sm-9" style="padding: 0;">Sub-subcategorías (opcional)</h5>
                                    <div class="col-sm-3 text-right subcategory-delete subcategory-delete-{{ $key + 1 }} hide" style="padding: 0; padding-top: 10px;">
                                        <a href="javascript:void(0);" onclick="deleteSubcategory();">Eliminar</a>
                                    </div>
                                    <input type="text" name="sub_subcategories[]" id="sub-subcategory{{ $key + 1 }}" class="form-control" value="{{ old('sub_subcategories.' . $key, $subcategory->subcategories_string) }}">
                                    <small>Puede indicar las sub-subcategorías correspodientes a esta subcategoría separadas por comas.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-sm-12">
                <button id="add-subcategory" class="btn btn-success" type="button">Añadir subcategoría</button>
                <hr>
            </div>
            <div id="products"></div>
        </div>
        <p class="required">* Campos requeridos</p>
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/tag-editor.css') }}">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/products.js') }}"></script>
    <script src="{{ asset('admin/js/caret.min.js') }}"></script>
    <script src="{{ asset('admin/js/tag-editor.min.js') }}"></script>
    <script>
        let subcategories = '{{ count($category->subcategories) }}';
        let maxSubcategories = 10;

        $('#add-subcategory').click(function() {
            subcategories++;

            if (subcategories <= maxSubcategories) {
                $('.subcategory-delete').addClass('hide');

                $('#subcategories').append(
                    '<div id="containerSubcategory' + subcategories + '">' +
                        '<div class="col-sm-12">' +
                            '<div class="form-group">' +
                                '<div class="col-sm-3">' +
                                    '<h5>Subcategoría ' + subcategories + ' *</h5>' +
                                    '<input type="text" name="subcategories[]" id="subcategory' + subcategories + '" class="form-control" required>' +
                                '</div>' +
                                '<div class="col-sm-9">' +
                                    '<h5 class="col-sm-9" style="padding: 0;">Sub-subcategorías (opcional)</h5>' +
                                    '<div class="col-sm-3 text-right subcategory-delete subcategory-delete-' + subcategories + '" style="padding: 0; padding-top: 10px;">' +
                                        '<a href="javascript:void(0);" onclick="deleteSubcategory();">Eliminar</a>' +
                                    '</div>' +
                                    '<input type="text" name="sub_subcategories[]" id="sub-subcategory' + subcategories + '" class="form-control">' +
                                    '<small>Puede indicar las sub-subcategorías correspodientes a esta subcategoría separadas por comas.</small>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                );

                $('#sub-subcategory' + subcategories).tagEditor({
                    delimiter: ',',
                    forceLowercase: false,
                }).css('display', 'block').attr('readonly', true);
            }

            if (subcategories >= maxSubcategories) {
                $(this).addClass('hide');
            }
        });

        function deleteSubcategory() {
            if (subcategories > 0) {
                $('#containerSubcategory' + subcategories).remove();
                subcategories--;
                $('.subcategory-delete-' + subcategories).removeClass('hide');
            }

            if (subcategories < maxSubcategories) {
                $('#add-subcategory').removeClass('hide');
            }
        }

        $(function() {
            $('input[name="sub_subcategories[]"]').tagEditor({
                delimiter: ',',
                forceLowercase: false,
            }).css('display', 'block').attr('readonly', true);

            $('.subcategory-delete-' + subcategories).removeClass('hide');
        });
    </script>
@endpush
