<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Servicio Técnico</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/lib.js') }}"></script>
</head>
<body class="antialiased">
  <nav class="navbar navbar-expand-lg bg-body-tertiary py-3 fixed-top">
    <div class="container px-4" id="nav-links">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i id="bar" class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
          @guest
            @if (Route::has('login'))
              <li class="nav-item">
                 <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
            @endif
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('clientes') }}">Clientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('listado-solicitudes') }}">Solicitudes</a>
            </li>
            <li class="nav-item px-0 px-lg-4">
              <div class="form-check form-switch nav-link">
                <label class="form-check-label" for="lightSwitch">Modo Oscuro</label>
                <input class="form-check-input" type="checkbox" id="lightSwitch" />
              </div>
            </li>
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a
                  class="dropdown-item"
                  href="{{ route('logout') }}"
                  onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                >
                  {{ __('Logout') }}
                </a>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
              </div>
            </li>
          @endguest
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

  <script>
    (() => {
      let theme = 'light';
      const $themeSwitcher = document.querySelector('#lightSwitch');
      const storedTheme = localStorage.getItem('theme');

      if (storedTheme && storedTheme === 'dark') {
        theme = storedTheme;
        document.documentElement.setAttribute('data-bs-theme', theme);
        $themeSwitcher.checked = theme === 'dark';
      }

      $themeSwitcher.addEventListener('change', (e) => {
        theme = theme === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
      });
    })();
  </script>
</body>
</html>
