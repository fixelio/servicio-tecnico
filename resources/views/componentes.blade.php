<section class="mx-3">
  <h3>Componentes</h3>
  <div class="container-sm d-flex justify-content-center align-items-center flex-column">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Precio</th>
        </tr>
      </thead>
      <tbody>
        @foreach($componentes as $componente)
          <tr>
            <th scope="row"></th>
            <td>{{ $componente->nombre }}</td>
            <td>{{ $componente->descripcion }}</td>
            <td>{{ $componente->precio }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>