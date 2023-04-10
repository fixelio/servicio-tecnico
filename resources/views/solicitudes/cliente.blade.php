@extends('layouts.master');

@section('content')
  <section class="my-5">
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
                  <p>Modelo: <strong id="marca"></strong></p>
                  <p>Marca: <strong id="modelo"></strong></p>
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
    <div class="container d-flex justify-content-center align-items-center flex-column">
      <div class="w-75">
        <h3 class="mb-5">Histórico de Solicitudes</h3>

        <p>Cliente: <strong>{{ $cliente->nombre }} {{ $cliente->apellido }}</strong></p>

        @if(count($solicitudes) > 0)
          <p class="mt-3 mb-4">Solicitudes: <strong>{{ count($solicitudes) }}</strong></p>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Código</th>
                <th scope="col">Artículo</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @for($i = 0; $i < count($solicitudes); $i++)
                <tr scope="row">
                  <th class="px-2 py-3">{{$i + 1}}</th>
                  <td class="px-2 py-3">{{ $solicitudes[$i]->codigo_solicitud }}</td>
                  <td class="px-2 py-3">{{ $solicitudes[$i]->modelo }}</td>
                  <td class="px-2 py-3">{{ $solicitudes[$i]->fecha_solicitud }}</td>
                  <td class="px-2 py-3">
                    @if($solicitudes[$i]->estado_solicitud === 'pendiente')
                      <span class="badge text-bg-warning">Pendiente</span>
                    @elseif($solicitudes[$i]->estado_solicitud === 'en proceso')
                      <span class="badge text-bg-info">En Proceso</span>
                    @else
                      <span class="badge text-bg-success">Terminado</span>
                    @endif
                  </td>
                  <td class="px-2 py-3">
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
        @else
          <div class="alert alert-warning" role="alert">Este cliente no tiene ninguna solicitud de mantenimiento registrada. <a href="{{ route('clientes') }}" class="link-opacity-100">Volver a la lista de clientes.</a> o ir a la página de <a href="{{ route('listado-solicitudes') }}" class="link-opacity-100">solicitudes.</a></div>
        @endif
      </div>
    </div>
    <script>
      (async() => {
        const state = {
          orden: null,
          ordenes: [],
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

          const detalles = document.querySelectorAll('.detalles-solicitud');
          for(const $detalle of detalles) {
            $detalle.onclick = e => {
              const $row = e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
              detallesOnClick($row);
            }
          }

          setState({ ordenes: indexadas });
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
  </section>
@stop