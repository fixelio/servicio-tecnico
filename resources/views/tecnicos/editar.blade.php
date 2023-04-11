@extends('layouts.master')

@section('content')
  <div class="position-relative overflow-hidden">
    <h3 class="mb-5 p-3">Editar Técnico</h3>

    <form action="{{ route('tecnico.put') }}" method="POST" class="row g-3 w-100 px-3">
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
  </div>
@stop