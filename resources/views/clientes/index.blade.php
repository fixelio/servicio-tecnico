@extends('layouts.master')

@section('content')
  <section class="mx-2 mx-md-4 my-5">
    <div class="container-md d-flex justify-content-center align-items-center mb-3 flex-column">
      <div class="w-75">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h3 class="mb-2 my-5">Clientes</h3>
          <a class="btn btn-primary" href="{{ route('registrar-cliente') }}">Registrar Cliente</a>
        </div>
        <div class="d-flex justify-content-start align-items-start flex-column mb-5">
          <div class="alert alert-info mb-4" role="alert">
            Haz click en el nombre de cada cliente para ver su histórico. Para registrar una solicitud de mantenimiento, haz click en "Acciones" y luego selecciona "Registrar Solicitud"
          </div>
          <div>
            <div class="form-check form-switch form-check-reverse">
              <label class="form-check-label" for="hideClients">Ocultar clientes que no tengan el estado 'pendiente' ni 'en proceso'</label>
              <input class="form-check-input" type="checkbox" id="hideClients" />
            </div>
          </div>
        </div>
        <div class="w-100">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Pendientes</th>
                <th scope="col">En Proceso</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="cuerpo-table-clientes">
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script>
      (async() => {
        const rawClientes = {{ Js::from($clientes) }};
        let hideClients = false;

        function removeNodes($element) {
          while($element.firstChild) {
            $element.firstChild.remove();
          }
        }
        
        function fill() {
          const sanitized = rawClientes.map(cliente => ({
            nombre: `${cliente.nombre} ${cliente.apellido}`,
            correo: cliente.correo_electronico,
            estadoSolicitud: cliente.estado_solicitud,
          }));

          const indexed = sanitized.reduce((acc, cliente) => ({
            ...acc,
            [cliente.correo]: {
              nombre: cliente.nombre,
              correo: cliente.correo,
              pendientes: (acc[cliente.correo]?.pendientes || 0) + (cliente.estadoSolicitud === 'pendiente' ? 1 : 0),
              enProceso: (acc[cliente.correo]?.enProceso || 0) + (cliente.estadoSolicitud === 'en proceso' ? 1 : 0),
            }
          }), {});

          const $tabla = document.querySelector('#cuerpo-table-clientes');
          removeNodes($tabla);
          let index = 1;

          for (const correo in indexed) {
            const cliente = indexed[correo];

            if (hideClients && cliente.pendientes === 0 && cliente.enProceso === 0) {
              continue;
            }

            const $boton = elt('button', {
              className: 'btn btn-primary dropdown-toggle',
              type: 'button'
            }, 'Acciones');

            $boton.setAttribute('data-bs-toggle', 'dropdown');
            $boton.setAttribute('aria-expanded', 'false');

            $tabla.appendChild(
              elt('tr', { scope: 'row' },
                elt('th', {}, `${index++}`),
                elt('td', {}, 
                  elt('a', { class: 'link-opacity-100', href: `/solicitudes/cliente/${cliente.correo}` }, cliente.nombre)
                ),
                elt('td', { },
                  elt('span', { className: 'badge badge-center text-bg-warning' }, cliente.pendientes.toString())
                ),
                elt('td', { },
                  elt('span', { className: 'badge badge-center text-bg-info' }, cliente.enProceso.toString())
                ),
                elt('td', { className: 'd-flex justify-content-end align-items-end' },
                  elt('div', { className: 'dropdown dropdown-menu-end' },
                    $boton,
                    elt('ul', { className: 'dropdown-menu' },
                      elt('li', {},
                        elt('a', { href: `/solicitudes/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Ver Histórico')
                      ),
                      elt('li', {},
                        elt('a', { href: `/registrar/solicitud/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Registrar Solicitud')
                      ),
                      elt('li', {},
                        elt('a', { href: `/editar/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Editar Cliente')
                      )
                    )
                  )
                )
              )
            );
          }
        }

        document.querySelector('#hideClients').addEventListener('change', (e) => {
          hideClients = e.target.checked;
          fill();
        });

        window.addEventListener('DOMContentLoaded', () => {
          fill();
        })
      })();
    </script>
  </section>
@stop