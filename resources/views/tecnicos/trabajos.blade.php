@extends('layouts.app');

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
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('listado-tecnicos') }}">Trabajos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Técnicos</li>
          </ol>
        </nav>
        <h2 class="h4">Órdenes Asignadas a {{ $tecnico->nombre }} {{ $tecnico->apellido }}</h2>
      </div>
    </div>

    @if(count($trabajos) > 0)
      <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Código
                  <div>
                    <button class="btn-actions" id="codigo-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="codigo-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Artículo
                  <div>
                    <button class="btn-actions" id="articulo-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="articulo-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Modelo
                  <div>
                    <button class="btn-actions" id="modelo-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="modelo-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Fecha
                  <div>
                    <button class="btn-actions" id="fecha-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="fecha-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Estado
                  <div>
                    <button class="btn-actions" id="estado-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="estado-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
            </tr>
          </thead>
          <tbody id="cuerpo-tabla-trabajos">

          </tbody>
        </table>
      </div>
    @elseif($tecnico !== null)
      <div class="alert alert-warning" role="alert">Este técnico no tiene ninguna órden de mantenimiento asignada. <a href="{{ route('listado-solicitudes') }}" class="link-opacity-100">Ir a la página de órdenes.</a></div>
    @endif
    <script>
(async() => {

  const ESTADO = {
    EN_PROCESO: 'en proceso',
    PENDIENTE: 'pendiente',
    TERMINADO: 'terminado',
  }

  const state = {
    trabajos: [],
    trabajosOrdenados: [],
  }

  function boot() {
    const raw = {{ Js::from($trabajos) }};
    const trabajos = raw.map((trabajo, index) => ({
      index: `${index + 1}`,
      codigo: trabajo.codigo_solicitud,
      articulo: trabajo.articulo,
      modelo: trabajo.modelo,
      fecha: trabajo.fecha_solicitud,
      estado: trabajo.estado_solicitud,
    }));

    const btnOrdenarCollection = Array.from(document.querySelectorAll('.btn-actions'));
    btnOrdenarCollection.forEach(btn => {
      
      btn.onclick = () => {
        const [columna, modo] = btn.id.split('-');
        ordenarPor(columna, modo);
      }
    });

    setState({ trabajos, trabajosOrdenados: trabajos });
  }

  function FilaTrabajo(trabajo) {
    const ESTADO_TO_BG = {
      'ingresado': 'danger',
      'presupuestado': 'warning',
      'en reparacion': 'info',
      'derivado': 'primary',
      'entregado': 'success'
    }

    return elt('tr', { scope: 'row', className: 'text-nowrap' },
      elt('th', { className: 'px-2 py-3 text-nowrap' }, trabajo.index),
      elt('td', { className: 'px-2 py-3 text-nowrap' }, trabajo.codigo),
      elt('td', { className: 'px-2 py-3 text-nowrap' }, trabajo.articulo),
      elt('td', { className: 'px-2 py-3 text-nowrap' }, trabajo.modelo),
      elt('td', { className: 'px-2 py-3 text-nowrap' }, trabajo.fecha),
      elt('td', { className: 'px-2 py-3 text-nowrap' },
        elt('span', { className: `badge bg-${ESTADO_TO_BG[trabajo.estado]}` }, trabajo.estado)
      )
    );
  }

  function ordenarPor(columna, modo) {
    const { trabajos } = getState();

    const ordenados = trabajos.sort((a, b) => {
      const aCol = a[columna];
      const bCol = b[columna];

      if (modo === 'asc') {
        return aCol.localeCompare(bCol);
      }
      else {
        return bCol.localeCompare(aCol);
      }
    });

    setState({ trabajosOrdenados: ordenados });
  }

  function render() {
    const $tabla = document.getElementById('cuerpo-tabla-trabajos');
    if (!$tabla) return;

    while($tabla.firstChild) {
      $tabla.removeChild($tabla.firstChild);
    }

    const { trabajosOrdenados } = getState();
    trabajosOrdenados.forEach(trabajo => {
      $tabla.appendChild(FilaTrabajo(trabajo));
    });
  }

  function getState() {
    return structuredClone(state);
  }

  function setState(newState) {
    for(const key in newState) {
      if(key in state === false) continue;

      state[key] = newState[key];
    }

    render();
  }

  window.addEventListener('DOMContentLoaded', () => {
    boot();
  })
})();
    </script>
  </section>
@stop