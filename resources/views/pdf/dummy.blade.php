<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dummy Report</title>
</head>
<style>
.table-responsive {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
.table {
  width: 100%;
  margin-bottom: 1rem;
  vertical-align: top;
}
.table > :not(caption) > * > * {
  padding: 0.5rem 0.5rem;
}
.table > tbody {
  vertical-align: inherit;
}
.table > thead {
  vertical-align: bottom;
}

</style>
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