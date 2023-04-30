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
              <a href="{{ route('listado-solicitudes') }}">Órdenes</a></li>
            <li class="breadcrumb-item active">Cotizar</li>
          </ol>
        </nav>
        <h2 class="h4">Cotización de Orden #{{ $codigo }}</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-body border-0 shadow mb-4">
          <form action="{{ route($solicitud === null ? 'cotizar.post' : 'cotizar.put') }}" method="POST" class="row g-3 w-100">
          @csrf

          <h3 class="h6 mb-4">Técnico responsable: {{ $tecnico->nombre." ".$tecnico->apellido }}</h3>

          <input type="hidden" name="codigo_solicitud" value="{{ $codigo }}">

          <div class="col-12 mb-3">
            <label for="descripcion_solucion" class="form-label">Descripción de la solución <span class="required">*</span></label>
            <textarea id="descripcion_solucion" name="descripcion_solucion" class="form-control" rows="4" required="true">{{ $solicitud?->descripcion_solucion }}</textarea>
          </div>
          
          <div class="col-12 col-sm-6 mb-3">
            <label for="precio_material" class="form-label">Precio de materiales <span class="required">*</span></label>
            <input type="number" class="form-control" placeholder="Ingresa el precio de los materiales" name="precio_material" id="precio_material" step="0.01" value="{{ $solicitud?->precio_material}}" required="true">
          </div>

          <div class="col-12 col-sm-6 mb-3">
            <label for="precio_obra" class="form-label">Precio de mano de obra <span class="required">*</span></label>
            <input type="number" class="form-control" placeholder="Ingresa el precio de la mano de obra" name="precio_obra" id="precio_obra" step="0.01" value="{{ $solicitud?->precio_obra}}" required="true">
          </div>

          <div class="col-12 col-sm-6 mb-3">
            <label for="garantia" class="form-label">Garantía <span class="required">*</span></label>
            <input type="text" class="form-control" placeholder="Garantía" name="garantia" id="garantia" value="{{ $solicitud?->garantia}}" required="true">
          </div>

          <div class="col-12 col-sm-6 mb-3">
            <label for="monto" class="form-label">Monto total <span class="required">*</span></label>
            <input type="number" class="form-control" placeholder="Monto total a pagar" name="monto" id="monto" value="{{ $solicitud?->monto}}" step="0.01" required="true">
          </div>

          <hr>

          <div>
            <button type="submit" class="btn btn-primary" id="boton-enviar-formulario">Cotizar</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <script>
      const $monto = document.getElementById('monto');
      const $precioMateriales = document.getElementById('precio_material');
      const $precioObra = document.getElementById('precio_obra');

      $precioMateriales.addEventListener('change', e => {
        $monto.value = `${Number($precioMateriales.value) + Number($precioObra.value)}`;
      });

      $precioMateriales.addEventListener('keyup', e => {
        $monto.value = `${Number($precioMateriales.value) + Number($precioObra.value)}`;
      });

      $precioObra.addEventListener('change', e => {
        $monto.value = `${Number($precioMateriales.value) + Number($precioObra.value)}`;
      });

      $precioObra.addEventListener('keyup', e => {
        $monto.value = `${Number($precioMateriales.value) + Number($precioObra.value)}`;
      });
    </script>
    
  </section>
@stop