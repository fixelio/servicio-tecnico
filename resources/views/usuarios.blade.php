<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Usuarios</title>

  <script src="{{ asset('js/app.js') }}"></script>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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