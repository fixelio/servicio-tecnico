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
              <a href="{{ route('clientes') }}">Clientes</a></li>
            <li class="breadcrumb-item active">Editar</li>
          </ol>
        </nav>
        <h2 class="h4">Editar Cliente</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-body border-0 shadow mb-4">
          <form action="{{ route('cliente.put') }}" method="POST" class="row g-3 w-100">
            @csrf
            <div class="col-12 col-lg-6 mb-3">
              <label for="num_serie" class="form-label">Nombre <span class="required">*</span></label>
              <input
                type="text"
                id="nombre"
                name="nombre"
                class="form-control"
                placeholder="Ingresa el nombre"
                value="{{ $cliente ? $cliente?->nombre : '' }}"
                required
              >
            </div>
            <div class="col-12 col-lg-6 mb-3">
              <label for="num_serie" class="form-label">Apellido</label>
              <input
                type="text"
                id="apellido"
                name="apellido"
                class="form-control"
                placeholder="Ingresa el apellido"
                value="{{ $cliente !== false ? $cliente?->apellido : '' }}"
              >
            </div>
            <div class="col-12 col-lg-6 mb-3">
              <label for="num_serie" class="form-label">Correo <span class="required">*</span></label>
              <input
                type="email"
                id="correo_electronico"
                name="correo_electronico"
                class="form-control"
                placeholder="Ingresa el correo"
                value="{{ $cliente !== false ? $cliente?->correo_electronico : '' }}"
                required
              >
            </div>
            <div class="col-12 col-lg-6 mb-3">
              <label for="num_serie" class="form-label">Teléfono <span class="required">*</span></label>
              <input
                type="text"
                id="telefono"
                name="telefono"
                class="form-control"
                placeholder="Ingresa el teléfono"
                value="{{ $cliente !== false ? $cliente?->telefono : '' }}"
                required
              >
            </div>
            <input type="hidden" name="correo_buscar" value="{{ $cliente !== null ? $cliente?->correo_electronico : '' }}">
            <div>
              <button type="submit" class="btn btn-primary" id="boton-enviar-formulario">Editar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

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
        message: '{{ session()->get('message') }}'
    });
    </script>

    @endif

  </section>
@stop