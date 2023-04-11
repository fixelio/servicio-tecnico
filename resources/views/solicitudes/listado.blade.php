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
              <th scope="col">Código</th>
              <th scope="col">Cliente</th>
              <th scope="col">Artículo</th>
              <th scope="col">Estado</th>
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
        const rawData = {{ Js::from($solicitudes) }};
        const sanitized = rawData.map(solicitud => ({
          solicitud: {
            codigo: solicitud.codigo_solicitud,
            articulo: solicitud.articulo,
            estado: solicitud.estado_solicitud,
          },
          cliente: {
            nombre: `${solicitud.nombre} ${solicitud.apellido}`,
            correo: solicitud.correo_electronico,
          }
        }));

        const ESTADO = {
          'en proceso': 'En Proceso',
          'terminado': 'Terminado',
          'pendiente': 'Pendiente',
        }
        
        function boot() {
          const $tabla = document.querySelector('#cuerpo-tabla-solicitudes');
          if (!$tabla) {
            return;
          }

          for(let i = 0; i < sanitized.length; i++) {
            const indice = i + 1;
            const data = sanitized[i];
            data['indice'] = indice;

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
                      elt('button', { className: 'dropdown-item', onclick: () => marcarEnProceso(data), disabled: data.solicitud.estado === 'en proceso' }, 'Marcar como "En proceso"')
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

            const element = elt('tr', { scope: 'row', id: `solicitud-${data.solicitud.codigo}` },
              elt('th', { className: "px-2 py-3" }, indice.toString()),
              elt('td', { className: "px-2 py-3" }, data.solicitud.codigo),
              elt('td', { className: "px-2 py-3" }, data.cliente.nombre),
              elt('td', { className: "px-2 py-3" }, data.solicitud.articulo),
              elt('td', { className: "px-2 py-3" }, 
                elt('span', { className: `badge badge-center text-bg-${data.solicitud.estado === 'pendiente' ? 'warning' : (data.solicitud.estado === 'en proceso' ? 'info' : 'success')}` }, ESTADO[data.solicitud.estado])
              ),
              $acciones
            );

            $tabla.appendChild(element);
          }
        }

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

            const $row = document.getElementById(`solicitud-${data.solicitud.codigo}`);
            const $estadoSolicitud = $row.children[4].children[0];
            $estadoSolicitud.textContent = ESTADO['terminado'];
            $estadoSolicitud.className = 'badge badge-center text-bg-success';

            const $actions = $row
              .children[5]
              .children[0]
              .children[1];

            $row.children[5].innerHTML = 'Sin acciones';
            $form.submit();

            $codigo.value = '';
            $estado.value = '';
            $descripcion.value = '';
            $garantia.value = '';
            $monto.value = '';

            modal.hide();
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


            const $row = document.getElementById(`solicitud-${data.solicitud.codigo}`);
            const $estadoSolicitud = $row.children[4].children[0];
            $estadoSolicitud.textContent = ESTADO['en proceso'];
            $estadoSolicitud.className = 'badge badge-center text-bg-info';

            const $actions = $row
              .children[5]
              .children[0]
              .children[1];

            const $btnEnProceso = $actions
              .children[1]
              .children[0];

            $btnEnProceso.disabled = true;
            modal.hide();
          }

          modal.show();
        }

        window.addEventListener('DOMContentLoaded', () => {
          boot();
        });
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