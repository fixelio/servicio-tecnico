@extends('layouts.master')

@section('content')
  <section class="my-5">
    <div class="container d-flex justify-content-center align-items-center flex-column">
      <div class="w-75">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h3 class="mb-2 my-5">Listado de Solicitudes</h3>
        </div>
        <div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Código</th>
                <th scope="col">Cliente</th>
                <th scope="col">Artículo</th>
                <th scope="col">Estado</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @for($i = 0; $i < count($solicitudes); $i++)
                <tr scope="row">
                  <th>{{ $i + 1 }}</th>
                  <td>{{ $solicitudes[$i]->codigo_solicitud }}</td>
                  <td>{{ $solicitudes[$i]->nombre }} {{ $solicitudes[$i]->apellido }}</td>
                  <td>{{ $solicitudes[$i]->modelo }}</td>
                  <td>{{ $solicitudes[$i]->estado_solicitud }}</td>
                  <td class="d-flex justify-content-end align-items-end">
                    <div class="dropdown dropdown-menu-end">
                      <button
                        class="btn btn-primary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        Acciones
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="{{ route('estado-solicitud.update', [
                          'codigo' => $solicitudes[$i]->codigo_solicitud,
                          'estado' => 'en proceso',
                        ]) }}" class="dropdown-item">Marcar como 'En proceso'</a></li>
                        <li><a href="{{ route('estado-solicitud.update', [
                          'codigo' => $solicitudes[$i]->codigo_solicitud,
                          'estado' => 'terminado',
                        ]) }}}}" class="dropdown-item">Marcar como 'Terminado'</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              @endfor
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script>
      const data = {{ Js::from($solicitudes) }};
      console.log(data);
    </script>
  </section>
@stop