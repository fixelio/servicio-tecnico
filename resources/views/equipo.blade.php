@extends('layout')

@section('content')
<section class="mx-5">
  <div class="container-sm d-flex justify-content-center align-items-center flex-column">
    <form
      action="{{ route('equipo.post') }}"
      method="POST"
      class="row mt-5 g-3"
    >
      @csrf
      <div class="col-12 col-lg-6 col-xl-4 mb-3">
        <label for="num_serie" class="form-label">Número de Serie</label>
        <input
          type="text"
          id="num_serie"
          name="num_serie"
          class="form-control"
          placeholder="Ingresa"
          required
        >
      </div>
      <div class="col-12 col-lg-6 col-xl-4 mb-3">
        <label for="marca" class="form-label">Marca</label>
        <input
          type="text"
          id="marca"
          name="marca"
          class="form-control"
          placeholder="Ingresa"
          required
        >
      </div>
      <div class="col-12 col-lg-6 col-xl-4 mb-3">
        <label for="modelo" class="form-label">Modelo</label>
        <input
          type="text"
          id="modelo"
          name="modelo"
          class="form-control"
          placeholder="Ingresa"
          required
        >
      </div>
      <div class="col-12 col-lg-6 col-xl-4 mb-3">
        <label for="fecha_compra" class="form-label">Fecha de Compra</label>
        <input
          type="date"
          id="fecha_compra"
          name="fecha_compra"
          class="form-control"
          required
        >
      </div>
      <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
  </div>
</section>
@endsection