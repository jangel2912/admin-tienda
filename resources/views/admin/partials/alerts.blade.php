@if (session()->has('success'))
<div class="alert alert-success">
	<p>{!! session('success') !!}</p>
</div>
@endif

@if (session()->has('warning'))
    <div class="alert alert-warning">
        <p>{!! session('warning') !!}</p>
    </div>
@endif

@if (session()->has('danger'))
<div class="alert alert-danger">
	<p>{!! session('danger') !!}</p>
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
	    <p>Error al intentar actualizar</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
