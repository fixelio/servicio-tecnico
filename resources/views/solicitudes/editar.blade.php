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
            <li class="breadcrumb-item active">Editar</li>
          </ol>
        </nav>
        <h2 class="h4">Editar Orden</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-body border-0 shadow mb-4">
          <form action="{{ route('solicitud.put') }}" method="POST" class="row g-3 w-100">
          @csrf
          <div class="class col-12 mb-3">
            <label for="estado_solicitud">Estado <span class="required">*</span></label>
            <select class="form-select" name="estado_solicitud" id="estado_solicitud" value="{{ $solicitud !== null ? $solicitud->estado_solicitud : '' }}" required="">
              <option value="ingresado" {{ $solicitud->estado_solicitud === 'ingresado' ? 'selected="selected"' : '' }}>Ingresado</option>
              <option value="presupuestado" {{ $solicitud->estado_solicitud === 'presupuestado' ? 'selected="selected"' : '' }}>Presupuestado</option>
              <option value="en reparacion" {{ $solicitud->estado_solicitud === 'en reparacion' ? 'selected="selected"' : '' }}>En Reparación</option>
              <option value="derivado" {{ $solicitud->estado_solicitud === 'derivado' ? 'selected="selected"' : '' }}>Derivado</option>
              <option value="listo" {{ $solicitud->estado_solicitud === 'listo' ? 'selected="selected"' : '' }}>Listo</option>
              <option value="entregado" {{ $solicitud->estado_solicitud === 'entregado' ? 'selected="selected"' : '' }}>Entregado</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label for="articulo" class="form-label">Artículo <span class="required">*</span></label>
            <input
              type="text"
              id="articulo"
              name="articulo"
              class="form-control"
              placeholder="Ingresa el nombre del artículo"
              value="{{ $solicitud !== null ? $solicitud?->articulo : '' }}"
            >
          </div>
          <div class="col-12 col-sm-6 mb-3">
            <label for="num_serie" class="form-label">Número de Serie</label>
            <input
              type="text"
              id="num_serie"
              name="num_serie"
              class="form-control"
              placeholder="Ingresa el número de serie"
              value="{{ $solicitud !== null ? $solicitud?->num_serie : '' }}"
            >
          </div>
          <div class="col-12 col-sm-6 mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input
              type="text"
              id="marca"
              name="marca"
              class="form-control"
              placeholder="Ingresa la marca"
              value="{{ $solicitud !== null ? $solicitud?->marca : '' }}"
            >
          </div>
          <div class="col-12 col-sm-6 mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input
              type="text"
              id="modelo"
              name="modelo"
              class="form-control"
              placeholder="Ingresa el modelo"
              value="{{ $solicitud !== null ? $solicitud?->modelo : '' }}"
            >
          </div>
          <div class="col-12 col-sm-6 mb-3">
            <label for="fecha_compra" class="form-label">Fecha de ingreso <span class="required">*</span></label>
            <input
              type="date"
              id="fecha_compra"
              name="fecha_compra"
              class="form-control"
              placeholder="Ingresa la fecha de ingreso"
              value="{{ $solicitud !== null ? $solicitud?->fecha_compra : '' }}"
            >
          </div>

          <div class="col-12 mb-3">
            <label for="descripcion_problema" class="form-label">
              Descripción del problema <span class="required">*</span>
            </label>
            <textarea name="descripcion_problema" id="descripcion_problema" class="form-control" rows="4" value="{{ $solicitud !== null ? $solicitud?->descripcion_problema : '' }}">{{ $solicitud !== null ? $solicitud?->descripcion_problema : '' }}</textarea>
          </div>

          <div class="col-12 mb-3">
            <label for="observaciones" class="form-label">
              Observaciones
            </label>
            <textarea name="observaciones" id="observaciones" class="form-control" rows="4" value="{{ $solicitud !== null ? $solicitud?->observaciones : '' }}">{{ $solicitud !== null ? $solicitud?->observaciones : '' }}</textarea>
          </div>

          <input type="hidden" name="codigo_buscar" value="{{ $solicitud?->codigo_solicitud }}">

          @if (is_null($solicitud->descripcion_solucion) === false)

          <hr>

          <h5 class="h6 mb-3">Datos de reparación</h5>

          <div class="col-12 mb-3">
            <label for="descripcion_solucion" class="form-label">Descripción de la solución <span class="required">*</span></label>
            <textarea id="descripcion_solucion" name="descripcion_solucion" class="form-control" rows="4" required="true">{{ $solicitud?->descripcion_solucion }}</textarea>
          </div>

          @endif
          
          @if (is_null($solicitud?->precio_material) === false)
          <div class="col-12 col-sm-6 mb-3">
            <label for="precio_material" class="form-label">Precio de materiales</label>
            <input type="number" class="form-control" placeholder="Ingresa el precio de los materiales" name="precio_material" id="precio_material" value="{{ $solicitud?->precio_material}}" step="0.01" required="true">
          </div>
          @endif

          @if (is_null($solicitud?->precio_obra) === false)
          <div class="col-12 col-sm-6 mb-3">
            <label for="precio_obra" class="form-label">Precio de mano de obra</label>
            <input type="number" class="form-control" placeholder="Ingresa el precio de la mano de obra" name="precio_obra" id="precio_obra" value="{{ $solicitud?->precio_obra}}" step="0.01" required="true">
          </div>
          @endif

          @if (is_null($solicitud?->garantia) === false)
          <div class="col-12 col-sm-6 mb-3">
            <label for="garantia" class="form-label">Garantía</label>
            <input type="text" class="form-control" placeholder="Garantía" name="garantia" id="garantia" value="{{ $solicitud?->garantia}}" required="true">
          </div>
          @endif

          @if (is_null($solicitud?->monto) === false)
          <div class="col-12 col-sm-6 mb-3">
            <label for="monto" class="form-label">Monto total</label>
            <input type="number" class="form-control" placeholder="Monto total a pagar" name="monto" id="monto" value="{{ $solicitud?->monto}}" step="0.01" required="true">
          </div>
          @endif

          <div>
            <button type="submit" class="btn btn-primary" id="boton-enviar-formulario">Editar</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <script>
      @if (is_null($solicitud?->monto) === false)
      
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

      @endif

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
    
  </section>
@stop