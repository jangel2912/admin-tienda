@extends('admin.layout.content')
@section('title', 'Editar Promoción')
@section('panel-content')
    @include('admin.partials.alerts')
    <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h4>Detalles</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $promotion->nombre) }}" class="form-control" required>
                    @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <hr>
        <h4>Periodo</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('initial_date') ? 'has-error' : '' }}">
                    <label for="initial_date">Fecha de Inicio</label>
                    <input type="date" id="initial_date" name="initial_date" value="{{ old('initial_date', $promotion->fecha_inicial) }}" class="form-control" required>
                    @if ($errors->has('initial_date'))
                        <span class="help-block">{{ $errors->first('initial_date') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('initial_time') ? 'has-error' : '' }}">
                    <label for="initial_time">Hora de Inicio</label>
                    <input type="time" id="initial_time" name="initial_time" value="{{ old('initial_time', $promotion->hora_inicio) }}" class="form-control" required>
                    @if ($errors->has('initial_time'))
                        <span class="help-block">{{ $errors->first('initial_time') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('final_date') ? 'has-error' : '' }}">
                    <label for="final_date">Fecha Final</label>
                    <input type="date" id="final_date" name="final_date" value="{{ old('final_date', $promotion->fecha_final) }}" class="form-control" required>
                    @if ($errors->has('final_date'))
                        <span class="help-block">{{ $errors->first('final_date') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('final_time') ? 'has-error' : '' }}">
                    <label for="final_time">Hora Final</label>
                    <input type="time" id="final_time" name="final_time" value="{{ old('final_time', $promotion->hora_fin) }}" class="form-control" required>
                    @if ($errors->has('final_time'))
                        <span class="help-block">{{ $errors->first('final_time') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="days">
                    <div @click="handlerDays(1)" class="day" :class="{ active: isOnSelectedDay(1) }">Lunes</div>
                    <div @click="handlerDays(2)" class="day" :class="{ active: isOnSelectedDay(2) }">Martes</div>
                    <div @click="handlerDays(3)" class="day" :class="{ active: isOnSelectedDay(3) }">Miercoles</div>
                    <div @click="handlerDays(4)" class="day" :class="{ active: isOnSelectedDay(4) }">Jueves</div>
                    <div @click="handlerDays(5)" class="day" :class="{ active: isOnSelectedDay(5) }">Viernes</div>
                    <div @click="handlerDays(6)" class="day" :class="{ active: isOnSelectedDay(6) }">Sabado</div>
                    <div @click="handlerDays(7)" class="day" :class="{ active: isOnSelectedDay(7) }">Domingo</div>
                </div>
            </div>
        </div>
        <hr>
        <h4>Productos</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Todos los productos</label>
                    <div class="products-list">
                        <ul>
                            <li v-for="product in products" @click="selectProduct(product)">@{{ product.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Productos Seleccionados</label>
                    <div class="products-list">
                        <ul>
                            <li v-for="product in selected_products" @click="removeProduct(product)">@{{ product.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <h4>Reglas de descuento</h4>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="qty">Cantidad de Productos</label>
                    <input type="number" id="qty" v-model="qty" class="form-control">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="percent">Porcentaje de Descuento</label>
                    <input type="number" id="percent" v-model="percent" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">Opciones</label>
                    <button type="button" @click="addRule()" class="btn btn-success btn-block">Agregar</button>
                </div>
            </div>
        </div>
        <div id="rules">
            <div class="row" v-for="(rule, index) in rules">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="number" :value="rule.qty" name="qty[]" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="number" :value="rule.percent" name="percent[]" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="button" @click="removeRule(index)" class="btn btn-danger btn-block">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <input type="hidden" name="days" v-model="daysString">
                <input type="hidden" name="products" v-model="selected_products_ids.toString()">
                <button type="submit" class="btn btn-success btn-block">Editar</button>
            </div>
        </div>
    </form>
@endsection

@push('styles')
    <style>
        .days {
            border: solid 1px #ccc;
            border-radius: 8px;
            display: flex;
            overflow: hidden;
        }

        .day {
            text-align: center;
            padding: 15px 0;
            border-right: solid 1px #ccc;
            flex-grow: 1;
            cursor: pointer;
        }

        .day:last-child {
            border: none;
        }

        .day:hover,
        .day:focus,
        .day:active,
        .day.active {
            background-color: rgba(92, 167, 69, 0.4);
        }

        .products-list {
            border: solid 1px #ccc;
            border-radius: 8px;
            height: 200px;
            overflow-y: scroll;
        }

        .products-list ul {
            list-style: none;
            padding: 0;
        }

        .products-list ul li {
            padding: 10px;
            border-bottom: solid 1px #ccc;
            cursor: pointer;
        }

        .products-list ul li:hover,
        .products-list ul li:focus,
        .products-list ul li:active {
            background-color: rgba(92, 167, 69, 0.4);
        }
    </style>
@endpush

@push('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                days: [],
                daysString: '{{ $promotion->dias }}',
                products: [],
                selected_products: [],
                selected_products_ids: [],
                rules: [],
                qty: null,
                percent: null,
            },
            methods: {
                handlerDays: function(day) {
                    if (this.days.indexOf(day) > -1) {
                        this.days.splice(this.days.indexOf(day), 1);
                    } else {
                        this.days.push(day);
                    }

                    this.daysString = this.days.toString();
                },
                isOnSelectedDay: function(day) {
                    return (this.days.indexOf(day) > -1) ? true : false;
                },
                selectProduct: function(product) {
                    this.selected_products_ids.push(product.id);
                    addObjectInArray(this.selected_products, product);
                    removeObjectOfArray(this.products, product);
                },
                removeProduct: function(product) {
                    this.selected_products_ids.splice(this.selected_products_ids.indexOf(product.id), 1);
                    addObjectInArray(this.products, product);
                    removeObjectOfArray(this.selected_products, product);
                },
                getAllProducts: function () {
                    let data = this;
                    axios.post('/admin/product/all-ajax').then(function (res) {
                        data.products = res.data.data;
                    }).catch(function (err) {
                        console.error(err);
                    })
                },
                getProducts: function () {
                    let data = this;
                    axios.post('/admin/product/all-ajax/promotion/{{ $promotion->id }}').then(function (res) {
                        res.data.data.forEach(function(product) {
                            data.selectProduct(product);
                        });
                    }).catch(function (err) {
                        console.error(err);
                    })
                },
                getDescriptions: function () {
                    let data = this;
                    axios.post('/admin/description/all-ajax/promotion/{{ $promotion->id }}').then(function (res) {
                        res.data.forEach(function({ cantidad, descuento }) {
                            data.addRule(cantidad, descuento);
                        });
                    }).catch(function (err) {
                        console.error(err);
                    })
                },
                addRule: function (qty = this.qty, percent = this.percent) {
                    this.rules.push({
                        qty,
                        percent,
                    });

                    this.qty = null;
                    this.percent = null;
                },
                removeRule: function (index) {
                    this.rules.splice(index, 1);
                },
            },
            beforeMount: function () {
                let days = ('{{ $promotion->dias }}').split(',');
                let that = this;

                this.getAllProducts();
                this.getProducts();
                this.getDescriptions();

                days.forEach(function(day) {
                    that.handlerDays(parseInt(day));
                });


            }
        });

        function addObjectInArray(array, object) {

            let total = array.length;

            if (total > 0) {
                let exist = false;

                for (let i = 0; i < total; i++) {
                    if (array[i].id == object.id) {
                        exist = true;
                        break;
                    }
                }

                if (!exist) {
                    array.push(object);
                }

            } else {
                array.push(object);
            }
        }

        function removeObjectOfArray(array, object) {
            let total = array.length;

            if (total > 0) {
                for (let i = 0; i < total; i++) {
                    if (array[i] && array[i].id == object.id) {
                        array.splice(i, 1);
                    }
                }
            }
        }
    </script>
@endpush
