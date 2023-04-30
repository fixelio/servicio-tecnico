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
                    <h4 class="mb-0">{{ $ordenes }}</h4>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center py-3">
                <div class="icon-shape icon-sm icon-shape-secondary rounded me-3">
                  <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="d-block">
                  <label class="mb-0">Ingresos</label>
                  <h4 class="mb-0">{{ $total }} $</h4>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center py-3">
                <div class="icon-shape icon-sm icon-shape-success rounded me-3">
                  <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z"></path>
                  </svg>
                </div>
                <div class="d-block">
                  <label class="mb-0">Costo de Materiales</label>
                  <h4 class="mb-0">{{ $precioMateriales }} $</h4>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center py-3">
                <div class="icon-shape icon-sm icon-shape-purple rounded me-3">
                  <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008z"></path>
                  </svg>
                </div>
                <div class="d-block">
                  <label class="mb-0">Costo de Mano de Obra</label>
                  <h4 class="mb-0">{{ $precioReparacion }} $</h4>
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
  console.log(state);

  fechaDesde.onchange = (e) => {
    state.desde = e.target.value;
    if ((!state.desde || !state.hasta)) {
      boton.classList.add('disabled');
      return;
    }

    boton.classList.remove('disabled');
    boton.href = `/arqueos?desde=${state.desde}&hasta=${state.hasta}&tecnico=${state.tecnico}`;
  }

  fechaHasta.onchange = (e) => {
    state.hasta = e.target.value;
    if ((!state.desde || !state.hasta)) {
      boton.classList.add('disabled');
      return;
    }

    boton.classList.remove('disabled');
    boton.href = `/arqueos?desde=${state.desde}&hasta=${state.hasta}&tecnico=${state.tecnico}`;
  }

  tecnicos.onchange = (e) => {
    state.tecnico = e.target.value;

    if (!state.desde || !state.hasta) return;

    boton.href = `/arqueos?desde=${state.desde}&hasta=${state.hasta}&tecnico=${state.tecnico}`;
    boton.classList.remove('disabled');
  }


})();
  </script>    

@stop