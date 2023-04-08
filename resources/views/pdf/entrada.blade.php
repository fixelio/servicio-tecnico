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
	font-family: Helvetica, Arial, sans-serif;
	font-size: medium;
}

td {
  padding: 8px 10px;
}

.bordered td {
	border-color: #959594;
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
</style>
<body>
  <div class="divTable w-100 mb-5">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-33">
         <table class="bordered w-100">
           <tr>
             <td><b>Orden de Servicio: {{ $ordenServicio }}</b></td>
           </tr>
           <tr>
             <td><b>Fecha:</b> {{ $fechaSolicitud }}</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-67">
         <table class="w-100">
           <tr>
             <td class="text-center">25075822</td>
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
       <div class="divTableCell w-20">
         <table class="bordered w-100">
           <tr>
             <td><b>Cliente</b></td>
           </tr>
           <tr>
             <td><b>Artículo</b></td>
           </tr>
           <tr>
             <td><b>Marca</b></td>
           </tr>
         </table>
       </div>
       <div class="divTableCell">
         <table class="bordered w-100">
           <tr>
             <td>{{ $cliente }}</td>
           </tr>
           <tr>
             <td>{{ $articulo }}</td>
           </tr>
           <tr>
             <td>{{ $marca }}</td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-16">
         <table class="bordered w-100">
           <tr>
             <td><b>Teléfono</b></td>
           </tr>
           <tr>
             <td><b>Modelo</b></td>
           </tr>
           <tr>
             <td><b>Serie</b></td>
           </tr>
         </table>
       </div>
       <div class="divTableCell">
         <table class="bordered w-100">
           <tr>
             <td>{{ $telefono }}</td>
           </tr>
           <tr>
             <td>{{ $modelo }}</td>
           </tr>
           <tr>
             <td>{{ $serie }}</td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

  <div class="divTable w-100 mb-5">
   <div class="divTableBody">
     <div class="divTableRow">
       <div class="divTableCell w-16">
         <table class="bordered w-100">
           <tr>
             <td><b>Diagnóstico</b></td>
           </tr>
           <tr>
             <td><b>Notas</b></td>
           </tr>
         </table>
       </div>
       <div class="divTableCell w-100">
       	<table class="bordered w-100">
       		<tr>
             <td>{{ $diagnostico }}</td>
           </tr>
           <tr>
             <td>{{ $notas }}</td>
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
               Los equipos mojados no cuentan con GARANTIA.
               <br>La casa no se responsabiliza en caso de incendios, robos u otro tipo de siniestros.
               <br>Usted dispone de un plazo máximo de 60 días luego de cotizar para retirar el artículo, una vez finalizado el plazo, la empresa no se hace responsable.
             </td>
           </tr>
         </table>
       </div>
     </div>
   </div> 
  </div>

</body>
</html>