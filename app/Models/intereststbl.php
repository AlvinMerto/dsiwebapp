<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intereststbl extends Model
{
    use HasFactory;
    protected $table      = "intereststbls";
    protected $primaryKey = "interid";
    protected $fillable   = [
        "theinterest","inputby","status","created_at","updated_at"
    ];
}
