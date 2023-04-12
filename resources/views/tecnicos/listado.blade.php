@extends('layouts.master')

@section('content')
  <div class="position-relative overflow-hidden">
    <h3 class="mb-5 p-3">Técnicos</h3>

    <div class="overflow-x-auto px-3">
      <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">
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
              <th scope="col">
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
              <th scope="col">
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
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody id="cuerpo-tabla-tecnicos">

          </tbody>
      </table>
    </div>

    <script>

(async() => {
  const state = {
    tecnicos: [],
    tecnicosOrdenados: [],
  }

  function boot() {
    const raw = {{ Js::from($tecnicos) }};
    const tecnicos = raw.map((tecnico, index) => ({
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
  </div>
@stop
