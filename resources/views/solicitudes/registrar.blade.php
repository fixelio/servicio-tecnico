@extends('layouts.master')

@section('content')
  <section class="my-5">
    <div class="container d-flex justify-content-center align-items-center flex-column mb-3">
      <div class="wrapper mt-5">
        <h3 class="mb-5">Datos del cliente:</h3>
        <p>Cliente: <strong>{{ $cliente['nombre'] }} {{ $cliente['apellido'] }}</strong> </p>
        <p>Correo electrónico: <strong>{{ $cliente['correo_electronico'] }}</strong></p>
        <p>Teléfono: <strong>{{ $cliente['telefono'] }}</strong></p>
        <a href="{{ route('clientes') }}" class="link-opacity-100">Cambiar cliente</a>
      </div>
      <form action="{{ route('solicitud.post') }}" method="POST" class="row g-3 mt-5">
        <h3 class="mb-5">Registrar órden de mantenimiento</h3>
        <p><strong>Ingresa los datos del equipo.</strong> Los campos obligatorios están marcados con (*)</p>
        @csrf
        <div class="col-12 mb-3">
          <label for="articulo" class="form-label">Artículo</label>
          <input
            type="text"
            id="articulo"
            name="articulo"
            class="form-control"
            placeholder="Ingresa el nombre del artículo"
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
            required
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
            required
          >
        </div>

        <div class="col-12 mb-3">
          <label for="descripcion_problema" class="form-label">
            Descripción del problema
          </label>
          <textarea name="descripcion_problema" id="descripcion_problema" class="form-control" rows="4"></textarea>
        </div>

        <div class="col-12 mb-3">
          <label for="observaciones" class="form-label">
            Observaciones
          </label>
          <textarea name="observaciones" id="observaciones" class="form-control" rows="4"></textarea>
        </div>

        <input type="hidden" name="correo" value="{{ $cliente['correo_electronico'] }}">

        <div>
          <button class="btn btn-primary">Registrar</button>
        </div>
      </form>
    </div>
  </section>
@stop