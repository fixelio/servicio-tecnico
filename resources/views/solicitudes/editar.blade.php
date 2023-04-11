@extends('layouts.master')

@section('content')
  <div class="position-relative overflow-hidden">
    <h3 class="mb-5 px-3">Editar Orden</h3>
    <form action="{{ route('solicitud.put') }}" method="POST" class="row g-3 px-3 w-100">
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
  </div>
@stop