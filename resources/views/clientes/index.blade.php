@extends('layouts.master')

@section('content')
  <section class="p-3" style="margin-top: 70px;">
    <div class="mx-auto mx-100 wrapper py-5">
      <div class="position-relative overflow-hidden">
        <h3 class="mb-35 p-3">Clientes</h3>
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between p-3">
          <div class="w-100 py-3 mx-md-2 mb-2">
            <form action="#" class="d-flex align-items-center w-100">
              <label for="simpleSearch"></label>
              <div class="input-group flex-nowrap">
                <span class="bi bi-search input-group-text" id="addon-wrapping"></span>
                <input type="search" class="form-control" placeholder="Buscar" aria-label="cliente" aria-describedby="addon-wrapping">
              </div>
            </form>
          </div>
          <div class="w-100 d-flex flex-column flex-sm-row justify-content-end py-3">
            <button type="button" class="btn btn-primary mb-2 d-flex justify-content-center align-items-center text-nowrap w-100">
              <i class="bi bi-plus"></i>
              Registrar Cliente
            </button>
            <div class="dropdown w-100 mx-sm-2 mb-2 d-flex justify-content-center align-items-center">
              <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-funnel"></i>
                Filtrar
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Nombre</a></li>
                <li><a class="dropdown-item" href="#">Correo</a></li>
                <li><a class="dropdown-item" href="#">Teléfono</a></li>
                <li><a class="dropdown-item" href="#">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      value=""
                      id="checkProceso">
                    <label class="form-check-label" for="flexCheckChecked">
                      Estado: En Proceso
                    </label>
                  </div>
                </a></li>
                <li><a class="dropdown-item" href="#">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      value=""
                      id="checkTerminado">
                    <label class="form-check-label" for="flexCheckChecked">
                      Estado: Terminado
                    </label>
                  </div>
                </a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="table w-100">
            <thead>
              <th scope="col" class="px-2 py-3">#</th>
              <th scope="col" class="px-2 py-3">Nombre</th>
              <th scope="col" class="px-2 py-3">Correo</th>
              <th scope="col" class="px-2 py-3">Teléfono</th>
              <th scope="col" class="px-2 py-3">Pendientes</th>
              <th scope="col" class="px-2 py-3">Procesando</th>
              <th scope="col" class="px-2 py-3"></th>
            </thead>
            <tbody id="cuerpo-table-clientes">
              
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            <p>Mostrando <strong>1-10</strong> de 26 clientes</p>
          </div>
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  <!--
    <div class="container-md d-flex justify-content-center align-items-center mb-3 flex-column">
      <div class="wrapper">
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
  -->

    <script>
      (async() => {
        const state = {
          clientes: {},
        }

        window.addEventListener('DOMContentLoaded', () => {
          boot();
        });

        async function boot() {
          const rawClientes = {{ Js::from($clientes) }};
          const newState = getState();

          let pos = 1;

          for(const correo in rawClientes) {
            const [cliente, solicitudes] = rawClientes[correo];
            const countHandler = key => solicitudes.reduce((t, x) => {
              return t + (x.estado === key ? 1 : 0);
            }, 0);

            newState.clientes[correo] = {
              ...cliente,
              index: pos++,
              pendientes: countHandler('pendiente'),
              enProceso: countHandler('en proceso'),
            }
          }

          setState(newState);
        }

        function FilaCliente(cliente) {
          const $boton = elt('button', {
            type: 'button',
            className: 'focus-ring px-2 rounded fs-5',
          }, elt('i', {className: 'bi bi-three-dots'}, ''));

          $boton.setAttribute('data-bs-toggle', 'dropdown');
          $boton.setAttribute('aria-expanded', 'false');
          $boton.style.background = 'none';
          $boton.style.outline = 'none';
          $boton.style.border = 'none';

          return elt('tr', { className: 'text-nowrap' },
            elt('th', { scope: 'col', className: 'px-2 py-3' }, cliente.index.toString()),
            elt('td', { className: 'px-2 py-3' }, cliente.nombre),
            elt('td', { className: 'px-2 py-3' }, cliente.correo),
            elt('td', { className: 'px-2 py-3' }, cliente.telefono),
            elt('td', { className: 'px-2 py-3' },
              elt('span', { className: 'badge badge-bg-warning' }, cliente.pendientes.toString())
            ),
            elt('td', { className: 'px-2 py-3' },
              elt('span', { className: 'badge badge-bg-info' }, cliente.enProceso.toString())
            ),
            elt('td', { className: 'px-2 py-3' },
              elt('div', {},
                $boton,
                elt('ul', { className: 'dropdown-menu' },
                  elt('li', {},
                    elt('a', { href: `/registrar/solicitud/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Registrar Solicitud')
                  ),
                  elt('li', {},
                    elt('a', { href: `/solicitudes/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Ver Histórico')
                  ),
                  elt('li', {},
                    elt('a', { href: `/editar/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Editar Cliente')
                  )
                )
              )
            )
          );
        }

        function render() {
          const { clientes } = getState();
          const $cuerpoTabla = document.querySelector('#cuerpo-table-clientes');

          for(const correo in clientes) {
            const cliente = clientes[correo];

            $cuerpoTabla.appendChild(
              FilaCliente(cliente)
            );
          }
        }

        function getState() {
          return structuredClone(state);
        }

        function setState(newState) {
          for(const key in state) {
            if (key in newState === false) continue;

            state[key] = newState[key];
          }

          render();
        }
      })();
    </script>

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
                        elt('a', { href: `/registrar/solicitud/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Registrar Solicitud')
                      ),
                      elt('li', {},
                        elt('a', { href: `/solicitudes/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Ver Histórico')
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

      })();
    </script>
  </section>
@stop