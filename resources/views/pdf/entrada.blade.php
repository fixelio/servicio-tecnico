<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="PDF de entrada de una solicitud">
	<meta name="keywords" content="solicitud de mantenimiento, reporte">
	<title>Solicitud de entrada</title>
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

.mb-3 {
  margin-bottom: 1rem;
}

.mb-4 {
  margin-bottom: 1.5rem;
}

.mb-5 {
  margin-bottom: 2rem;
}

.ms-3 {
  margin-left: 1rem;
}

.me-3 {
  margin-right: 1rem;
}

</style>
<body>
  <div class="divTable w-100 mb-4">
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
           <tr class="bg-gray">
             <td class="text-center">{{ $empresa['telefono'] }}</td>
           </tr>
           <tr>
             <td class="text-center">{{ $empresa['email'] }}</td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

  <div class="divTable w-100 mb-4">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-20">
         <table class="bordered w-100">
           <tr class="bg-gray">
             <td>Cliente</td>
           </tr>
           <tr>
             <td>Artículo</td>
           </tr>
           <tr>
             <td class="bg-gray">Modelo</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell me-3">
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
       <div class="divTableCell w-16 ms-3">
         <table class="bordered w-100">
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
       <div class="divTableCell">
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

  <div class="divTable w-100 mb-4">
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
              <td class="td-inline">Notas</td>
              <td class="w-100">
                @foreach(preg_split('/\r\n|\r|\n/', $notas) as $nota)
                  <b>{{ $nota }}</b><br>
                @endforeach
              </td>
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
             <td style="padding: 32px 10px; padding-bottom: 6px;">Técnico responsable: {{ $tecnico }}</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-50">
         <table class="bordered w-100">
           <tr>
             <td style="padding: 32px 10px; padding-bottom: 6px;">Firma: __________________</td>
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
               @foreach(preg_split('/\r\n|\r|\n/', $empresa['footer']) as $f)
                  {{ $f }}<br>
                @endforeach
             </td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>


  <hr class="bg-gray w-100" style="margin-top: 2rem !important; margin-bottom: 2rem !important;">


  <div class="divTable w-100 mb-4">
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
           <tr class="bg-gray">
             <td class="text-center">{{ $empresa['telefono'] }}</td>
           </tr>
           <tr>
             <td class="text-center">{{ $empresa['email'] }}</td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

  <div class="divTable w-100 mb-4">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-20">
         <table class="bordered w-100">
           <tr class="bg-gray">
             <td>Cliente</td>
           </tr>
           <tr>
             <td>Artículo</td>
           </tr>
           <tr>
             <td class="bg-gray">Modelo</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell me-3">
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
       <div class="divTableCell w-16 ms-3">
         <table class="bordered w-100">
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
       <div class="divTableCell">
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

  <div class="divTable w-100 mb-4">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-100">
         <table class="bordered w-100" style="page-break-inside: avoid !important;">
            <tr>
              <td class="td-inline bg-gray">Diagnóstico</td>
              <td class="w-100 bg-gray"><b>
                @foreach(preg_split('/\r\n|\r|\n/', $diagnostico) as $d)
                  <b>{{ $d }}</b><br>
                @endforeach
              </b></td>
            </tr>
            <tr>
              <td class="td-inline">Notas</td>
              <td class="w-100">
                @foreach(preg_split('/\r\n|\r|\n/', $notas) as $nota)
                  <b>{{ $nota }}</b><br>
                @endforeach
              </td>
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
             <td style="padding: 32px 10px; padding-bottom: 6px;">Técnico responsable: {{ $tecnico }}</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-50">
         <table class="bordered w-100">
           <tr>
             <td style="padding: 32px 10px; padding-bottom: 6px;">Firma: __________________</td>
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
               @foreach(preg_split('/\r\n|\r|\n/', $empresa['footer']) as $f)
                  {{ $f }}<br>
                @endforeach
             </td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

</body>
</html>