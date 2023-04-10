@extends('layouts.master')

@section('content')
  <section class="my-5">
    <div class="container d-flex justify-content-center align-items-center mb-3 flex-column">
      <form action="{{ route('tecnico.put') }}" method="POST" class="row g-3 mt-5">
        <h3 class="mb-4">Editar</h3>
        @csrf
        <div class="col-12 col-lg-6 mb-3">
          <label for="num_serie" class="form-label">Nombre</label>
          <input
            type="text"
            id="nombre"
            name="nombre"
            class="form-control"
            placeholder="Ingresa el nombre"
            value="{{ $tecnico ? $tecnico?->nombre : '' }}"
            required
          >
        </div>
        <div class="col-12 col-lg-6 mb-3">
          <label for="num_serie" class="form-label">Apellido</label>
          <input
            type="text"
            id="apellido"
            name="apellido"
            class="form-control"
            placeholder="Ingresa el apellido"
            value="{{ $tecnico !== false ? $tecnico?->apellido : '' }}"
            required
          >
        </div>
        <div class="col-12 col-lg-6 mb-3">
          <label for="num_serie" class="form-label">Correo</label>
          <input
            type="email"
            id="correo_electronico"
            name="correo_electronico"
            class="form-control"
            placeholder="Ingresa el correo"
            value="{{ $tecnico !== false ? $tecnico?->correo_electronico : '' }}"
            required
          >
        </div>
        <div class="col-12 col-lg-6 mb-3">
          <label for="num_serie" class="form-label">Teléfono</label>
          <input
            type="text"
            id="telefono"
            name="telefono"
            class="form-control"
            placeholder="Ingresa el teléfono"
            value="{{ $tecnico !== false ? $tecnico?->telefono : '' }}"
            required
          >
        </div>
        <input type="hidden" name="correo_buscar" value="{{ $tecnico !== null ? $tecnico?->correo_electronico : '' }}">
        <div>
          <button type="submit" class="btn btn-primary" id="boton-enviar-formulario">Editar</button>
        </div>
      </form>
    </div>

    <script>
      window.addEventListener('DOMContentLoaded', () => {
        const $inputBuscarTecnico = document.querySelector('#buscar-correo-electronico');
        const hayTecnico = {{ $tecnico === null ? 'false' : 'true' }};
        const $botonEnviarFormulario = document.querySelector('#boton-enviar-formulario');

        $botonEnviarFormulario.disabled = !hayTecnico;

        $inputBuscarTecnico.addEventListener('change', e => {
          const correo = e.target.value;
          const $enlace = document.querySelector('#redireccion-editar-tecnico');
          if (!$enlace) {
            return;
          }

          if (!correo) {
            $enlace.setAttribute('href', '#');
            return;
          }

          $enlace.setAttribute('href', `/editar/tecnico/${correo}`);
        });

        $inputBuscarTecnico.addEventListener('keyup', e => {
          const correo = e.target.value;
          const $enlace = document.querySelector('#redireccion-editar-tecnico');
          if (!$enlace) {
            return;
          }

          if (!correo) {
            $enlace.setAttribute('href', '#');
            return;
          }

          $enlace.setAttribute('href', `/editar/tecnico/${correo}`);
        });

        document.querySelector('#form-buscar-tecnico').addEventListener('submit', e => {
          e.preventDefault();
          const $enlace = document.querySelector('#redireccion-editar-tecnico');
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