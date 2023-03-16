<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contactfluidtbl extends Model
{
    use HasFactory;

    protected $primaryKey = "cffid";
    protected $table      = "contactfluidtbls";
    protected $fillable   = [
        "cffid","contidfk","contidfk","thefield","thevalue","status","inputby","created_at","updated_at"
    ];
}
