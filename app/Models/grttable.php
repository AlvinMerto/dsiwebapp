<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grttable extends Model
{
    use HasFactory;

    protected $table      = "grttables";
    protected $primaryKey = "grtid";
    protected $fillable   = [
        "custid","quoteidfk",
        "grttypeid","grtvalue",
        "inputby","status",
        "created_at","updated_at"
    ];
}
