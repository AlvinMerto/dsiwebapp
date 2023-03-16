<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contactstbl extends Model
{
    use HasFactory;
    protected $primaryKey = "contid";
    protected $table      = "contactstbls";
    protected $fillable   = [
        "custidfk","contactname","title","contactnumber","email","address","city","state_country","zip","notes",
        "inputby","status","created_at","updated_at"
    ];
}
