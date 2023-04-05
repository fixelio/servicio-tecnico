@extends('layouts.master')

@section('content')
  <section class="mx-2 mx-md-4 my-5">
    <div class="container-md d-flex justify-content-center align-items-center mb-3 flex-column">
      <div class="w-75">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h3 class="mb-2 my-5">Clientes</h3>
          <a class="btn btn-primary" href="{{ route('registrar-cliente') }}">Registrar</a>
        </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Órdenes en proceso</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @for($i = 0; $i < count($clientes); $i++)
                <tr scope="row">
                  <th>{{ $i + 1 }}</th>
                  <td>{{ $clientes[$i]->nombre }} {{ $clientes[$i]->apellido }}</td>
                  <td>0</td>
                  <td class="d-flex justify-content-end align-items-end">
                    <div class="dropdown dropdown-menu-end">
                      <button
                        class="btn btn-primary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        Acciones
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="{{ route('registrar-solicitud', [
                            'correo' => $clientes[$i]->correo_electronico,
                          ])}}" class="dropdown-item">Registrar Orden</a></li>
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