@extends('layouts.master');

@section('content')
  <div class="position-relative overflow-hidden">
    <h3 class="mb-5 p-3">Lista de Órdenes</h3>

    @if ($tecnico !== null)
      <div class="px-3">
        <p>Técnico: <strong>{{ $tecnico->nombre }} {{ $tecnico->apellido }}</strong></p>
      </div>
    @endif

    @if(count($trabajos) > 0)
      <div class="overflow-x-auto px-3">
        <table class="table">
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
    const ESTADO_TO_BADGE_BG = {
      'en proceso': 'info',
      'pendiente': 'warning',
      'terminado': 'success',
    }

    console.log(trabajo);

    return elt('tr', { scope: 'row', className: 'text-nowrap' },
      elt('th', { className: 'px-2 py-3 text-nowrap' }, trabajo.index),
      elt('td', { className: 'px-2 py-3 text-nowrap' }, trabajo.codigo),
      elt('td', { className: 'px-2 py-3 text-nowrap' }, trabajo.articulo),
      elt('td', { className: 'px-2 py-3 text-nowrap' }, trabajo.modelo),
      elt('td', { className: 'px-2 py-3 text-nowrap' }, trabajo.fecha),
      elt('td', { className: 'px-2 py-3 text-nowrap' },
        elt('span', { className: `badge text-bg-${ESTADO_TO_BADGE_BG[trabajo.estado]}` }, trabajo.estado)
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

  </div>
@stop