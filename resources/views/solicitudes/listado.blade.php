@extends('layouts.master')

@section('content')
  <section class="my-5">
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
    <script>
      (async() => {
        const rawData = {{ Js::from($solicitudes) }};
        const sanitized = rawData.map(solicitud => ({
          solicitud: {
            codigo: solicitud.codigo_solicitud,
            articulo: solicitud.modelo,
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
                      elt('button', { className: 'dropdown-item', onclick: () => marcarEnProceso(data), disabled: data.solicitud.estado === 'en proceso' }, 'Marcar como "En proceso"')
                    ),
                    elt('li', {},
                      elt('button', { className: 'dropdown-item', onclick: () => marcarTerminado(data) }, 'Marcar como "Terminado"')
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

        async function marcarEnProceso(data) {
          const body = new URLSearchParams({
            codigo_solicitud: data.solicitud.codigo,
            estado_solicitud: 'en proceso',
          });

          const options = {
            method: 'POST',
            body,
          }

          const response = await fetch('/api/solicitud/estado', options);
          if (!response.ok) {
            alert('Ocurrió un error al cambiar el estado de la solicitud.');
            return;
          }

          location.reload();
        }

        async function marcarTerminado(data) {
          const body = new URLSearchParams({
            codigo_solicitud: data.solicitud.codigo,
            estado_solicitud: 'terminado',
          });

          const options = {
            method: 'POST',
            body,
          }

          const response = await fetch('/api/solicitud/estado', options);
          if (!response.ok) {
            alert('Ocurrió un error al cambiar el estado de la solicitud.');
            return;
          }

          location.reload();
        }

        window.addEventListener('DOMContentLoaded', boot);
      })();
    </script>
  </section>
@stop