@extends('layouts.master');

@section('content')
  <div class="position-relative overflow-hidden">
    <div class="modal fade" tabindex="-1" id="modal-mostrar-detalles">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Detalles de la orden #<span id="codigo"></span></h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <ul class="nav nav-underline d-flex justify-content-between" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="equipo-tab" data-bs-toggle="tab" data-bs-target="#equipo-tab-pane" type="button" role="tab" aria-controls="equipo-tab-pane" aria-selected="false"><i class="bi bi-pc-display"></i> Equipo</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tecnico-tab" data-bs-toggle="tab" data-bs-target="#tecnico-tab-pane" type="button" role="tab" aria-controls="tecnico-tab-pane" aria-selected="false"><i class="bi bi-tools"></i> Técnico</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="reparacion-tab" data-bs-toggle="tab" data-bs-target="#reparacion-tab-pane" type="button" role="tab" aria-controls="reparacion-tab-pane" aria-selected="false"><i class="bi bi-motherboard"></i> Reparación</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="equipo-tab-pane" role="tabpanel" aria-labelledby="equipo-tab" tabindex="0">
                <div class="px-1 py-4">
                  <p>Artículo: <strong id="articulo"></strong></p>
                  <p>Número de serie: <strong id="serie"></strong></p>
                  <p>Modelo: <strong id="modelo"></strong></p>
                  <p>Marca: <strong id="marca"></strong></p>
                  <hr>
                  <p>Diagnóstico: <span id="diagnostico"></span></p>
                  <p>Observaciones:</p>
                  <ol class="list-group list-group-numbered" id="observaciones">
                  </ol>
                </div>
              </div>
              <div class="tab-pane fade" id="tecnico-tab-pane" role="tabpanel" aria-labelledby="tecnico-tab" tabindex="0">
                <div class="px-1 py-4">
                  <p>Técnico responsable: <strong id="tecnico"></strong></p>
                </div>
              </div>
              <div class="tab-pane fade" id="reparacion-tab-pane" role="tabpanel" aria-labelledby="reparacion-tab" tabindex="0">
                <div class="px-1 py-4">
                  <p>Solución: <span id="solucion"></span></p>
                  <p>Garantía: <span id="garantia"></span></p>
                  <p>Monto a pagar: <span id="monto"></span><i class="bi bi-currency-dollar"></i></p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <h3 class="mb-5 p-3">Histórico de {{ $cliente->nombre }} {{ $cliente->apellido }}</h3>

    @if(count($solicitudes) > 0)
      <div class="overflow-x-auto px-3">
        <table class="table w-100">
          <thead>
            <tr class="text-nowrap">
              <th scope="col">#</th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Código
                  <div>
                    <button class="btn-actions" id="codigo-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="codigo-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Artículo
                  <div>
                    <button class="btn-actions" id="articulo-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="articulo-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Modelo
                  <div>
                    <button class="btn-actions" id="modelo-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="modelo-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Fecha
                  <div>
                    <button class="btn-actions" id="fecha-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="fecha-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  Estado
                  <div>
                    <button class="btn-actions" id="estado-asc">
                      <i class="bi bi-caret-up-fill"></i>
                    </button>
                    <button class="btn-actions" id="estado-desc">
                      <i class="bi bi-caret-down-fill"></i>
                    </button>
                  </div>
                </div>
              </th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody id="cuerpo-tabla">
            @for($i = 0; $i < count($solicitudes); $i++)
              <tr scope="row" class="text-nowrap">
                <th class="px-2 py-3 text-nowrap">{{$i + 1}}</th>
                <td class="px-2 py-3 text-nowrap">{{ $solicitudes[$i]->codigo_solicitud }}</td>
                <td class="px-2 py-3 text-nowrap">{{ $solicitudes[$i]->articulo }}</td>
                <td class="px-2 py-3 text-nowrap">{{ $solicitudes[$i]->modelo }}</td>
                <td class="px-2 py-3 text-nowrap">{{ $solicitudes[$i]->fecha_solicitud }}</td>
                <td class="px-2 py-3 text-nowrap">
                  @if($solicitudes[$i]->estado_solicitud === 'pendiente')
                    <span class="badge text-bg-warning">Pendiente</span>
                  @elseif($solicitudes[$i]->estado_solicitud === 'en proceso')
                    <span class="badge text-bg-info">En Proceso</span>
                  @else
                    <span class="badge text-bg-success">Terminado</span>
                  @endif
                </td>
                <td class="px-2 py-3 text-nowrap">
                  <div>
                    <button type="button" class="focus-ring px-2 rounded fs-5" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none; outline: none;">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="#" class="dropdown-item detalles-solicitud">
                          Más detalles
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
    @else
      <div class="alert alert-warning" role="alert">Este cliente no tiene ninguna orden de mantenimiento registrada. <a href="{{ route('clientes') }}" class="link-opacity-100">Volver a la lista de clientes.</a> o ir a la página de <a href="{{ route('listado-solicitudes') }}" class="link-opacity-100">órdenes.</a></div>
    @endif
    <script>
      (async() => {
        const state = {
          orden: null,
          ordenes: [],
          ordenesOrdenadas: [],
        }

        function boot() {
          const data = {{ Js::from($solicitudes) }};
          const indexadas = data.reduce((acc, orden) => ({
            ...acc,
            [orden.codigo_solicitud]: {
              articulo: orden.articulo,
              codigo: orden.codigo_solicitud,
              diagnostico: orden.descripcion_problema,
              solucion: orden.descripcion_solucion,
              estado: orden.estado_solicitud,
              fechaCompra: orden.fecha_compra,
              fechaInicio: orden.fecha_inicio,
              fecha: orden.fecha_solicitud,
              fechaFin: orden.fecha_fin,
              garantia: orden.garantia,
              marca: orden.marca,
              modelo: orden.modelo,
              monto: orden.monto,
              numeroSerie: orden.num_serie,
              observaciones: orden.observaciones,
              tecnico: {
                nombre: orden.nombre_tecnico || '',
                apellido: orden.apellido_tecnico || '',
              }
            },
          }), {});

          const btnOrdenarCollection = Array.from(document.querySelectorAll('.btn-actions'));
          btnOrdenarCollection.forEach(btn => {
            
            btn.onclick = () => {
              const [columna, modo] = btn.id.split('-');
              ordenarPor(columna, modo);
            }
          });

          const detalles = document.querySelectorAll('.detalles-solicitud');
          for(const $detalle of detalles) {
            $detalle.onclick = e => {
              const $row = e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
              detallesOnClick($row);
            }
          }

          setState({ ordenes: indexadas, ordenesOrdenadas: indexadas });
        }

        function detallesOnClick($row) {
          const $modal = document.querySelector('#modal-mostrar-detalles');
          const modal = new bootstrap.Modal($modal, {});

          const codigo = $row.children[1].textContent;
          const { ordenes } = getState();
          
          const orden = ordenes[codigo];
          setState({ orden });

          modal.show();
        }

        function ordenarPor(columna, modo) {
          const { ordenes } = getState();

          const ordenadas = Object.values(ordenes).sort((a, b) => {
            const aCol = a[columna];
            const bCol = b[columna];

            if (modo === 'asc') {
              return aCol.localeCompare(bCol);
            }
            else {
              return bCol.localeCompare(aCol);
            }
          });

          const $tabla = document.getElementById('cuerpo-tabla');
          while($tabla.firstChild) {
            $tabla.removeChild($tabla.firstChild);
          }

          const ESTADO_TO_BADGE = {
            'pendiente': 'warning',
            'en proceso': 'info',
            'terminado': 'success',
          }

          ordenadas.forEach((orden, index) => {
            const $acciones = elt('td', { className: 'px-2 py-3 text-nowrap' },);
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
                    elt('a', { className: 'dropdown-item detalles-solicitud', href: '#' }, 'Más detalles'),
                  )
                )
              )
            );

            $tabla.appendChild(
              elt('tr', { scope: 'row', className: 'text-nowrap' },
                elt('th', { className: 'px-2 py-3 text-nowrap' }, `${index + 1}`),
                elt('td', { className: 'px-2 py-3 text-nowrap' }, orden.codigo),
                elt('td', { className: 'px-2 py-3 text-nowrap' }, orden.articulo),
                elt('td', { className: 'px-2 py-3 text-nowrap' }, orden.modelo),
                elt('td', { className: 'px-2 py-3 text-nowrap' }, orden.fecha),
                elt('td', { className: 'px-2 py-3 text-nowrap' },
                  elt('span', { className: `badge text-bg-${ESTADO_TO_BADGE[orden.estado]}` }, orden.estado)
                ),
                $acciones
              )
            );
          });

          const detalles = document.querySelectorAll('.detalles-solicitud');
          for(const $detalle of detalles) {
            $detalle.onclick = e => {
              const $row = e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
              detallesOnClick($row);
            }
          }
        }

        function getState() {
          return structuredClone(state);
        }

        function setState(newState) {
          for(const key in newState) {
            if (key in state === false) continue;

            state[key] = newState[key];
          }

          render();
        }

        function render() {
          const $codigo = document.getElementById('codigo');

          const $articulo = document.getElementById('articulo');
          const $marca = document.getElementById('marca');
          const $modelo = document.getElementById('modelo');
          const $serie = document.getElementById('serie');
          const $diagnostico = document.getElementById('diagnostico');
          const $observaciones = document.getElementById('observaciones');

          const $tecnico = document.getElementById('tecnico');

          const $solucion = document.getElementById('solucion');
          const $garantia = document.getElementById('garantia');
          const $monto = document.getElementById('monto');

          const $tecnicoTab = document.getElementById('tecnico-tab');
          const $reparacionTab = document.getElementById('reparacion-tab');

          const { orden } = getState();
          if (!orden) return;

          $codigo.textContent = orden.codigo;

          if (orden.estado !== 'terminado') {
            $reparacionTab.classList.add('disabled');
            $reparacionTab.disabled = true;
          } else {
            $reparacionTab.classList.remove('disabled');
            $reparacionTab.disabled = false;
          }

          if (!orden.tecnico.nombre) {
            $tecnicoTab.classList.add('disabled');
            $tecnicoTab.disabled = true;
          } else {
            $tecnicoTab.classList.remove('disabled');
            $tecnicoTab.disabled = false;
          }

          $articulo.textContent = orden.articulo;
          $marca.textContent = orden.marca;
          $modelo.textContent = orden.modelo;
          $serie.textContent = orden.numeroSerie;
          $diagnostico.textContent = orden.diagnostico;

          while($observaciones.firstChild) {
            $observaciones.removeChild($observaciones.firstChild);
          }

          for (const observacion of orden.observaciones.split('\n')) {
            $observaciones.appendChild(
              elt('li', { className: "list-group-item" }, observacion)
            );
          }

          $tecnico.textContent = `${orden.tecnico.nombre} ${orden.tecnico.apellido}`;

          $solucion.textContent = orden.solucion;
          $garantia.textContent = orden.garantia;
          $monto.textContent = orden.monto;
        }

        window.addEventListener('DOMContentLoaded', () => {
          boot();
        })
      })();
    </script>
  </div>
@stop