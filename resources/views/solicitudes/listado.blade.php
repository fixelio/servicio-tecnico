@extends('layouts.app')

@section('content')
  <section>
    <div class="modal fade" id="modal-asignar-tecnico" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Asignar técnico</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="#" class="row g-2 w-100" onsubmit="event.preventDefault();">
              <div class="col-12 mb-3">
                <label for="tecnico_responsable_content" class="form-label">Técnico</label>
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
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              data-bs-dismiss="modal"
              id="boton-modal-establecer-tecnico"
            >Establecer</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-estado-terminado" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Terminar Solicitud</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="#" class="row g-2 w-100" onsubmit="event.preventDefault();">
              <div class="col-12 mb-3">
                <label for="descripcion_solucion_content" class="form-label">Descripción de la solución</label>
                <textarea id="descripcion_solucion_content" class="form-control" rows="4"></textarea>
              </div>
              <div class="col-12 mb-3">
                <label for="garantia_content" class="form-label">Garantía</label>
                <input type="text" class="form-control" id="garantia_content" value="">
              </div>
              <div class="col-12 mb-3">
                <label for="monto_content" class="form-label">Monto a pagar</label>
                <input type="number" class="form-control" id="monto_content" value="" pattern="[0-9]+([\.,][0-9]+)?" step="0.01">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              data-bs-dismiss="modal"
              id="boton-modal-establecer"
            >Establecer</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
      <div class="d-block">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
          <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
              <a href="/">
                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Órdenes</li>
          </ol>
        </nav>
        <h2 class="h4">Lista de Órdenes</h2>
      </div>
    </div>

    <!--@if(count($solicitudes) > 0)

    <div class="table-settings mb-4">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="w-100 py-3 mx-md-2 mb-2">
          <form action="#" class="d-flex align-items-center w-100">
            <label for="simpleSearch"></label>
            <div class="input-group flex-nowrap">
              <span class="bi bi-search input-group-text" id="addon-wrapping"></span>
              <input type="text" class="form-control" placeholder="Buscar" aria-label="cliente" aria-describedby="addon-wrapping" id="input-filtro">
            </div>
          </form>
        </div>
        <div class="w-100 d-flex flex-column flex-sm-row justify-content-end py-3">
          <a href="{{ route('registrar-cliente') }}" class="btn btn-secondary mb-2 d-flex justify-content-center align-items-center text-nowrap w-100">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Registrar Orden
          </a>
          <div class="dropdown w-100 mx-sm-2 mb-2 d-flex justify-content-center align-items-center">
            <button class="btn btn-secondary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"></path>
              </svg>
              Filtrar
            </button>
            <ul class="dropdown-menu">
              <li><button class="dropdown-item" id="filtrar-nombre">Nombre</button></li>
              <li><button class="dropdown-item" id="filtrar-correo">Correo</button></li>
              <li>
                <button class="dropdown-item">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkPendientes">
                    <label class="form-check-label" for="checkPendientes">
                        Estado: Pendiente
                    </label>
                  </div>
                </button>
              </li>
              <li>
                <button class="dropdown-item">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkProceso">
                    <label class="form-check-label" for="checkProceso">
                        Estado: En Proceso
                    </label>
                  </div>
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    @endif-->

    @if(count($solicitudes) > 0)

      <div class="card card-body border-0 shadow table-wrapper table-responsive mb-5 pb-5" style="padding-bottom: 6.5rem">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="border-gray-200">#</th>
              <th class="border-gray-200">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Orden
                  <div>
                    <button class="btn-actions" id="orden-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="orden-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>           
              <th class="border-gray-200">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Cliente
                  <div>
                    <button class="btn-actions" id="cliente-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="cliente-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th class="border-gray-200">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Equipo
                  <div>
                    <button class="btn-actions" id="equipo-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="equipo-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th class="border-gray-200">
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
              <th class="border-gray-200">Acciones</th>
            </tr>
          </thead>
          <tbody id="cuerpo-tabla-solicitudes"></tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-md-row align-items-center justify-content-between pb-5">
          @if ($links->links()->paginator->hasPages())

          {{ $links->links() }}

          @endif

          <div class="fw-normal mb-5 mb-md-0 small">Mostrando <b id="min-records">{{ count($solicitudes)}}</b> de <b>{{ $maxSolicitudes }}</b> órdenes</div>
        </div>
      </div>

      @else
        <div class="alert alert-info" role="alert">
          En este momento no hay órdenes de mantenimiento procesándose. <a class="link-opacity-100" href="/clientes">Ir a la lista de clientes.</a>
        </div>
      @endif

    <form id="cambiar-estado-form" action="{{ route('estado-solicitud.put') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="codigo_solicitud" id="codigo_solicitud" value="">
        <input type="hidden" name="estado_solicitud" id="estado_solicitud" value="">
        <input type="hidden" name="descripcion_solucion" id="descripcion_solucion" value="">
        <input type="hidden" name="correo_tecnico" id="correo_tecnico" value="{{ count($tecnicos) > 0 ? $tecnicos[0]->correo_electronico : '' }}">
        <input type="hidden" name="garantia" id="garantia" value="">
        <input type="hidden" name="monto" id="monto" value="">
    </form>

    <script>

