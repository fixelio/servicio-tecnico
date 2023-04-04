@extends('layout')

@section('content')
<section class="mx-2 mx-md-5 mb-5">
  <h3 class="mb-2">Registrar Cliente</h3>
  <div class="container-sm d-flex justify-content-center align-items-center mb-3">
    <form action="{{ route('cliente.post') }}" method="POST" class="row g-3 mt-5">
      @csrf
      <div class="col-12 col-lg-6 col-xl-4 mb-3">
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
      <div class="col-12 col-lg-6 col-xl-4 mb-3">
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
      <div class="col-12 col-lg-6 col-xl-4 mb-3">
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
      <div class="col-12 col-lg-6 col-xl-4 mb-3">
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
      <div class="block">
        <button class="btn btn-primary">Registrar</button>
      </div>
    </form>
  </div>

  @if(isset($type) && $type === 'exito')

  <div class="position-relative">
    <div class="position-absolute bottom-0 start-50 translate-middle-x">
      <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
        {{ $mensaje }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  </div>

  @elseif(isset($type) && $type === 'error')

  <div class="position-relative">
    <div class="position-absolute bottom-0 start-50 translate-middle-x">
      <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
        {{ $mensaje }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  </div>

  @endif
</section>