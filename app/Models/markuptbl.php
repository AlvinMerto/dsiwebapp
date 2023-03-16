<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class markuptbl extends Model
{
    use HasFactory;

    protected $table      = "markuptbls";
    protected $primaryKey = "mrkupid";
    protected $fillable   = [
        "thevalue","inputby","status","created_at","updated_at"
    ];
}
