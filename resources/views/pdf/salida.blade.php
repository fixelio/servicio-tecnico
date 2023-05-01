<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="PDF de entrada de una solicitud">
	<meta name="keywords" content="solicitud de mantenimiento, reporte">
	<title>Solicitud de Salida</title>
</head>
<style>
* {
  font-family: Inter, sans-serif;
  font-size: small;
}

td {
  padding: 6px 7px;
}

.bg-gray {
  background: #e0e0e0;
}

.bordered td {
  border-color: #e0e0e0;
  border-style: solid;
  border-width: 1px;
}

table {
  border-collapse: collapse;
}

.divTable {
  display: table;
  width: 100%;
}

.divTableRow {
  display: table-row;
}

.divTableCell,
.divTableHead {
  border: 0px !important;
  display: table-cell;
  padding: 0px !important;
}

.divTableBody {
  display: table-row-group;
}

.w-100 {
  width: 100%;
}

.w-50 {
  width: 50%;
}

.w-33 {
  width: 33%;
}

.w-67 {
  width: 67%;
}

.w-25 {
  width: 25%;
}

.w-16 {
  width: 16%;
}

.w-20 {
  width: 20%;
}

.text-center {
  text-align: center;
}

.mb-5 {
  margin-bottom: 2rem;
}

.td-inline {
  width: 1%;
  white-space: nowrap;
}

.mb-3 {
  margin-bottom: 1rem;
}

.mb-4 {
  margin-bottom: 1.5rem;
}

.mb-5 {
  margin-bottom: 2rem;
}
</style>
<body>
  <div class="divTable w-100 mb-5">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-33">
         <table class="bordered w-100">
           <tr>
             <td class="bg-gray"><b>Orden de Servicio: {{ $ordenServicio }}</b></td>
           </tr>
           <tr>
             <td><b>Fecha:</b> {{ $fechaSolicitud }}</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-67">
         <table class="w-100">
           <tr>
             <td class="text-center bg-gray">25075822</td>
           </tr>
           <tr>
             <td class="text-center">megabitsoluciones@gmail.com</td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

  <div class="divTable w-100 mb-5">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell" style="width: 17.1%">
         <table class="bordered w-100">
           <tr>
             <td class="bg-gray">Cliente</td>
           </tr>
           <tr>
             <td>Artículo</td>
           </tr>
           <tr>
             <td class="bg-gray">Modelo</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-50">
         <table class="bordered w-100">
           <tr>
             <td class="bg-gray"><b>{{ $cliente }}</b></td>
           </tr>
           <tr>
             <td><b>{{ $articulo }}</b></td>
           </tr>
           <tr>
             <td class="bg-gray"><b>{{ $modelo }}</b></td>
           </tr>
         </table>
       </div>
       <div class="divTableCell">
         <table class="bordered">
           <tr>
             <td class="bg-gray">Teléfono</td>
           </tr>
           <tr>
             <td>Marca</td>
           </tr>
           <tr>
             <td class="bg-gray">Serie</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-50">
         <table class="bordered w-100">
           <tr>
             <td class="bg-gray"><b>{{ $telefono }}</b></td>
           </tr>
           <tr>
             <td><b>{{ $marca }}</b></td>
           </tr>
           <tr>
             <td class="bg-gray"><b>{{ $serie }}</b></td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

  <div class="divTable w-100 mb-5">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-100">
         <table class="bordered w-100" style="page-break-inside: avoid !important;">
            <tr>
              <td class="td-inline bg-gray">Diagnóstico</td>
              <td class="w-100 bg-gray">
                @foreach(preg_split('/\r\n|\r|\n/', $diagnostico) as $d)
                  <b>{{ $d }}</b><br>
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="td-inline">Reparación</td>
              <td class="w-100">
                @foreach(preg_split('/\r\n|\r|\n/', $reparacion) as $r)
                  <b>{{ $r }}</b><br>
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="td-inline bg-gray">Garantía</td>
              <td class="w-100 bg-gray"><b>{{ $garantia }}</b></td>
            </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

  <div class="divTable w-100">
    <div class="divTableBody">
      <div class="divTableRow">
        <div class="divTableCell w-33">
          <table class="bordered w-100">
            <tr>
              <td class="bg-gray"><b style="font-size: large; font-style: italic;">Total a Pagar: ${{ $monto }}</b></td>
            </tr>
          </table>
        </div>
        <div class="divTableCell w-67">
          <table class="w-100">
            <tr>
              <td class="text-center bg-gray">Técnico Responsable: <b>{{ $tecnico }}</b></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="divTable w-100">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-50">
         <table class="bordered w-100">
           <tr>
             <td style="padding: 42px 10px; padding-bottom: 6px;">Firma del cliente: __________________</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-50">
         <table class="bordered w-100">
           <tr>
             <td style="padding: 42px 10px; padding-bottom: 6px;">Firma del técnico: __________________</td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>
  <div class="divTable w-100">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-50">
         <table class="bordered w-100">
           <tr>
             <td class="text-center" style="font-size: small;">
               Los equipos mojados no cuentan con GARANTIA.
               <br>La casa no se responsabiliza en caso de incendios, robos u otro tipo de siniestros.
               <br>Usted dispone de un plazo máximo de 60 días luego de cotizar para retirar el artículo, una vez finalizado el plazo la empresa no se hace responsable.
             </td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

</body>
</html>