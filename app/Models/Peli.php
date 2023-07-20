<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peli extends Model
{
    use HasFactory, SoftDeletes;

    //protected $table = '';
    protected $fillable = ['titulo', 'director', 'anyo', 'imagen', 'user_id', 'descatalogada','isan', 'color'];

    // retorna el usuario propietario de la película
    public function user() {
        return $this->belongsTo('\App\Models\User');
    }
}
