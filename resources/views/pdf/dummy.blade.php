<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dummy Report</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

	 <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	 <link rel="stylesheet" href="{{ asset('css/main.css') }}">

	 <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
	<main>
		<h1>{{ $data }}</h1>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Cliente</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>1</th>
						<th>Julio Molina</th>
					</tr>
					<tr>
						<th>2</th>
						<th>Ximena Rocío</th>
					</tr>
					<tr>
						<th>3</th>
						<th>Juan Pérez</th>
					</tr>
				</tbody>
			</table>
		</div>
	</main>
</body>
</html>