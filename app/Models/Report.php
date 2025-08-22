<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Campos que se pueden llenar con create() o update()
    protected $fillable = [
        'user_id',
        'type',
        'location',
        'description',
        'status',
        'attachment', // si también quieres guardar archivos
    ];
}
