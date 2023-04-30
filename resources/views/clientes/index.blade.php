@extends('layouts.app')

@section('content')
  <section>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
      <div class="d-block">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
          <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
              <a href="/">
                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
          </ol>
        </nav>
        <h2 class="h4">Clientes</h2>
      </div>
    </div>
    <div class="table-settings mb-4">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="w-100 py-3 mx-md-2 mb-2">
          <form action="#" class="d-flex align-items-center w-100">
            <label for="simpleSearch"></label>
            <div class="input-group flex-nowrap">
              <span class="bi bi-search input-group-text" id="addon-wrapping"></span>
              <input type="text" class="form-control" placeholder="Buscar por nombre" aria-label="orden" aria-describedby="addon-wrapping" id="input-filtro">
            </div>
          </form>
        </div>
        <div class="w-100 d-flex flex-column flex-sm-row justify-content-end py-3">
          <a href="{{ route('registrar-cliente') }}" class="btn btn-secondary mb-2 d-flex justify-content-center align-items-center text-nowrap w-100">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Registrar Cliente
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
                    <input class="form-check-input" type="checkbox" value="" id="checkIngresados">
                    <label class="form-check-label" for="checkIngresados">
                        Estado: Ingresado
                    </label>
                  </div>
                </button>
              </li>
              <li>
                <button class="dropdown-item">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkProceso">
                    <label class="form-check-label" for="checkProceso">
                        Estado: En Reparación
                    </label>
                  </div>
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive mb-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">#</th>
                    <th class="border-gray-200">
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
                    <th class="border-gray-200">
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
                    <th class="border-gray-200">
                      <div class="w-100 d-flex justify-content-between align-items-center">
                        Teléfono
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
                    <th class="border-gray-200">
                      <div class="w-100 d-flex justify-content-between align-items-center">
                        Ingresados
                        <div>
                          <button class="btn-actions" id="ingresado-asc">
                            <i class="bi bi-caret-up-fill"></i>
                          </button>
                          <button class="btn-actions" id="ingresado-desc">
                            <i class="bi bi-caret-down-fill"></i>
                          </button>
                        </div>
                      </div>
                    </th>
                    <th class="border-gray-200">
                      <div class="w-100 d-flex justify-content-between align-items-center">
                        Reparación
                        <div>
                          <button class="btn-actions" id="reparacion-asc">
                            <i class="bi bi-caret-up-fill"></i>
                          </button>
                          <button class="btn-actions" id="reparacion-desc">
                            <i class="bi bi-caret-down-fill"></i>
                          </button>
                        </div>
                      </div>
                    </th>
                    <th class="border-gray-200">Acciones</th>
                </tr>
            </thead>
            <tbody id="cuerpo-tabla-clientes"></tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-md-row align-items-center justify-content-between">
            @if ($links->links()->paginator->hasPages())

            {{ $links->links() }}

            @endif

            <div class="fw-normal mb-5 mb-md-0 small">Mostrando <b id="min-records">{{ count($clientes)}}</b> de <b>{{ $maxClientes }}</b> clientes</div>
        </div>
      </div>
    <script>
      (async() => {
        const FILTRAR_POR = {
          CORREO: 'correo',
          NOMBRE: 'nombre',
          TELEFONO: 'telefono',
          ESTADO_INGRESADO: 'ingresado',
          ESTADO_EN_PROCESO: 'reparacion',
        }

        const state = {
          clientes: [],
          clientesFiltrados: [],
          filtro: FILTRAR_POR.NOMBRE,
        }

        $nombreRef = document.querySelector('#filtrar-nombre');
        $correoRef = document.querySelector('#filtrar-correo');
        $telefonoRef = document.querySelector('#filtrar-telefono');

        $ingresadoRef = document.querySelector('#checkIngresados');
        $reparacionRef = document.querySelector('#checkProceso');

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
              ingresado: countHandler('ingresado') || 0,
              reparacion: countHandler('en reparacion') || 0,
            });
          }

          const btnOrdenarCollection = Array.from(document.querySelectorAll('.btn-actions'));
          btnOrdenarCollection.forEach(btn => {
            
            btn.onclick = () => {
              const [columna, modo] = btn.id.split('-');
              ordenarPor(columna, modo);
            }
          });

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

          $nombreRef.onclick = () => setFiltro(FILTRAR_POR.NOMBRE);
          $correoRef.onclick = () => setFiltro(FILTRAR_POR.CORREO);

          $ingresadoRef.onclick = () => {
            if (!$ingresadoRef.checked) {
              setState({ clientesFiltrados: clientes });
              return;
            }

            $reparacionRef.checked = false;
            const newFiltro = FILTRAR_POR.ESTADO_INGRESADO
            setFiltro(newFiltro);
            filtrar(newFiltro);
          }

          $reparacionRef.onclick = () => {
            if (!$reparacionRef.checked) {
              setState({ clientesFiltrados: clientes });
              return;
            }

            $ingresadoRef.checked = false;
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
            if (columna === 'ingresado' || columna === 'reparacion') {
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

          if (filtro === FILTRAR_POR.ESTADO_INGRESADO || filtro === FILTRAR_POR.ESTADO_EN_PROCESO) {
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
          const VALUES = {
            'correo': 'correo',
            'nombre': 'nombre',
            'telefono': 'telefono',
          }
          const $inputFiltro = document.querySelector('#input-filtro');

          if (filtro === 'ingresado' || filtro === 'reparacion') {
            $inputFiltro.disabled = true;
            $inputFiltro.placeholder = '';
          }
          else {
            $inputFiltro.disabled = false;
            $inputFiltro.placeholder = `Buscar por ${VALUES[filtro]}`;

            $pendientesRef.checked = false;
            $reparacionRef.checked = false;

            const { clientes } = getState();

            setState({ clientesFiltrados: clientes });
          }

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
              elt('span', { className: 'badge bg-warning px-1' }, cliente.ingresado.toString())
            ),
            elt('td', { className: 'px-2 py-3' },
              elt('span', { className: 'badge bg-info px-1' }, cliente.reparacion.toString())
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
          const $cuerpoTabla = document.querySelector('#cuerpo-tabla-clientes');

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

    @if(session()->get('error') !== null && session()->get('message') !== null)

    <script>
      const notyf = new Notyf({
        position: {
            x: 'right',
            y: 'top',
        },
        types: [
            {
                type: 'danger',
                background: 'red',
                icon: {
                    className: 'fas fa-info-circle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }
        ]
    });
    notyf.open({
        type: 'danger',
        message: 'El rango de fechas es inválido'
    });
    </script>

    @endif

  </section>

  
@stop