@extends('admin.layout.content')
@section('title', 'Clientes')
@section('panel-content')
    <hr>
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-6 col-md-offset-2 text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-primary" onclick="event.preventDefault(); location.href='{{ route('admin.customers.download') }}'">Descargar Clientes</button>
            </div>
        </div>
    </div>
    <br>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>NIT/CC</th>
            <th>Teléfono</th>
            <th>Celular</th>
            <th>Dirreción</th>
            <th>Correo Electrónico</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->razon_social }}</td>
                <td>{{ $customer->tipo_identificacion . '-' . $customer->nif_cif }}</td>
                <td>{{ $customer->telefono }}</td>
                <td>{{ $customer->movil }}</td>
                <td>{{ $customer->direccion }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->poblacion }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $customers->links() }}
@endsection
