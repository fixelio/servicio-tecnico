@extends('layouts.master')

@section('content')
  <section class="mx-2 mx-md-4 my-5">
    <div class="container-md d-flex justify-content-center align-items-center mb-3 flex-column">
      <div class="w-75">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h3 class="mb-2 my-5">Clientes</h3>
          <a class="btn btn-primary" href="{{ route('registrar-cliente') }}">Registrar</a>
        </div>
        <div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Pendiente</th>
                <th scope="col">Terminado</th>
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
            terminados: (acc[cliente.correo]?.terminados || 0) + (cliente.estadoSolicitud === 'terminado' ? 1 : 0),
          }
        }), {});

        const $tabla = document.querySelector('#cuerpo-table-clientes');
        let index = 1;

        for (const correo in indexed) {
          const cliente = indexed[correo];
          const $boton = elt('button', {
            className: 'btn btn-primary dropdown-toggle',
            type: 'button'
          }, 'Acciones');

          $boton.setAttribute('data-bs-toggle', 'dropdown');
          $boton.setAttribute('aria-expanded', 'false');

          $tabla.appendChild(
            elt('tr', { scope: 'row' },
              elt('th', {}, `${index++}`),
              elt('td', {}, cliente.nombre),
              elt('td', {}, cliente.pendientes.toString()),
              elt('td', {}, cliente.terminados.toString()),
              elt('td', { className: 'd-flex justify-content-end align-items-end' },
                elt('div', { className: 'dropdown dropdown-menu-end' },
                  $boton,
                  elt('ul', { className: 'dropdown-menu' },
                    elt('li', {},
                      elt('a', { href: `/registrar/solicitud/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Registrar Solicitud')
                    )
                  )
                )
              )
            )
          );
        }
      })();
    </script>
  </section>
@stop