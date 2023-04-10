@extends('layouts.master')

@section('content')
  <section class="mx-2 mx-md-4 my-5">
    <div class="container-md d-flex justify-content-center align-items-center mb-3 flex-column">
      <div class="wrapper">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h3 class="mb-2 my-5">Técnicos</h3>
          <a class="btn btn-primary" href="{{ route('registrar-tecnico') }}">Registrar Técnico</a>
        </div>
      </div>
      <div class="wrapper table-responsive-md">
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
                <tr scope="row">
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
      </div>
    </div>
  </section>
@stop
