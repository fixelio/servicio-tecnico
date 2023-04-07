@extends('layouts.master')

@section('content')
  <section class="my-5">
    <div class="container d-flex jus
    tify-content-center align-items-center flex-column mb-3">
      <form action="#" class="row mt-5" id="form-buscar-solicitud">
        <h3 class="mb-4 mt-5">Buscar Solicitud</h3>
        <div class="col-9 mb-3">
          <input
            type="email"
            id="buscar-codigo"
            class="form-control"
            placeholder="Ingresa el codigo de la solicitud"
            value="{{ $solicitud !== null ? $solicitud?->codigo_solicitud : '' }}"
          >
        </div>
        <div class="col-3 mb-3">
          <a class="btn btn-primary w-100" href="#" id="redireccion-codigo-solicitud"><i class="bi bi-search"></i> Buscar</a>
        </div>
      </form>
      <form action="{{ route('solicitud.put') }}" method="POST" class="row g-3 mt-5">
        <h3 class="mb-4">Editar solicitud de mantenimiento</h3>
        @csrf
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
        @csrf
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