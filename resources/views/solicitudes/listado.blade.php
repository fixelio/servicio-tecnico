@extends('layouts.master')

@section('content')
  <div class="position-relative overflow-hidden">
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

    <h3 class="mb-5 p-3">Órdenes</h3>

    <div class="overflow-x-auto px-3">
      @if(count($solicitudes) > 0)
        <table class="table w-100">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="text-nowrap">
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
              <th scope="col" class="text-nowrap">
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
              <th scope="col" class="text-nowrap">
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
              <th scope="col" class="text-nowrap">
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
              <th scope="col" class="text-nowrap">
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
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody id="cuerpo-tabla-solicitudes">
            
          </tbody>
        </table>
      @else
        <div class="alert alert-info" role="alert">
          No hay órdenes de mantenimiento en proceso o pendientes. <a class="link-opacity-100" href="/clientes">Ir a la lista de clientes.</a>
        </div>
      @endif
    </div>
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
    'en proceso': 'En Proceso',
    'terminado': 'Terminado',
    'pendiente': 'Pendiente',
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

    if (data.solicitud.estado !== 'terminado') {
      const $boton = elt('button', {
        className: 'focus-ring px-2 rounded fs-5',
        type: 'button'
      }, elt('i', { className: 'bi bi-three-dots' }, ''));

      $boton.setAttribute('data-bs-toggle', 'dropdown');
      $boton.setAttribute('aria-expanded', 'false');
      $boton.style.outline = 'none';
      $boton.style.border = 'none';
      $boton.style.background = 'none';

      $acciones.appendChild(
        elt('div', { },
          $boton,
          elt('ul', { className: 'dropdown-menu' },
            elt('li', {},
              elt('a', { className: 'dropdown-item', href: `/editar/solicitud/${data.solicitud.codigo}` }, 'Editar'),
            ),
            elt('li', {},
              elt('button', { className: 'dropdown-item', onclick: () => marcarEnProceso(data), disabled: data.solicitud.estado === 'en proceso' || data.solicitud.estado === 'terminado' }, 'Marcar como "En proceso"')
            ),
            elt('li', {},
              elt('button', { className: 'dropdown-item', onclick: () => marcarTerminado(data), disabled: data.solicitud.estado === 'terminado' }, 'Marcar como "Terminado"')
            )
          )
        )
      );
    }
    else {
      $acciones.appendChild(document.createTextNode('Sin acciones'));
    }

    const element = elt('tr', { scope: 'row', id: `solicitud-${data.solicitud.codigo}`, className: 'text-nowrap' },
      elt('th', { className: "px-2 py-3" }, data.index),
      elt('td', { className: "px-2 py-3" }, data.solicitud.codigo),
      elt('td', { className: "px-2 py-3" }, data.cliente.nombre),
      elt('td', { className: "px-2 py-3" }, data.solicitud.articulo),
      elt('td', { className: 'px-2 py-3' }, data.solicitud.fecha),
      elt('td', { className: "px-2 py-3" }, 
        elt('span', { className: `badge badge-center text-bg-${data.solicitud.estado === 'pendiente' ? 'warning' : (data.solicitud.estado === 'en proceso' ? 'info' : 'success')}` }, ESTADO[data.solicitud.estado])
      ),
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
      $estado.value = 'terminado';

      $form.submit();

      const { ordenes, ordenesOrdenadas } = getState();
      const indexOrden = ordenes.findIndex(orden => orden.solicitud.codigo === data.solicitud.codigo);
      ordenes[indexOrden].solicitud.estado = 'terminado';

      const indexOrdenada = ordenesOrdenadas.findIndex(orden => orden.solicitud.codigo === data.solicitud.codigo);
      ordenesOrdenadas[indexOrdenada].solicitud.estado = 'terminado';
      modal.hide();

      setState({ ordenes, ordenesOrdenadas });
    }

    modal.show();
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

  </div>
@stop