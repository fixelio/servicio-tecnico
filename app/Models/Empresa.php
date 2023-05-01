<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
	protected $table = 'empresa';
	protected $primaryKey = 'id_empresa';
	protected $fillable = ['email', 'telefono', 'footer'];
	
    use HasFactory;
}
