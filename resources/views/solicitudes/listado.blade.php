@extends('layouts.app')

@section('content')
  <section>
    <div class="modal fade" id="modal-detalles-orden" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title h5">Detalles</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Precio de materiales: <span id="precio_materiales"></span>$</p>
          ´ <p>Precio de mano de obra: <span id="precio_obra"></span>$</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-estado-terminado" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Terminar Solicitud</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="#" class="row g-3 w-100" onsubmit="event.preventDefault();">
              <div class="col-12 mb-3">
                <label for="descripcion_solucion_content" class="form-label">Descripción de la solución</label>
                <textarea id="descripcion_solucion_content" class="form-control" rows="4"></textarea>
              </div>
              <div class="col-12 col-md-6 mb-3">
                <label for="garantia_content" class="form-label">Garantía</label>
                <input type="text" class="form-control" id="garantia_content" value="">
              </div>
              <div class="col-12 col-md-6 mb-3">
                <label for="precio_materiales_content" class="form-label">Precio de materiales</label>
                <input type="number" class="form-control" id="precio_materiales_content" value="" pattern="[0-9]+([\.,][0-9]+)?" step="0.01">
              </div>
              <div class="col-12 col-md-6 mb-3">
                <label for="precio_mano_obra_content" class="form-label">Precio de mano de obra</label>
                <input type="number" class="form-control" id="precio_mano_obra_content" value="" pattern="[0-9]+([\.,][0-9]+)?" step="0.01">
              </div>
              <div class="col-12 col-md-6 mb-3">
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

    @if(count($links) > 0)

    <div class="card card-body border-0 shadow mb-4">
      <h3 class="h5 mb-3">Filtrar órdenes</h3>

      <div class="d-flex flex-column flex-md-row align-items-start justify-content-start mb-4">
        
        <div class="dropdown mb-4">
          <button class="btn btn-primary dropdown-toggle" id="filtrar-estado-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Estado <svg class="icon icon-xs" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
            </svg>
          </button>
          <ul class="dropdown-menu">
            <li><button class="dropdown-item filtrar-estado" id="filtro-ingresado">Ingresado</button></li>
            <li><button class="dropdown-item filtrar-estado" id="filtro-presupuestado">Presupuestado</button></li>
            <li><button class="dropdown-item filtrar-estado" id="filtro-en reparacion">En Reparación</button></li>
            <li><button class="dropdown-item filtrar-estado" id="filtro-derivado">Derivado</button></li>
            <li><button class="dropdown-item filtrar-estado" id="filtro-entregado">Entregado</button></li>
            <li><button class="dropdown-item filtrar-estado" id="filtro-listo">Listo</button></li>
          </ul>
        </div>

        <div class="dropdown mb-4 ms-3">
          <button class="btn btn-primary dropdown-toggle" type="button" id="filtrar-fecha-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            Fecha <svg class="icon icon-xs" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
            </svg>
          </button>
          <div class="dropdown-menu">
            <div class="row p-3">
              <p class="col-12 mb-3">Rango de Fechas</p>
              <div class="col-12 mb-3">
                <label for="fecha-desde">Desde</label>
                <input type="date" id="fecha-desde" class="form-control">
              </div>
              <div class="col-12 mb-3">
                <label for="fecha-hasta">Hasta</label>
                <input type="date" id="fecha-hasta" class="form-control">
              </div>
              <div class="col-12">
                <button class="w-100 btn btn-primary" id="filtrar-fecha">Establecer</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-start align-items-start flex-column flex-md-row">
        <div id="estado-container">
          @if($filtros === true && $estado_filtro !== null)
            <button class="d-flex justify-content-center align-items-center py-2 px-3 btn btn-secondary me-2" id="estado_filtro">
              {{ $estado_filtro }}
              <i class="bi bi-x-lg ms-2 pe-none"></i>
            </button>
          @endif
        </div>
        <div id="fecha-container">
          @if($filtros === true && $fecha_filtro !== null)
            <button class="d-flex justify-content-center align-items-center py-2 px-3 btn btn-secondary me-2" id="fecha_filtro">
              {{ $fecha_filtro }}
              <i class="bi bi-x-lg ms-2 pe-none"></i>
            </button>
          @endif
        </div>
        <a class="btn btn-info" id="aplicar-filtros" href="/solicitudes">Aplicar Filtros</a>
      </div>
    </div>

    @endif

    @if(count($links) > 0)

      <div class="card card-body border-0 shadow table-wrapper table-responsive mb-5 pb-5" style="padding-bottom: 8rem">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="border-gray-200">#</th>
              <th class="border-gray-200">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Orden
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
                    <button class="btn-actions" id="articulo-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="articulo-desc">
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

          <div class="fw-normal mb-5 mb-md-0 small">Mostrando <b id="min-records">{{ count($links)}}</b> de <b>{{ $maxSolicitudes }}</b> órdenes</div>
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
        <input type="hidden" name="precio_material" id="precio_material" value="">
        <input type="hidden" name="precio_obra" id="precio_obra" value="">
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
  }

  let filtrosURL = new URLSearchParams();

  function boot() {
    const raw = {{ Js::from($links) }};
    const ordenes = raw.data.map((solicitud) => ({
      solicitud: {
        codigo: solicitud.codigo_solicitud,
        articulo: solicitud.articulo,
        estado: solicitud.estado_solicitud,
        fecha: solicitud.fecha_solicitud,
        precioMateriales: solicitud.precio_material,
        precioObra: solicitud.precio_obra,
      },
      cliente: {
        nombre: `${solicitud.nombre} ${solicitud.apellido}`,
        correo: solicitud.correo_electronico,
      }
    }));

    console.log(ordenes);

    const btnOrdenarCollection = Array.from(document.querySelectorAll('.btn-actions'));
    btnOrdenarCollection.forEach(btn => {
      
      btn.onclick = () => {
        const [columna, modo] = btn.id.split('-');
        ordenarPor(columna, modo);
      }
    });

    const $estadoFiltroContainer = document.getElementById('estado-container');
    const $fechaFiltroContainer = document.getElementById('fecha-container');

    const $aplicarFiltros = document.getElementById('aplicar-filtros');

    const btnFiltrarEstado = Array.from(document.querySelectorAll('.filtrar-estado'));
    btnFiltrarEstado.forEach(btn => {
      const [, id] = btn.id.split('-');
      btn.onclick = () => {
        while ($estadoFiltroContainer.firstChild) {
          $estadoFiltroContainer.removeChild($estadoFiltroContainer.firstChild);
        }

        $estadoFiltroContainer.appendChild(BotonFiltro(id, 'estado_filtro'));
        filtrosURL.set('estado', id);
        $aplicarFiltros.href = `/solicitudes?${filtrosURL.toString()}`;
      }
    });

    const $btnFiltrarFecha = document.getElementById('filtrar-fecha');
    $btnFiltrarFecha.onclick = () => {
      const $desde = document.getElementById('fecha-desde');
      const $hasta = document.getElementById('fecha-hasta');

      if (!$desde.value || !$hasta.value) {
        return;
      }

      const desde = $desde.valueAsDate;
      const hasta = $hasta.valueAsDate;

      if (desde.getTime() > hasta.getTime()) {
        alert('El rango de fechas es inválido');
        $desde.value = '';
        $hasta.value = '';
        return;
      }

      filtrosURL.set('fecha_desde', $desde.value);
      filtrosURL.set('fecha_hasta', $hasta.value);

      $aplicarFiltros.href = `/solicitudes?${filtrosURL.toString()}`;
      while($fechaFiltroContainer.firstChild) {
        $fechaFiltroContainer.removeChild($fechaFiltroContainer.firstChild);
      }

      $fechaFiltroContainer.appendChild(BotonFiltro(`${$desde.value} - ${$hasta.value}`, 'fecha_filtro'));

      const $dropdown = document.getElementById('filtrar-fecha-dropdown');
      const dropdown = new bootstrap.Dropdown($dropdown, {});
      dropdown.hide();
    }

    const pagination = document.querySelector('body > main > section > div.card.card-body.border-0.shadow.table-wrapper.table-responsive > div > nav');

    if (pagination !== null) {

      const $prev = pagination.children[0];
      const $next = pagination.children[1];

      $prev.classList.remove('font-medium');
      $prev.classList.add('font-small');

      $next.classList.remove('font-medium');
      $next.classList.add('font-small')

      $prev.textContent = '« Anterior';
      $next.textContent = 'Siguiente »';
    }

    $aplicarFiltros.href = `/solicitudes${location.search}`;
    filtrosURL = new URLSearchParams(location.search);

    const $estadoFiltro = document.getElementById('estado_filtro');
    if (Boolean($estadoFiltro)) {
      $estadoFiltro.onclick = estadoFiltroOnClick;
    }

    const $fechaFiltro = document.getElementById('fecha_filtro');
    if (Boolean($fechaFiltro)) {
      $fechaFiltro.onclick = fechaFiltroOnClick;
    }

    setState({
      ordenes,
      ordenesOrdenadas: ordenes,
    });
  }

  function estadoFiltroOnClick(e) {
    const $aplicarFiltros = document.getElementById('aplicar-filtros');
    e.target.remove();
    filtrosURL.delete('estado');
    $aplicarFiltros.href = `/solicitudes?${filtrosURL.toString()}`;
  }

  function fechaFiltroOnClick(e) {
    const $aplicarFiltros = document.getElementById('aplicar-filtros');
    e.target.remove();
    filtrosURL.delete('fecha_desde');
    filtrosURL.delete('fecha_hasta');
    $aplicarFiltros.href = `/solicitudes?${filtrosURL.toString()}`;
  }

  function BotonFiltro(estado, id) {
    return elt('button', { className: 'd-flex justify-content-center align-items-center py-2 px-3 btn btn-secondary me-2', id, onclick: estadoFiltroOnClick },
      elt('span', { className: 'pe-none' }, estado),
      elt('i', { className: 'bi bi-x-lg ms-2 pe-none' })
    );
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

      let $cambiarEstado = null;

      if (estado === 'ingresado') {
        $cambiarEstado = elt('button', {
          className: 'dropdown-item',
          onclick: () => cambiarEstado(codigo, 'presupuestado'),
        }, 'Marcar como "Presupuestado"');
      }

      else if (estado === 'presupuestado') {
        $cambiarEstado = elt('button', {
          className: 'dropdown-item',
          onclick: () => cambiarEstado(codigo, 'en reparación'),
        }, 'Marcar como "En Reparación"');
      }

      else if (estado === 'en reparacion') {
        $cambiarEstado = elt('button', {
          className: 'dropdown-item',
          onclick: () => cambiarEstado(codigo, 'derivado'),
        }, 'Marcar como "Derivado"');
      }

      else if (estado === 'derivado') {
        $cambiarEstado = elt('button', {
          className: 'dropdown-item',
          onclick: () => marcarTerminado(data),
        }, 'Marcar como "Entregado"');
      }

      else if (estado === 'entregado') {
        $cambiarEstado = elt('button', {
          className: 'dropdown-item',
          onclick: () => cambiarEstado(codigo, 'listo'),
        }, 'Marcar como "Listo"');
      }

      else {
        console.warn('Error fatal');
      }

      $acciones.appendChild(
        elt('div', { },
          $boton,
          elt('ul', { className: 'dropdown-menu' },
            elt('li', {},
              elt('a', { className: 'dropdown-item', href: `/editar/solicitud/${data.solicitud.codigo}` }, 'Editar'),
            ),
            $cambiarEstado
          )
        )
      );

      if (data.solicitud.estado === 'entregado' || data.solicitud.estado === 'listo') {
        $acciones
          .children[0]
          .children[1]
          .appendChild(elt('li', {},
            elt('button', { className: 'dropdown-item', onclick: () => mostrarDetalles(data.solicitud) }, 'Detalles')
          ));
      }
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

    const $minRecords = document.getElementById('min-records');
    $minRecords.textContent = ordenesOrdenadas.length.toString();
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

  function mostrarDetalles(orden) {
    const $modal = document.getElementById('modal-detalles-orden');
    const modal = new bootstrap.Modal($modal, {});

    const $precioMateriales = document.getElementById('precio_materiales');
    const $precioObra = document.getElementById('precio_obra');

    $precioMateriales.textContent = orden.precioMateriales;
    $precioObra.textContent = orden.precioObra;

    modal.show();
  }

  async function marcarTerminado(data) {
    const $form = document.getElementById('cambiar-estado-form');

    let $codigo = document.getElementById('codigo_solicitud');
    let $estado = document.getElementById('estado_solicitud');
    let $descripcion = document.getElementById('descripcion_solucion');
    let $garantia = document.getElementById('garantia');
    let $monto = document.getElementById('monto');
    let $precioMaterial = document.getElementById('precio_material');
    let $precioObra = document.getElementById('precio_obra');

    const $inputDescripcion = document.getElementById('descripcion_solucion_content');
    const $inputGarantia = document.getElementById('garantia_content');
    const $inputMonto = document.getElementById('monto_content');

    const $inputPrecioMaterial = document.getElementById('precio_materiales_content');
    const $inputPrecioObra = document.getElementById('precio_mano_obra_content');

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

    $inputPrecioMaterial.addEventListener('change', e => {
      $precioMaterial.value = e.target.value;
    });

    $inputPrecioMaterial.addEventListener('keyup', e => {
      $precioMaterial.value = e.target.value;
    });

    $inputPrecioObra.addEventListener('change', e => {
      $precioObra.value = e.target.value;
    });

    $inputPrecioObra.addEventListener('keyup', e => {
      $precioObra.value = e.target.value;
    });

    const $botonModalEstablecer = document.querySelector('#boton-modal-establecer');
    $botonModalEstablecer.onclick = () => {
      $inputDescripcion.value = '';
      $inputGarantia.value = '';
      $inputMonto.value = '';
      $inputPrecioMaterial.value = '';
      $inputPrecioObra.value = '';

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