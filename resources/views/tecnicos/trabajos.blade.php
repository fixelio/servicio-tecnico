@extends('layouts.master');

@section('content')
  <section class="my-5">
    <div class="container d-flex justify-content-center align-items-center flex-column">
      <form action="#" class="row mt-5" id="form-buscar-tecnico">
        <h3 class="mb-4">Buscar Técnico</h3>
        <div class="col-8 mb-3">
          <input
            type="email"
            id="buscar-correo-electronico"
            class="form-control"
            placeholder="Ingresa el correo del técnico"
            value="{{ $tecnico !== null ? $tecnico?->correo_electronico : '' }}"
          >
        </div>
        <div class="col-4 mb-3">
          <a class="btn btn-primary w-100" href="#" id="redireccion-solicitudes-tecnico"><i class="bi bi-search"></i> Buscar</a>
        </div>
      </form>
      <div class="wrapper mt-5">
        <h3 class="mb-5">Lista de solicitudes asignadas</h3>

        @if ($tecnico !== null)
        <p>Técnico: <strong>{{ $tecnico->nombre }} {{ $tecnico->apellido }}</strong></p>
        @endif

        @if(count($trabajos) > 0)
          <p class="mt-3 mb-4">Solicitudes: <strong>{{ count($trabajos) }}</strong></p>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Código</th>
                <th scope="col">Artículo</th>
                <th scope="col">Modelo</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estado</th>
              </tr>
            </thead>
            <tbody>
              @for($i = 0; $i < count($trabajos); $i++)
                <tr scope="row">
                  <th>{{$i + 1}}</th>
                  <td>{{ $trabajos[$i]->codigo_solicitud }}</td>
                  <td>{{ $trabajos[$i]->articulo }}</td>
                  <td>{{ $trabajos[$i]->modelo }}</td>
                  <td>{{ $trabajos[$i]->fecha_solicitud }}</td>
                  <td>
                    @if($trabajos[$i]->estado_solicitud === 'pendiente')
                      <span class="badge text-bg-warning">Pendiente</span>
                    @elseif($trabajos[$i]->estado_solicitud === 'en proceso')
                      <span class="badge text-bg-info">En Proceso</span>
                    @else
                      <span class="badge text-bg-success">Terminado</span>
                    @endif
                  </td>
                </tr>
              @endfor
            </tbody>
          </table>
        @elseif($tecnico !== null)
          <div class="alert alert-warning" role="alert">Este técnico no tiene ninguna solicitud de mantenimiento asignada. <a href="{{ route('listado-solicitudes') }}" class="link-opacity-100">Ir a la página de solicitudes.</a></div>
        @endif
      </div>
    </div>
    <script>
      window.addEventListener('DOMContentLoaded', () => {
        const $inputBuscarTecnico = document.querySelector('#buscar-correo-electronico');

        $inputBuscarTecnico.addEventListener('change', e => {
          const correo = e.target.value;
          const $enlace = document.querySelector('#redireccion-solicitudes-tecnico');
          if (!$enlace) {
            return;
          }

          if (!correo) {
            $enlace.setAttribute('href', '#');
            return;
          }

          $enlace.setAttribute('href', `/solicitudes/tecnico/${correo}`);
        });

        $inputBuscarTecnico.addEventListener('keyup', e => {
          const correo = e.target.value;
          const $enlace = document.querySelector('#redireccion-solicitudes-tecnico');
          if (!$enlace) {
            return;
          }

          if (!correo) {
            $enlace.setAttribute('href', '#');
            return;
          }

          $enlace.setAttribute('href', `/solicitudes/tecnico/${correo}`);
        });

        document.querySelector('#form-buscar-tecnico').addEventListener('submit', e => {
          e.preventDefault();
          const $enlace = document.querySelector('#redireccion-solicitudes-tecnico');
          if (!$enlace) {
            return;
          }

          $enlace.click();
        });
      });
    </script>
  </section>
@stop