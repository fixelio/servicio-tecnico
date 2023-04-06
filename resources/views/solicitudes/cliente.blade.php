@extends('layouts.master');

@section('content')
  <section class="my-5">
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
              </tr>
            </thead>
            <tbody>
              @for($i = 0; $i < count($solicitudes); $i++)
                <tr scope="row">
                  <th>{{$i + 1}}</th>
                  <td>{{ $solicitudes[$i]->codigo_solicitud }}</td>
                  <td>{{ $solicitudes[$i]->modelo }}</td>
                  <td>{{ $solicitudes[$i]->fecha_solicitud }}</td>
                  <td>
                    @if($solicitudes[$i]->estado_solicitud === 'pendiente')
                      <span class="badge text-bg-warning">Pendiente</span>
                    @elseif($solicitudes[$i]->estado_solicitud === 'en proceso')
                      <span class="badge text-bg-info">En Proceso</span>
                    @else
                      <span class="badge text-bg-success">Terminado</span>
                    @endif
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
  </section>
@stop