(async() => {
  const ORDENAR_POR = {
    FECHA_ASC: 'fecha ascendiente',
    FECHA_DESC: 'fecha descendiente',
    ESTADO_PENDIENTE: 'pendientes',
    ESTADO_EN_PROCESO: 'en proceso',
  }

  const ESTADO = {
    'ingresado': 'Ingresado',
    'presupuestado': 'Presupuestado',
    'en reparacion': 'En Reparación',
    'derivado': 'Derivado',
    'entregado': 'Entregado',
    'listo': 'Listo',
  }

  const state = {
    ordenes: [],
    ordenesOrdenadas: [],
    filtro: ORDENAR_POR.FECHA_DESC,
  }

  function boot() {
    const raw = {{ Js::from($solicitudes) }};
    const ordenes = raw.map((solicitud) => ({
      solicitud: {
        codigo: solicitud.codigo_solicitud,
        articulo: solicitud.articulo,
        estado: solicitud.estado_solicitud,
        fecha: solicitud.fecha_solicitud,
      },
      cliente: {
        nombre: `${solicitud.nombre} ${solicitud.apellido}`,
        correo: solicitud.correo_electronico,
      }
    }));

    const btnOrdenarCollection = Array.from(document.querySelectorAll('.btn-actions'));
    btnOrdenarCollection.forEach(btn => {
      
      btn.onclick = () => {
        const [columna, modo] = btn.id.split('-');
        ordenarPor(columna, modo);
      }
    });

    setState({
      ordenes,
      ordenesOrdenadas: ordenes,
    });
  }

  function FilaOrden(data) {
    const $acciones = elt('td', { className: 'ml-3' });

    if (data.solicitud.estado !== 'listo') {
      const $boton = elt('button', {
        className: 'focus-ring px-2 rounded fs-5',
        type: 'button'
      }, elt('i', { className: 'bi bi-three-dots' }, ''));

      $boton.setAttribute('data-bs-toggle', 'dropdown');
      $boton.setAttribute('aria-expanded', 'false');
      $boton.style.outline = 'none';
      $boton.style.border = 'none';
      $boton.style.background = 'none';

      const codigo = data.solicitud.codigo;
      const estado = data.solicitud.estado;

      $acciones.appendChild(
        elt('div', { },
          $boton,
          elt('ul', { className: 'dropdown-menu' },
            elt('li', {},
              elt('a', { className: 'dropdown-item', href: `/editar/solicitud/${data.solicitud.codigo}` }, 'Editar'),
            ),
            elt('li', {},
              elt('button', { className: 'dropdown-item', onclick: () => cambiarEstado(codigo, 'presupuestado'), disabled: estado === 'listo' }, 'Marcar como "Presupuestado"')
            ),
            elt('li', {},
              elt('button', { className: 'dropdown-item', onclick: () => cambiarEstado(codigo, 'en reparacion'), disabled: estado === 'listo' }, 'Marcar como "En Reparación"'),
            ),
            elt('li', {},
              elt('button', { className: 'dropdown-item', onclick: () => cambiarEstado(codigo, 'derivado'), disabled: estado === 'listo' }, 'Marcar como "Derivado"'),
            ),
            elt('li', {},
              elt('button', { className: 'dropdown-item', onclick: () => marcarTerminado(data), disabled: estado === 'listo' }, 'Marcar como "Entregado"'),
            ),
            elt('li', {},
              elt('button', { className: 'dropdown-item', onclick: () => cambiarEstado(codigo, 'listo'), disabled: estado === 'listo' }, 'Marcar como "Listo"'),
            )
          )
        )
      );
    }
    else {
      $acciones.appendChild(document.createTextNode('Sin acciones'));
    }

    const ESTADO_TO_BG = {
      'ingresado': 'danger',
      'presupuestado': 'warning',
      'en reparacion': 'info',
      'derivado': 'primary',
      'entregado': 'success',
      'listo': 'success',
    }

    const element = elt('tr', { scope: 'row', id: `solicitud-${data.solicitud.codigo}`, className: 'text-nowrap' },
      elt('th', { className: "px-2 py-3" }, data.index),
      elt('td', { className: "px-2 py-3" }, data.solicitud.codigo),
      elt('td', { className: "px-2 py-3" }, data.cliente.nombre),
      elt('td', { className: "px-2 py-3" }, data.solicitud.articulo),
      elt('td', { className: "px-2 py-3" }, 
        elt('span', {
          className: `badge bg-${ESTADO_TO_BG[data.solicitud.estado]}`
        }, ESTADO[data.solicitud.estado])),
      $acciones
    );

    return element
  }

  function ordenarPor(columna, modo) {
    const { ordenes } = getState();

    const ordenadas = ordenes.sort((a, b) => {
      if (columna === 'cliente') {
        const aNombre = a.cliente.nombre;
        const bNombre = b.cliente.nombre;

        if (modo === 'asc') {
          return aNombre[0] < bNombre[0] ? -1 : 1;
        }
        else {
          return aNombre[0] > bNombre[0] ? -1 : 1;
        }
      }

      const aCol = a.solicitud[columna];
      const bCol = b.solicitud[columna];

      if (modo === 'asc') {
        return aCol.localeCompare(bCol);
      }
      else {
        return bCol.localeCompare(aCol);
      }
    });

    setState({ ordenesOrdenadas: ordenadas });
  }

  function render() {
    const { ordenesOrdenadas } = getState();
    const $tabla = document.querySelector('#cuerpo-tabla-solicitudes');
    if (!$tabla) {
      return;
    }

    while($tabla.firstChild) {
      $tabla.removeChild($tabla.firstChild);
    }

    ordenesOrdenadas.forEach((orden, index) => {
      const data = { ...orden, index: `${index + 1}` };
      $tabla.appendChild(FilaOrden(data));
    });
  }

  function getState() {
    return structuredClone(state);
  }

  function setState(newState) {
    for(const key in newState) {
      if (key in state === false) return;

      state[key] = newState[key];
    }

    render();
  }

  window.addEventListener('DOMContentLoaded', () => {
    boot();
  });

  async function marcarTerminado(data) {
    const $form = document.getElementById('cambiar-estado-form');

    let $codigo = document.getElementById('codigo_solicitud');
    let $estado = document.getElementById('estado_solicitud');
    let $descripcion = document.getElementById('descripcion_solucion');
    let $garantia = document.getElementById('garantia');
    let $monto = document.getElementById('monto');

    const $inputDescripcion = document.getElementById('descripcion_solucion_content');
    const $inputGarantia = document.getElementById('garantia_content');
    const $inputMonto = document.getElementById('monto_content');

    const $modal = document.querySelector('#modal-estado-terminado');
    const modal = new bootstrap.Modal($modal, {});

    $inputDescripcion.addEventListener('change', e => {
      $descripcion.value = e.target.value;
    });

    $inputDescripcion.addEventListener('keyup', e => {
      $descripcion.value = e.target.value;
    });


    $inputGarantia.addEventListener('change', e => {
      $garantia.value = e.target.value;
    });

    $inputGarantia.addEventListener('keyup', e => {
      $garantia.value = e.target.value;
    });


    $inputMonto.addEventListener('change', e => {
      $monto.value = e.target.value;
    });

    $inputMonto.addEventListener('keyup', e => {
      $monto.value = e.target.value;
    });

    const $botonModalEstablecer = document.querySelector('#boton-modal-establecer');
    $botonModalEstablecer.onclick = () => {
      $inputDescripcion.value = '';
      $inputGarantia.value = '';
      $inputMonto.value = '';

      $codigo.value = data.solicitud.codigo;
      $estado.value = 'entregado';

      $form.submit();

      const { ordenes, ordenesOrdenadas } = getState();
      const indexOrden = ordenes.findIndex(orden => orden.solicitud.codigo === data.solicitud.codigo);
      ordenes[indexOrden].solicitud.estado = 'entregado';

      const indexOrdenada = ordenesOrdenadas.findIndex(orden => orden.solicitud.codigo === data.solicitud.codigo);
      ordenesOrdenadas[indexOrdenada].solicitud.estado = 'entregado';
      modal.hide();

      setState({ ordenes, ordenesOrdenadas });
    }

    modal.show();
  }

  async function cambiarEstado(codigo, estado) {
    const $form = document.getElementById('cambiar-estado-form');

    let $codigo = document.getElementById('codigo_solicitud');
    let $estado = document.getElementById('estado_solicitud');

    $codigo.value = codigo;
    $estado.value = estado;

    $form.submit();
  }

  async function marcarEnProceso(data) {
    const $form = document.getElementById('cambiar-estado-form');

    let $codigo = document.getElementById('codigo_solicitud');
    let $estado = document.getElementById('estado_solicitud');
    let $tecnico = document.getElementById('correo_tecnico');

    const $selectTecnico = document.getElementById('tecnico_responsable_content');
    const $modal = document.querySelector('#modal-asignar-tecnico');
    const modal = new bootstrap.Modal($modal, {});

    $selectTecnico.addEventListener('change', e => {
      $tecnico.value = e.target.value;
    });

    const $botonModalEstablecer = document.querySelector('#boton-modal-establecer-tecnico');
    $botonModalEstablecer.onclick = () => {
      $codigo.value = data.solicitud.codigo;
      $estado.value = 'en proceso';

      if (!$tecnico.value) return;
      $form.submit();

      const { ordenes, ordenesOrdenadas } = getState();
      const indexOrden = ordenes.findIndex(orden => orden.solicitud.codigo === data.solicitud.codigo);
      ordenes[indexOrden].solicitud.estado = 'en proceso';

      const indexOrdenada = ordenesOrdenadas.findIndex(orden => orden.solicitud.codigo === data.solicitud.codigo);
      ordenesOrdenadas[indexOrdenada].solicitud.estado = 'en proceso';
      modal.hide();

      setState({ ordenes, ordenesOrdenadas });
    }

    modal.show();
  }
})();

    </script>

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