@extends('layouts.master');

@section('content')
  <div class="position-relative overflow-hidden">
    <h3 class="mb-5 p-3">Lista de Órdenes</h3>

    @if ($tecnico !== null)
      <div class="px-3">
        <p>Técnico: <strong>{{ $tecnico->nombre }} {{ $tecnico->apellido }}</strong></p>
      </div>
    @endif

    @if(count($trabajos) > 0)
      <div class="overflow-x-auto px-3">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Código</th>
              <th scope="col">Artículo</th>
              <th scope="col">Modelo</th>
              <th scope="col">Fecha</th>
              <th scope="col">Estado</th>
            </tr>
          </thead>
          <tbody>
            @for($i = 0; $i < count($trabajos); $i++)
              <tr scope="row" class="text-nowrap">
                <th class="px-2 py-3">{{$i + 1}}</th>
                <td class="px-2 py-3">{{ $trabajos[$i]->codigo_solicitud }}</td>
                <td class="px-2 py-3">{{ $trabajos[$i]->articulo }}</td>
                <td class="px-2 py-3">{{ $trabajos[$i]->modelo }}</td>
                <td class="px-2 py-3">{{ $trabajos[$i]->fecha_solicitud }}</td>
                <td class="px-2 py-3">
                  @if($trabajos[$i]->estado_solicitud === 'pendiente')
                    <span class="badge text-bg-warning">Pendiente</span>
                  @elseif($trabajos[$i]->estado_solicitud === 'en proceso')
                    <span class="badge text-bg-info">En Proceso</span>
                  @else
                    <span class="badge text-bg-success">Terminado</span>
                  @endif
                </td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
    @elseif($tecnico !== null)
      <div class="alert alert-warning" role="alert">Este técnico no tiene ninguna órden de mantenimiento asignada. <a href="{{ route('listado-solicitudes') }}" class="link-opacity-100">Ir a la página de órdenes.</a></div>
    @endif

  </div>
@stop