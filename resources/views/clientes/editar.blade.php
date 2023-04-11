@extends('layouts.master')

@section('content')
  <div class="position-relative overflow-hidden">
    <h3 class="mb-5 p-3">Editar Cliente</h3>
    <form action="{{ route('cliente.put') }}" method="POST" class="row g-3 w-100 px-3">
      @csrf
      <div class="col-12 col-lg-6 mb-3">
        <label for="num_serie" class="form-label">Nombre</label>
        <input
          type="text"
          id="nombre"
          name="nombre"
          class="form-control"
          placeholder="Ingresa el nombre"
          value="{{ $cliente ? $cliente?->nombre : '' }}"
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
          value="{{ $cliente !== false ? $cliente?->apellido : '' }}"
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
          value="{{ $cliente !== false ? $cliente?->correo_electronico : '' }}"
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
          value="{{ $cliente !== false ? $cliente?->telefono : '' }}"
          required
        >
      </div>
      <input type="hidden" name="correo_buscar" value="{{ $cliente !== null ? $cliente?->correo_electronico : '' }}">
      <div>
        <button type="submit" class="btn btn-primary" id="boton-enviar-formulario">Editar</button>
      </div>
    </form>
    <script>
      window.addEventListener('DOMContentLoaded', () => {
        const $inputBuscarCliente = document.querySelector('#buscar-correo-electronico');
        const hayCliente = {{ $cliente === null ? 'false' : 'true' }};
        const $botonEnviarFormulario = document.querySelector('#boton-enviar-formulario');

        $botonEnviarFormulario.disabled = !hayCliente;

        $inputBuscarCliente.addEventListener('change', e => {
          const correo = e.target.value;
          const $enlace = document.querySelector('#redireccion--editar-cliente');
          if (!$enlace) {
            return;
          }

          if (!correo) {
            $enlace.setAttribute('href', '#');
            return;
          }

          $enlace.setAttribute('href', `/editar/cliente/${correo}`);
        });

        $inputBuscarCliente.addEventListener('keyup', e => {
          const correo = e.target.value;
          const $enlace = document.querySelector('#redireccion--editar-cliente');
          if (!$enlace) {
            return;
          }

          if (!correo) {
            $enlace.setAttribute('href', '#');
            return;
          }

          $enlace.setAttribute('href', `/editar/cliente/${correo}`);
        });

        document.querySelector('#form-buscar-cliente').addEventListener('submit', e => {
          e.preventDefault();
          const $enlace = document.querySelector('#redireccion--editar-cliente');
          if (!$enlace) {
            return;
          }

          $enlace.click();
        });
      });
    </script>
  </div>
@stop