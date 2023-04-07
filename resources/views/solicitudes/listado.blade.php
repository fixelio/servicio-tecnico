@extends('layouts.master')

@section('content')
  <section class="my-5">
    <div
      class="modal fade"
      id="modal-estado-terminado"
      tabindex="-1"
      aria-labelledby=""
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header"><h3 class="modal-title">Terminar Solicitud</h3></div>
          <div class="modal-body">
            <form action="#" class="row g-2 w-100" onsubmit="event.preventDefault();">
              <div class="col-12 mb-3">
                <label for="descripcion_solucion_content" class="form-label">Descripción de la solución</label>
                <textarea id="descripcion_solucion_content" class="form-control" rows="4"></textarea>
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
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="modal-asignar-tecnico"
      tabindex="-1"
      aria-labelledby=""
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header"><h3 class="modal-title">Asignar técnico</h3></div>
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
          </div>
        </div>
      </div>
    </div>    
    <div class="container d-flex justify-content-center align-items-center flex-column">
      <div class="w-75">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h3 class="mb-2 my-5">Listado de Solicitudes</h3>
        </div>
        <div>
          @if(count($solicitudes) > 0)
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Código</th>
                  <th scope="col">Cliente</th>
                  <th scope="col">Artículo</th>
                  <th scope="col">Estado</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody id="cuerpo-tabla-solicitudes">
                
              </tbody>
            </table>
          @else
            <div class="alert alert-info" role="alert">
              No hay solicitudes de mantenimiento en proceso o pendientes. <a class="link-opacity-100" href="/clientes">Ir a la lista de clientes.</a>
            </div>
          @endif
        </div>
      </div>
    </div>
    <form id="cambiar-estado-form" action="{{ route('estado-solicitud.put') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="codigo_solicitud" id="codigo_solicitud" value="">
        <input type="hidden" name="estado_solicitud" id="estado_solicitud" value="">
        <input type="hidden" name="descripcion_solucion" id="descripcion_solucion" value="">
        <input type="hidden" name="correo_tecnico" id="correo_tecnico" value="{{ count($tecnicos) > 0 ? $tecnicos[0]->correo_electronico : '' }}">
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

            const $acciones = elt('td', { className: 'd-flex justify-content-end align-items-end' });
            if (data.solicitud.estado !== 'terminado') {
              const $boton = elt('button', {
                className: 'btn btn-primary dropdown-toggle',
                type: 'button'
              }, 'Acciones');

              $boton.setAttribute('data-bs-toggle', 'dropdown');
              $boton.setAttribute('aria-expanded', 'false');

              $acciones.appendChild(
                elt('div', { className: 'dropdown dropdown-menu-end' },
                  $boton,
                  elt('ul', { className: 'dropdown-menu' },
                    elt('li', {},
                      elt('a', { className: 'dropdown-item', href: `/editar/solicitud/${data.solicitud.codigo}` }, 'Editar'),
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

            const element = elt('tr', { scope: 'row' },
              elt('th', {}, indice.toString()),
              elt('td', {}, data.solicitud.codigo),
              elt('td', {}, data.cliente.nombre),
              elt('td', {}, data.solicitud.articulo),
              elt('td', {}, 
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

          const $inputDesc = document.getElementById('descripcion_solucion_content');
          const $modal = document.querySelector('#modal-estado-terminado');
          const modal = new bootstrap.Modal($modal, {});

          $inputDesc.addEventListener('change', e => {
            $descripcion.value = e.target.value;
          });

          $inputDesc.addEventListener('keyup', e => {
            $descripcion.value = e.target.value;
          });

          const $botonModalEstablecer = document.querySelector('#boton-modal-establecer');
          $botonModalEstablecer.onclick = () => {
            $inputDesc.value = '';

            $codigo.value = data.solicitud.codigo;
            $estado.value = 'terminado';

            $form.submit();
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
            modal.hide();

            //checkCookie();
          }

          modal.show();
        }

        function handleDownloadCreated(item) {
          console.log(item);
          let intervalId;
          const handle = () => {
            let endTime = item.endTime;
            console.log(endTime);

            if (endTime !== undefined) {
              clearInterval(intervalId);
              location.reload();
            }
          }

          intervalId = setInterval(handle, 500);
        }

        window.addEventListener('DOMContentLoaded', () => {
          boot();

          if (typeof browser === 'undefined') {
            window.browser = chrome;
          }

          window.browser.downloads.onCreated.addEventListener(handleDownloadCreated);
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

  </section>
@stop