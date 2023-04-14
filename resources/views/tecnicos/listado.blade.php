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
            <li class="breadcrumb-item active" aria-current="page">Técnicos</li>
          </ol>
        </nav>
        <h2 class="h4">Lista de Técnicos</h2>
      </div>
    </div>

    <div class="card card-body border-0 shadow table-wrapper table-responsive">
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
            <th class="border-gray-200">Acciones</th>
          </tr>
        </thead>
        <tbody id="cuerpo-tabla-tecnicos"></tbody>
      </table>
      <div class="card-footer px-3 border-0 d-flex flex-column flex-md-row align-items-center justify-content-between">
        @if ($links->links()->paginator->hasPages())

        {{ $links->links() }}

        @endif

        <div class="fw-normal mb-5 mb-md-0 small">Mostrando <b id="min-records">{{ count($tecnicos)}}</b> de <b>{{ $maxTecnicos }}</b> técnicos
      </div>
    </div>
  </section>
    <script>

(async() => {
  const state = {
    tecnicos: [],
    tecnicosOrdenados: [],
  }

  function boot() {
    const raw = {{ Js::from($links) }};
    const tecnicos = raw.data.map((tecnico, index) => ({
      nombre: `${tecnico.nombre} ${tecnico.apellido}`,
      correo: tecnico.correo_electronico,
      telefono: tecnico.telefono,
      index: `${index + 1}`
    }));

    const btnOrdenarCollection = Array.from(document.querySelectorAll('.btn-actions'));
    btnOrdenarCollection.forEach(btn => {
      
      btn.onclick = () => {
        const [columna, modo] = btn.id.split('-');
        ordenarPor(columna, modo);
      }
    });

    setState({ tecnicos, tecnicosOrdenados: tecnicos });
  }

  function FilaTecnico(tecnico) {
    const $acciones = elt('td', { className: 'ml-3' });

    const $boton = elt('button', {
      className: 'focus-ring px-2 rounded fs-5',
      type: 'button',
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
            elt('a', { className: 'dropdown-item', href: `/editar/tecnico/${tecnico.correo}` }, 'Editar'),
          ),
          elt('li', {},
            elt('a', { className: 'dropdown-item', href: `/solicitudes/tecnico/${tecnico.correo}` }, 'Órdenes Asignadas'),
          )
        )
      )
    );

    const element = elt('tr', { scope: 'row', id: `tecnico-${tecnico.correo}`, className: 'text-nowrap' },
      elt('th', { className: "px-2 py-3 text-nowrap" }, tecnico.index),
      elt('td', { className: "px-2 py-3 text-nowrap" }, tecnico.nombre),
      elt('td', { className: "px-2 py-3 text-nowrap" }, tecnico.correo),
      elt('td', { className: "px-2 py-3 text-nowrap" }, tecnico.telefono),
      $acciones
    );

    return element;
  }

  function ordenarPor(columna, modo) {
    const { tecnicos } = getState();

    const ordenados = tecnicos.sort((a, b) => {
      const aCol = a[columna];
      const bCol = b[columna];

      if (modo === 'asc') {
        return aCol.localeCompare(bCol);
      }
      else {
        return bCol.localeCompare(aCol);
      }
    });

    setState({ tecnicosOrdenados: ordenados });
  }

  function render() {
    const $tabla = document.getElementById('cuerpo-tabla-tecnicos');
    if (!$tabla) return;

    while($tabla.firstChild) {
      $tabla.removeChild($tabla.firstChild);
    }

    const { tecnicosOrdenados } = getState();
    tecnicosOrdenados.forEach(tecnico => {
      $tabla.appendChild(FilaTecnico(tecnico));
    });
  }

  function getState() {
    return structuredClone(state);
  }

  function setState(newState) {
    for(const key in newState) {
      if(key in state === false) continue;

      state[key] = newState[key];
    }

    render();
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
@stop
