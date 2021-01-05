@extends('admin.layout.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-borders">
			<div class="panel-heading">
				<h3>@yield('title')</h3>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				@yield('panel-content')
			</div>
		</div>
	</div>
</div>
@endsection
