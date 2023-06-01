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
          <li class="breadcrumb-item active">Arqueo</li>
        </ol>
      </nav>
      <h2 class="h4">Arqueos</h2>
    </div>
  </div>

  <div class="row mb-5">
    <div class="col-12">
      <div class="card border-0 shadow">
        <div class="card-body">
          <div class="row">
            <h3 class="col-12 h5 mb-3">Rango de fechas</h3>
            <div class="col-6 mb-3">
              <label for="fecha-desde">Desde</label>
              <div class="input-group">
                  <span class="input-group-text">
                      <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                  </span>
                  <input class="form-control" id="fecha-desde" type="date" value="{{ $desde }}" required>
              </div>
            </div>
            <div class="col-6 mb-4">
              <label for="fecha-hasta">Hasta</label>
              <div class="input-group">
                  <span class="input-group-text">
                      <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                  </span>
                  <input class="form-control" id="fecha-hasta" type="date" value="{{ $hasta }}" required>
              </div>
            </div>

            <h3 class="col-12 h5 mb-3">Técnico</h3>

            <div class="col-12 mb-4">
              <select class="form-control" id="tecnicos">
                <option value="all">Todos</option>
                @foreach($tecnicos as $tecnico)
                  <option value="{{ $tecnico['id_tecnico'] }}">
                    {{ $tecnico['nombre']}} {{ $tecnico['apellido']}}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <a href="#" class="btn btn-primary disabled" id="btn-buscar">Buscar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-5">
    <div class="col-12">
      <div class="card border-0 shadow">
        <div class="card-body">
          <h2 class="fs-5 fw-bold mb-5">Resumen {{ $desde }} {{ $desde !== '' ? '-' : ''}} {{ $hasta }}</h2>
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center py-3">
                <div class="icon-shape icon-sm icon-shape-danger rounded me-3">
                  <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="d-block">
                    <label class="mb-0">Total de Órdenes</label>
                    <h4 class="mb-0">{{ $filtrar ? $ordenes : '0' }}</h4>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center py-3">
                <div class="icon-shape icon-sm icon-shape-secondary rounded me-3">
                  <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="d-block">
                  <label class="mb-0">Ganancia</label>
                  <h4 class="mb-0">{{ $filtrar ? $precioReparacion : '0' }} $</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
        
</section>

  <script>
(() => {

  const state = {
    desde: '{{ $desde }}',
    hasta: '{{ $hasta }}',
    tecnico: '{{ $id_tecnico !== null ? $id_tecnico : 'all' }}',
  }

  const fechaDesde = document.querySelector('#fecha-desde');
  const fechaHasta = document.querySelector('#fecha-hasta');
  const tecnicos = document.querySelector('#tecnicos');
  const boton = document.querySelector('#btn-buscar');

  tecnicos.value = state.tecnico;

  fechaDesde.onchange = (e) => {
    state.desde = e.target.value;
    if ((!state.desde || !state.hasta)) {
      boton.classList.add('disabled');
      return;
    }

    boton.classList.remove('disabled');
    boton.href = `${document.location.origin}/servicio-tecnico/public/arqueos?desde=${state.desde}&hasta=${state.hasta}&tecnico=${state.tecnico}`;
  }

  fechaHasta.onchange = (e) => {
    state.hasta = e.target.value;
    if ((!state.desde || !state.hasta)) {
      boton.classList.add('disabled');
      return;
    }

    boton.classList.remove('disabled');
    boton.href = `${document.location.origin}/servicio-tecnico/public/arqueos?desde=${state.desde}&hasta=${state.hasta}&tecnico=${state.tecnico}`;
  }

  tecnicos.onchange = (e) => {
    state.tecnico = e.target.value;

    if (!state.desde || !state.hasta) return;

    boton.href = `${document.location.origin}/servicio-tecnico/public/arqueos?desde=${state.desde}&hasta=${state.hasta}&tecnico=${state.tecnico}`;
    boton.classList.remove('disabled');
  }


})();
  </script>    

@stop