<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linkstbl extends Model
{
    use HasFactory;

    protected $primaryKey = "sourceid";
    protected $table      = "linkstbls";
    protected $fillable   = [
        "custid","documentname",
        "notes","filename",
        "url","groupidfk",
        "inputby","status",
        "created_at","updated_at"
    ];
}
