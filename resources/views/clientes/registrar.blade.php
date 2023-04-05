@extends('layouts.master')

@section('content')
  <section class="my-5">
    <div class="container d-flex justify-content-center align-items-center mb-3 flex-column">
      <form action="{{ route('cliente.post') }}" method="POST" class="row g-3 mt-5">
        <h3 class="mb-5">Registrar Cliente</h3>
        @csrf
        <div class="col-12 col-lg-6 mb-3">
          <label for="num_serie" class="form-label">Nombre</label>
          <input
            type="text"
            id="nombre"
            name="nombre"
            class="form-control"
            placeholder="Ingresa el nombre"
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
            required
          >
        </div>
        <div>
          <button class="btn btn-primary">Registrar</button>
        </div>
      </form>
    </div>

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