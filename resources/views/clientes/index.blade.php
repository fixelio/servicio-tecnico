@extends('layouts.master')

@section('content')
  <div class="position-relative overflow-hidden">
    <h3 class="mb-5 p-3">Clientes</h3>
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between px-3">
      <div class="w-100 py-3 mx-md-2 mb-2">
        <form action="#" class="d-flex align-items-center w-100">
          <label for="simpleSearch"></label>
          <div class="input-group flex-nowrap">
            <span class="bi bi-search input-group-text" id="addon-wrapping"></span>
            <input type="search" class="form-control" placeholder="Buscar por nombre" aria-label="cliente" aria-describedby="addon-wrapping" id="input-filtro">
          </div>
        </form>
      </div>
      <div class="w-100 d-flex flex-column flex-sm-row justify-content-end py-3">
        <a href="{{ route('registrar-cliente') }}" class="btn btn-primary mb-2 d-flex justify-content-center align-items-center text-nowrap w-100">
          <i class="bi bi-plus"></i>
          Registrar Cliente
        </a>
        <div class="dropdown w-100 mx-sm-2 mb-2 d-flex justify-content-center align-items-center">
          <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-funnel"></i>
            Filtrar
          </button>
          <ul class="dropdown-menu">
            <li><button class="dropdown-item" id="filtrar-nombre">Nombre</button></li>
            <li><button class="dropdown-item" id="filtrar-correo">Correo</button></li>
            <li><a class="dropdown-item" href="#">
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="checkPendientes">
                <label class="form-check-label" for="checkPendientes">
                  Estado: Pendientes
                </label>
              </div>
            </a></li>
            <li><a class="dropdown-item" href="#">
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="checkProceso">
                <label class="form-check-label" for="checkProceso">
                  Estado: En Proceso
                </label>
              </div>
            </a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="overflow-x-auto px-3">
      <table class="table w-100">
        <thead>
          <th scope="col" class="px-2 py-3">#</th>
          <th scope="col" class="px-2 py-3 text-nowrap">
            <div class="w-100 d-flex justify-content-between align-items-center">
              Nombre
              <div>
                <button class="btn-actions" id="nombre-asc">
                  <i class="bi bi-caret-up-fill"></i>
                </button>
                <button class="btn-actions" id="nombre-desc">
                  <i class="bi bi-caret-down-fill"></i>
                </button>
              </div>
            </div>
          </th>
          <th scope="col" class="px-2 py-3 text-nowrap">
            <div class="w-100 d-flex justify-content-between align-items-center">
              Correo
              <div>
                <button class="btn-actions" id="correo-asc">
                  <i class="bi bi-caret-up-fill"></i>
                </button>
                <button class="btn-actions" id="correo-desc">
                  <i class="bi bi-caret-down-fill"></i>
                </button>
              </div>
            </div>
          </th>
          <th scope="col" class="px-2 py-3 text-nowrap">
            <div class="w-100 d-flex justify-content-between align-items-center">
              Telefono
              <div>
                <button class="btn-actions" id="telefono-asc">
                  <i class="bi bi-caret-up-fill"></i>
                </button>
                <button class="btn-actions" id="telefono-desc">
                  <i class="bi bi-caret-down-fill"></i>
                </button>
              </div>
            </div>
          </th>
          <th scope="col" class="px-2 py-3 text-nowrap">
            <div class="w-100 d-flex justify-content-between align-items-center">
              Pendientes
              <div>
                <button class="btn-actions" id="pendientes-asc">
                  <i class="bi bi-caret-up-fill"></i>
                </button>
                <button class="btn-actions" id="pendientes-desc">
                  <i class="bi bi-caret-down-fill"></i>
                </button>
              </div>
            </div>
          </th>
          <th scope="col" class="px-2 py-3 text-nowrap">
            <div class="w-100 d-flex justify-content-between align-items-center">
              Procesando
              <div>
                <button class="btn-actions" id="enProceso-asc">
                  <i class="bi bi-caret-up-fill"></i>
                </button>
                <button class="btn-actions" id="enProceso-desc">
                  <i class="bi bi-caret-down-fill"></i>
                </button>
              </div>
            </div>
          </th>
          <th scope="col" class="px-2 py-3 text-nowrap">Acciones</th>
        </thead>
        <tbody id="cuerpo-table-clientes">
          
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3 px-3">
      <div>
        <p>Mostrando <strong><span id="min-records">{{ count($clientes) }}</span></strong> de <strong>{{ $maxClientes }}</strong> clientes</p>
      </div>
      <!--<nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
        </ul>
      </nav>-->
    </div>
    <script>
      (async() => {
        const FILTRAR_POR = {
          CORREO: 'correo',
          NOMBRE: 'nombre',
          TELEFONO: 'telefono',
          ESTADO_PENDIENTES: 'pendientes',
          ESTADO_EN_PROCESO: 'enProceso',
        }

        const state = {
          clientes: [],
          clientesFiltrados: [],
          filtro: FILTRAR_POR.NOMBRE,
        }

        $nombreRef = document.querySelector('#filtrar-nombre');
        $correoRef = document.querySelector('#filtrar-correo');
        $telefonoRef = document.querySelector('#filtrar-telefono');

        $pendientesRef = document.querySelector('#checkPendientes');
        $enProcesoRef = document.querySelector('#checkProceso');

        window.addEventListener('DOMContentLoaded', () => {
          boot();
        });

        function boot() {
          const rawClientes = {{ Js::from($clientes) }};
          const { clientes, clientesFiltrados, filtro } = getState();

          let pos = 1;
          for(const correo in rawClientes) {
            const [cliente, solicitudes] = rawClientes[correo];
            const countHandler = key => solicitudes?.reduce((t, x) => {
              return t + (x.estado === key ? 1 : 0);
            }, 0);

            clientes.push({
              ...cliente,
              index: pos++,
              pendientes: countHandler('pendiente') || 0,
              enProceso: countHandler('en proceso') || 0,
            });
          }

          const btnOrdenarCollection = Array.from(document.querySelectorAll('.btn-actions'));
          btnOrdenarCollection.forEach(btn => {
            
            btn.onclick = () => {
              const [columna, modo] = btn.id.split('-');
              ordenarPor(columna, modo);
            }
          });

          $nombreRef.onclick = () => setFiltro(FILTRAR_POR.NOMBRE);
          $correoRef.onclick = () => setFiltro(FILTRAR_POR.CORREO);

          $pendientesRef.onclick = () => {
            if (!$pendientesRef.checked) {
              setState({ clientesFiltrados: clientes });
              return;
            }

            $enProcesoRef.checked = false;
            const newFiltro = FILTRAR_POR.ESTADO_PENDIENTES
            setFiltro(newFiltro);
            filtrar(newFiltro);
          }

          $enProcesoRef.onclick = () => {
            if (!$enProcesoRef.checked) {
              setState({ clientesFiltrados: clientes });
              return;
            }

            $pendientesRef.checked = false;
            const newFiltro = FILTRAR_POR.ESTADO_EN_PROCESO
            setFiltro(newFiltro);
            filtrar(newFiltro);
          }

          const $inputFiltro = document.querySelector('#input-filtro');

          $inputFiltro.onkeyup = (e) => {
            if ((e.key.length !== 1 || !e.key.match(/[A-z|a-z|@]/i)) && e.key !== 'Backspace') {
              return;
            }

            filtrar(e.target.value);
          }

          setState({ clientes, clientesFiltrados: clientes });
        }

        function ordenarPor(columna, modo) {
          const { clientesFiltrados } = getState();

          const clientes = clientesFiltrados.sort((a, b) => {
            if (columna === 'pendientes' || columna === 'enProceso') {
              const aCol = a[columna];
              const bCol = b[columna];

              if (modo === 'asc') {
                return aCol < bCol ? -1 : 1;
              }
              else {
                return aCol > bCol ? -1 : 1;
              }
            }

            const aCol = a[columna];
            const bCol = b[columna];

            if (modo === 'asc') {
              return aCol.localeCompare(bCol);
            }
            else {
              return bCol.localeCompare(aCol);
            }
          });

          setState({ clientesFiltrados: clientes });
        }

        function filtrar(value) {
          const { clientes, filtro } = getState();

          if (filtro === FILTRAR_POR.ESTADO_PENDIENTES || filtro === FILTRAR_POR.ESTADO_EN_PROCESO) {
            filtrarPorEstado(value);
            return;
          }

          if (!value) {
            setState({ clientesFiltrados: clientes });
            return;
          }

          const regex = new RegExp(value, 'i');
          const filtered = clientes.filter(cliente => cliente[filtro].match(regex));

          const $minRecords = document.querySelector('#min-records');
          $minRecords.textContent = filtered.length.toString();

          setState({ clientesFiltrados: filtered });
        }

        function filtrarPorEstado (estado) {
          const { clientes } = getState();
          const filtered = clientes.filter(cliente => cliente[estado] > 0);

          setState({ clientesFiltrados: filtered });
        }

        function setFiltro(filtro) {
          const $inputFiltro = document.querySelector('#input-filtro');
          $inputFiltro.placeholder = `Buscar por ${filtro}`;

          setState({ filtro });
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
              elt('span', { className: 'badge text-bg-warning' }, cliente.pendientes.toString())
            ),
            elt('td', { className: 'px-2 py-3' },
              elt('span', { className: 'badge text-bg-info' }, cliente.enProceso.toString())
            ),
            elt('td', { className: 'px-2 py-3' },
              elt('div', {},
                $boton,
                elt('ul', { className: 'dropdown-menu' },
                  elt('li', {},
                    elt('a', { href: `/registrar/solicitud/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Registrar Orden')
                  ),
                  elt('li', {},
                    elt('a', { href: `/editar/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Editar Cliente')
                  ),
                  elt('li', {},
                    elt('a', { href: `/solicitudes/cliente/${cliente.correo}`, className: 'dropdown-item' }, 'Ver Histórico')
                  )
                )
              )
            )
          );
        }

        function render() {
          const { clientesFiltrados } = getState();
          const $cuerpoTabla = document.querySelector('#cuerpo-table-clientes');

          while($cuerpoTabla.firstChild) {
            $cuerpoTabla.removeChild($cuerpoTabla.firstChild);
          }

          for(const cliente of clientesFiltrados) {
            $cuerpoTabla.appendChild(FilaCliente(cliente));
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