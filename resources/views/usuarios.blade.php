<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Usuarios</title>

  <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
  <ul>
    @foreach($users as $user)
      <li>{{ $user->nombre }}</li>
    @endforeach
  </ul>
  <button type="button" class="btn btn-primary">Botón</button>
</body>
</html>