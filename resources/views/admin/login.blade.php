<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<title>Document</title>
	</head>
	<body>
		<script src="{{ asset('bower_components/cross-storage/dist/client.min.js') }}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
        console.log('{{ env('CROSS_DOMAIN') }}');
		var storage = new CrossStorageClient('{{ env('CROSS_DOMAIN') }}');

		storage.onConnect().then()
			.then(function() {
				return storage.get('data');
			}).then(function(res) {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				console.log(res);
				$.post('/admin/crosslogin', {
					data: res
				}, function(data, textStatus, xhr) {
					if (data.status) {
						location.href = '/admin/dashboard';
					} else {
						location.href = '/admin/login';
					}
				});
			})['catch'](function(err) {
				console.log(err);
			});
		</script>
	</body>
</html>
