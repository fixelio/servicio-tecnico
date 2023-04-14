@extends('layouts.app')

@section('content')
  <section>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
      <div class="d-block">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
          <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
              <a href="/">
                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
              </a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('listado-solicitudes') }}">Órdenes</a></li>
            <li class="breadcrumb-item active">Editar</li>
          </ol>
        </nav>
        <h2 class="h4">Editar Orden</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-body border-0 shadow mb-4">
          <form action="{{ route('solicitud.put') }}" method="POST" class="row g-3 w-100">
          @csrf
          <div class="col-12 mb-3">
            <label for="articulo" class="form-label">Artículo</label>
            <input
              type="text"
              id="articulo"
              name="articulo"
              class="form-control"
              placeholder="Ingresa el nombre del artículo"
              value="{{ $solicitud !== null ? $solicitud?->articulo : '' }}"
            >
          </div>
          <div class="col-12 col-lg-6 mb-3">
            <label for="num_serie" class="form-label">Número de Serie</label>
            <input
              type="text"
              id="num_serie"
              name="num_serie"
              class="form-control"
              placeholder="Ingresa el número de serie"
              value="{{ $solicitud !== null ? $solicitud?->num_serie : '' }}"
            >
          </div>
          <div class="col-12 col-lg-6 mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input
              type="text"
              id="marca"
              name="marca"
              class="form-control"
              placeholder="Ingresa la marca"
              value="{{ $solicitud !== null ? $solicitud?->marca : '' }}"
            >
          </div>
          <div class="col-12 col-lg-6 mb-3">
            <label for="modelo" class="form-label">Modelo *</label>
            <input
              type="text"
              id="modelo"
              name="modelo"
              class="form-control"
              placeholder="Ingresa el modelo"
              value="{{ $solicitud !== null ? $solicitud?->modelo : '' }}"
            >
          </div>
          <div class="col-12 col-lg-6 mb-3">
            <label for="fecha_compra" class="form-label">Fecha de compra *</label>
            <input
              type="date"
              id="fecha_compra"
              name="fecha_compra"
              class="form-control"
              placeholder="Ingresa la fecha de compra"
              value="{{ $solicitud !== null ? $solicitud?->fecha_compra : '' }}"
            >
          </div>

          <div class="col-12 mb-3">
            <label for="descripcion_problema" class="form-label">
              Descripción del problema
            </label>
            <textarea name="descripcion_problema" id="descripcion_problema" class="form-control" rows="4" value="{{ $solicitud !== null ? $solicitud?->descripcion_problema : '' }}">{{ $solicitud !== null ? $solicitud?->descripcion_problema : '' }}</textarea>
          </div>

          <div class="col-12 mb-3">
            <label for="observaciones" class="form-label">
              Observaciones
            </label>
            <textarea name="observaciones" id="observaciones" class="form-control" rows="4" value="{{ $solicitud !== null ? $solicitud?->observaciones : '' }}">{{ $solicitud !== null ? $solicitud?->observaciones : '' }}</textarea>
          </div>

          <input type="hidden" name="codigo_buscar" value="{{ $solicitud?->codigo_solicitud }}">

          <div>
            <button type="submit" class="btn btn-primary" id="boton-enviar-formulario">Editar</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <script>
      window.addEventListener('DOMContentLoaded', () => {
        const $inputBuscarCliente = document.querySelector('#buscar-codigo');
        const haySolicitud = {{ $solicitud === null ? 'false' : 'true' }};
        const $botonEnviarFormulario = document.querySelector('#boton-enviar-formulario');

        $botonEnviarFormulario.disabled = !haySolicitud;

        $inputBuscarCliente.addEventListener('change', e => {
          const codigo = e.target.value;
          const $enlace = document.querySelector('#redireccion-codigo-solicitud');
          if (!$enlace) {
            return;
          }

          if (!codigo) {
            $enlace.setAttribute('href', '#');
            return;
          }

          $enlace.setAttribute('href', `/editar/solicitud/${codigo}`);
        });

        $inputBuscarCliente.addEventListener('keyup', e => {
          const codigo = e.target.value;
          const $enlace = document.querySelector('#redireccion-codigo-solicitud');
          if (!$enlace) {
            return;
          }

          if (!codigo) {
            $enlace.setAttribute('href', '#');
            return;
          }

          $enlace.setAttribute('href', `/editar/solicitud/${codigo}`);
        });

        document.querySelector('#form-buscar-solicitud').addEventListener('submit', e => {
          e.preventDefault();
          const $enlace = document.querySelector('#redireccion-codigo-solicitud');
          if (!$enlace) {
            return;
          }

          $enlace.click();
        });
      });
    </script>

    @if(session()->get('type') !== null && session()->get('mensaje') !== null)

    <script>
      const toastElement = document.querySelector('.toast');
      const content = document.querySelector('.toast-body');
      const toast = new bootstrap.Toast(toastElement);

      content.textContent = "{{ session()->get('type') === 'exito' ? 'Mensaje' : 'Error' }}: {{ session()->get('mensaje') }}";

      toast.show();

      setTimeout(() => toast.hide(), 5000);
    </script>

    @endif
    
  </section>
@stop