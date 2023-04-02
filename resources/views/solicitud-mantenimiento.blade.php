<main class="d-flex justify-content-center align-items-center w-75 p-3">
  <form
    action="{{ route('solicitud.post') }}"
    method="POST"
  >
    @csrf
    <div class="mb-3">
      <label for="num_serie" class="form-label">Número de Serie</label>
      <input
        type="text"
        id="num_serie"
        name="num_serie"
        class="form-control"
        placeholder="Ingresa"
        required
      >
    </div>
    <div class="mb-3">
      <label for="marca" class="form-label">Marca</label>
      <input
        type="text"
        id="marca"
        name="marca"
        class="form-control"
        placeholder="Ingresa"
        required
      >
    </div>
    <div class="mb-3">
      <label for="modelo" class="form-label">Modelo</label>
      <input
        type="text"
        id="modelo"
        name="modelo"
        class="form-control"
        placeholder="Ingresa"
        required
      >
    </div>
    <div class="mb-3">
      <label for="fecha_compra" class="form-label">Fecha de Compra</label>
      <input
        type="date"
        id="fecha_compra"
        name="fecha_compra"
        class="form-control"
        required
      >
    </div>
    <button type="submit" class="btn btn-primary">Registrar</button>
  </form>
</main>