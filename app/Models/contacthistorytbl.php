<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contacthistorytbl extends Model
{
    use HasFactory;

    protected $primaryKey = "conthisid";
    protected $table      = "contacthistorytbls";
    protected $fillable   = [
        "conthisid","contidfk","thefield","thevalue","thevaluename","inputby","status","created_at","updated_at"
    ];
    // ,"created_at","updated_at"
}
