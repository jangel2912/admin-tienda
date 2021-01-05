@extends('admin.layout.content')
@section('title', 'Cargar Productos')
@section('panel-content')
    <hr>
    @include('admin.partials.alerts')
    <form action="{{ route('admin.products.validate.excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="content-file" :class="{ active: files.type != null }">
            <h5 v-text="files.name">Da click aqui o arrastra el archivo para cargarlo</h5>
            <input type="file" name="excel" ref="myFiles" @change="previewFiles" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Productos con atributos:</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="product_with_attributes" id="product_with_attributes" v-model="product_with_attributes" {{ (!empty(old('product_with_attributes')) ? 'checked' : '') }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2 col-md-offset-5">
                <button class="btn btn-success btn-block" :class="{ hide: product_with_attributes }" :disabled="files.type !== null" onclick="event.preventDefault(); location.href='{{ route('admin.products.download.excel') }}'">Descarga Archivo</button>
                <button class="btn btn-success btn-block" :class="{ hide: !product_with_attributes }" :disabled="files.type !== null" onclick="event.preventDefault(); location.href='{{ route('admin.products.downloadWithAttributes.excel') }}'">Descarga Archivo</button>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-block" :disabled="files.type == null">Cargar</button>
            </div>
        </div>
    </form>
    @if(session()->has('products'))
        <h3>Los siguientes productos no pudieron ser agregados</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Categoría</th>
                <th>Subcategoría</th>
                <th>Sub-subcategoría</th>
                <th>Código</th>
                <th>Nombre</th>
            </tr>
            </thead>
            <tbody>
            @foreach(session('products') as $key => $product)
                <tr>
                    <td>{{ $product['0'] }}</td>
                    <td>{{ $product['1'] }}</td>
                    <td>{{ $product['2'] }}</td>
                    <td>{{ $product['5'] }}</td>
                    <td>{{ $product['3'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection

@push('styles')
    <style>
        #content-file {
            border: solid 1px #ccc;
            height: 200px;
            border-radius: 5px;
            position: relative;
        }

        #content-file.active {
            color: #5eb85b;
            background-color: rgba(94, 184, 91, 0.1);
            border: solid 1px #5eb85b;
        }

        #content-file h5 {
            text-align: center;
            width: 100%;
            position: absolute;
            top: 40%;
            z-index: 999;
        }

        #content-file input {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .table > tbody > tr > td {
            vertical-align: inherit !important;
            border-top: none !important;
            padding: 0 !important;
        }

        .btn-block+.btn-block {
            margin-top: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                files: {
                    name: 'Da click aqui o arrastra el archivo para cargarlo',
                    type: null
                },
                product_with_attributes: '{{ !empty(old("product_with_attributes")) }}',
            },
            methods: {
                previewFiles: function () {
                    this.files = this.$refs.myFiles.files[0];
                    console.log(this.files);
                }
            }
        });
    </script>
@endpush
