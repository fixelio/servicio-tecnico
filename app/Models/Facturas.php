<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;

    protected $table = 'facturas';

    protected $primaryKey = 'id_factura';
    protected $fillable = ['id_historial', 'precio_material', 'precio_obra', 'monto'];
}
