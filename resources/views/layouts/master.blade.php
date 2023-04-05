<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Servicio Técnico</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body class="antialiased">
  <nav class="navbar navbar-expand-lg bg-body-tertiary py-3 fixed-top">
    <div class="container px-4" id="nav-links">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i id="bar" class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('clientes') }}">Clientes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">Inicia Sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastPlacement">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
      <div class="toast-header">
        <strong class="me-auto">Notificación</strong>
        <small>Hace un instante</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body"></div>
    </div>
  </div>

  <main class="mt-5">
    @yield('content')
  </main>
</body>
</html>
