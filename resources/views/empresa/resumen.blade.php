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
            <li class="breadcrumb-item">
              <a href="{{ route('listado-solicitudes') }}">Empresa</a></li>
            <li class="breadcrumb-item active">Información</li>
          </ol>
        </nav>
        <h2 class="h4">Información de la Empresa</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-body border-0 shadow mb-4">
          <form action="{{ route('empresa.put') }}" method="POST" class="row g-3 w-100">
          @csrf

          <h4 class="h5 mb-3">Datos de la empresa</h4>

          <div class="col-12 mb-3">
            <label for="email" class="form-label">Correo Electrónico <span class="required">*</span></label>
            <input type="email" class="form-control" placeholder="Correo Electrónico de la empresa" name="email" id="email" value="{{ $email }}" required="true">
          </div>

          <div class="col-12 mb-3">
            <label for="telefono" class="form-label">Teléfono <span class="required">*</span></label>
            <input type="text" class="form-control" placeholder="Teléfono de la empresa" name="telefono" id="telefono" value="{{ $telefono }}" required="true">
          </div>

          <h4 class="h5 my-3">Reportes</h4>

          <div class="col-12 mb-3">
            <label for="footer" class="form-label">Contenido de pie de página <span class="required">*</span></label>
            <textarea id="footer" name="footer" class="form-control" rows="5" required="true">{{ $footer }}</textarea>
          </div>

          <hr>

          <div>
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    
  </section>
@stop