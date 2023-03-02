<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtotaltbl extends Model
{
    use HasFactory;

    protected $table        = "subtotaltbls";
    protected $primaryKey   = "subtotalid";
    protected $fillable     = [
        "quoteidfk","subtotalname","subtotalqty","inputby",
        "status","created_at","updated_at"
    ];
}
