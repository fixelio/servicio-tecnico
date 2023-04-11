@extends('layouts.master')

@section('content')
  <div class="position-relative overflow-hidden">
    <h3 class="mb-5 p-3">Técnicos</h3>

    <div class="overflow-x-auto px-3">
      <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Correo</th>
              <th scope="col">Teléfono</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @for($i = 0; $i < count($tecnicos); $i++)
              <tr scope="row" class="text-nowrap">
                <th class="px-2 py-3">{{ $i + 1 }}</th>
                <td class="px-2 py-3">{{ $tecnicos[$i]->nombre }} {{ $tecnicos[$i]->apellido }}</td>
                <td class="px-2 py-3">{{ $tecnicos[$i]->correo_electronico }}</td>
                <td class="px-2 py-3">{{ $tecnicos[$i]->telefono }}</td>
                <td class="px-2 py-3">
                  <div class="">
                    <button class="focus-ring px-2 rounded fs-5" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: none;outline: none;border: none">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('editar-tecnico', ['correo' => $tecnicos[$i]->correo_electronico]) }}">Editar</a></li>
                      <li><a class="dropdown-item" href="{{ route('solicitudes-tecnico', ['correo' => $tecnicos[$i]->correo_electronico]) }}">Órdenes Asignadas</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
            @endfor
          </tbody>
      </table>
    </div>
    
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
