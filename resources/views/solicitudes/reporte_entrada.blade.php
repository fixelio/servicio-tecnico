@extends('layouts.app')

@section('content')
  <section>
    <style>
      td, th {
        padding: 0.55rem !important;
        font-size: 11pt;
      }

      strong {
        font-size: 11pt;
        font-weight: bold;
      }
    </style>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
      <div class="d-block">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
          <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
              <a href="/">
                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Órdenes</li>
          </ol>
        </nav>
        <h2 class="h4">Generar Reporte</h2>
      </div>
    </div>

    <div class="card card-body border-0 shadow mb-4">
      <h3 class="h5 mb-2">Orden de Servicio #{{ $ordenServicio }}</h3>
      <div class="d-flex justify-content-between align-items-center flex-column flex-md-row mb-1">
        <p>La orden de servicio ha sido registrada exitosamente.</p>
        <p>
          <svg class="icon icon-xs" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path>
          </svg>
          {{ $fecha }}
        </p>  
      </div>
      <hr>
      <div class="container-fluid">
        <div class="row align-items-start">
          <div class="mb-2 col-12 col-xl-6">
            <h5 class="h6 mb-3">Datos del cliente</h5>
            <div class="table-wrapper">
              <table class="table table-striped table-bordered">
                <tbody>
                  <tr>
                    <th>Nombre y apellido</th>
                    <td><strong>{{ $cliente }}</strong></td>
                  </tr>
                  <tr>
                    <th>Correo</th>
                    <td><strong>{{ $correo }}</strong></td>
                  </tr>
                  <tr>
                    <th>Celular</th>
                    <td><strong>{{ $telefono }}</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="mb-2 col-12 col-xl-6">
            <h5 class="h6 mb-3">Datos del equipo</h5>
            <div class="table-wrapper">
              <table class="table table-striped table-bordered">
                <tbody>
                  <tr>
                    <th>Artículo</th>
                    <td><strong>{{ $articulo }}</strong></td>
                  </tr>
                  <tr>
                    <th>Marca</th>
                    <td><strong>{{ $marca }}</strong></td>
                  </tr>
                  <tr>
                    <th>Modelo</th>
                    <td><strong>{{ $modelo }}</strong></td>
                  </tr>
                  <tr>
                    <th>Número de serie</th>
                    <td><strong>{{ $serie }}</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="mb-2 container-fluid">
        <h5 class="h6 mb-3">Datos de Orden</h5>
        <div class="table-wrapper">
          <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <th>Técnico responsable</th>
                <td><strong>{{ $tecnico }}</strong></td>
              </tr>
              <tr>
                <th>Diagnóstico</th>
                <td><strong>
                  @foreach(preg_split('/\r\n|\r|\n/', $diagnostico) as $d)
                    {{ $d }}<br>
                  @endforeach
                </strong></td>
              </tr>
              <tr>
                <th>Notas</th>
                <td><strong>
                  @foreach(preg_split('/\r\n|\r|\n/', $notas) as $nota)
                    {{ $nota }}<br>
                  @endforeach
                </strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <hr>

      <div class="d-block">
        <a href="/solicitudes" class="btn btn-primary me-2">
          <svg class="icon icon-xs mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Página Principal
        </a>
        <button class="btn btn-secondary" onclick="document.querySelector('#form-imprimir').submit()">
          <svg class="icon icon-xs" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"></path></svg>
          Imprimir
        </button>
      </div>

      <form action="{{ route('generar-reporte-entrada') }}" method="POST" class="d-none" id="form-imprimir">
        @csrf
        <input type="hidden" name="cliente" value="{{ $cliente }}">
        <input type="hidden" name="telefono" value="{{ $telefono }}">
        <input type="hidden" name="articulo" value="{{ $articulo }}">
        <input type="hidden" name="marca" value="{{ $marca }}">
        <input type="hidden" name="modelo" value="{{ $modelo }}">
        <input type="hidden" name="serie" value="{{ $serie }}">
        <input type="hidden" name="diagnostico" value="{{ $diagnostico }}">
        <input type="hidden" name="notas" value="{{ $notas }}">
        <input type="hidden" name="tecnico" value="{{ $tecnico }}">
        <input type="hidden" name="ordenServicio" value="{{ $ordenServicio }}">
      </form>

    </div>
  </section>
@stop