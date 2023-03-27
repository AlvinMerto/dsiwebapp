<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class allowedcells extends Model
{
    use HasFactory;

    protected $table        = "allowedcells";
    protected $primaryKey   = "acid"; 
    protected $fillable     = [
        "quoteid","quoteitemid","requestinguserid",
        "cellid","auidfk","status","inputby",
        "created_at","updated_at"
    ];
}
