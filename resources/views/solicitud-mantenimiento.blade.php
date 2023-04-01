<main>
  <form action="{{ route('solicitud.post') }}" method="POST">
    @csrf
    <input type="text" id="num_serie" name="num_serie" placeholder="Número de serie" required>
    <input type="text" id="marca" name="marca" placeholder="Marca" required>
    <input type="text" id="modelo" name="modelo" placeholder="Modelo" required>
    <input type="date" id="fecha_compra" name="fecha_compra" required>
    <button type="submit">Registrar</button>
  </form>
</main>