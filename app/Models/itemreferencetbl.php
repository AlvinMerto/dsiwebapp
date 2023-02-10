<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemreferencetbl extends Model
{
    use HasFactory;
    protected $table      = "itemreferencetbls";
    protected $primaryKey = "itemrefid";
    protected $fillable   = [
        "quoteidfk","itemgrpid","theitemid",
        "criteria","reference","thevalue",
        "inputby","status",
        "created_at","updated_at"
    ];

}
