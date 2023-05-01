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
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
          </ol>
        </nav>
        <h2 class="h4">Registrar Orden</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-12 mb-4">
        <div class="card border-0 shadow">
          <div class="card-body">
            <div class="row d-block d-xl-flex align-items-start">
              <div class="col-12 col-xl-2 text-xl-center mb-3 mb-xl-0 d-flex align-items-start justify-content-xl-start">
                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                  <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                </div>
              </div>
                <div class="col-12 col-xl-10 px-xl-0">
                  <div class="d-none d-sm-block">
                    <h2 class="h6 text-gray-400 mb-0">Datos del Cliente</h2>
                    <h3 class="fw-extrabold mb-2">{{ $cliente->nombre }} {{ $cliente->apellido}}</h3>
                  </div>
                  <div class="d-flex justify-content-start align-items-center text-gray-500">
                    {{ $cliente->correo_electronico }}
                  </div> 
                  <p class="d-flex mt-1">
                    {{ $cliente->telefono }}
                  </p>
                  <a href="{{ route('clientes') }}" class="btn btn-secondary">Cambiar cliente</a>
                </div>
            </div>
          </div>
        </div>
    </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-body border-0 shadow mb-4">
          <form action="{{ route('solicitud.post') }}" method="POST" id="form-registrar" class="row g-3 w-100">
            @csrf
            <div class="col-12 mb-3">
              <label for="tecnico_responsable_content" class="form-label">Técnico Responsable <span class="required">*</span></label>
                <select
                  class="form-select"
                    aria-label="Técnico responsable de la solicitud"
                    id="tecnico_responsable_content"
                    name="correo_tecnico"
                    required
                  >
                  @foreach($tecnicos as $tecnico)
                    <option value="{{ $tecnico->correo_electronico }}">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</option>
                  @endforeach
                </select>
            </div>
            <p><strong>Ingresa los datos del equipo.</strong> Los campos obligatorios están marcados con (*)</p>
            
            <div class="col-12 mb-3">
              <label for="articulo" class="form-label">Artículo <span class="required">*</span></label>
              <input
                type="text"
                id="articulo"
                name="articulo"
                class="form-control"
                placeholder="Ingresa el nombre del artículo"
                required
              >
            </div>
            <div class="col-12 col-sm-6 mb-3">
              <label for="num_serie" class="form-label">Número de Serie</label>
              <input
                type="text"
                id="num_serie"
                name="num_serie"
                class="form-control"
                placeholder="Ingresa el número de serie"
              >
            </div>
            <div class="col-12 col-sm-6 mb-3">
              <label for="marca" class="form-label">Marca</label>
              <input
                type="text"
                id="marca"
                name="marca"
                class="form-control"
                placeholder="Ingresa la marca"
              >
            </div>
            <div class="col-12 col-sm-6 mb-3">
              <label for="modelo" class="form-label">Modelo</label>
              <input
                type="text"
                id="modelo"
                name="modelo"
                class="form-control"
                placeholder="Ingresa el modelo"
              >
            </div>
            @csrf
            <div class="col-12 col-sm-6 mb-3">
              <label for="fecha_compra" class="form-label">Fecha de ingreso <span class="required">*</span></label>
              <input
                type="date"
                id="fecha_compra"
                name="fecha_compra"
                class="form-control"
                placeholder="Ingresa la fecha de ingreso"
                required
              >
            </div>

            <div class="col-12 mb-3">
              <label for="descripcion_problema" class="form-label">
                Descripción del problema <span class="required">*</span>
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
              <button id="btn-registrar" type="submit" class="btn btn-primary">Registrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      document.getElementById('btn-registrar').onclick = e => {
        const $form = document.getElementById('form-registrar');
        setTimeout(() => $form.reset(), 4000);
      }

      window.addEventListener('DOMContentLoaded', () => {
        const $fecha = document.querySelector('#fecha_compra');
        $fecha.valueAsDate = new Date(Date.now());
      });
    </script>

  </section>
@stop