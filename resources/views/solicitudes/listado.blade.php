@extends('layouts.master')

@section('content')
  <section class="my-5">
    <div class="container d-flex justify-content-center align-items-center flex-column">
      <div class="w-75 mt-5">
        <h3>Listado de órdenes</h3>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Código</th>
              <th scope="col">Cliente</th>
              <th scope="col">Artículo</th>
              <th scope="col">Estado</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
    </div>
  </section>
@stop