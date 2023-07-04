<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peli extends Model
{
    use HasFactory;

    //protected $table = '';
    protected $fillable = ['titulo', 'director', 'anyo', 'imagen', 'descatalogada'];
}
