<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Totalpricetbl extends Model
{
    use HasFactory;

    protected $table      = "totalpricetbls";
    protected $primaryKey = "tptblid";
    protected $fillable   = [
        "custidfk","quoteidfk",
        "profit","gp",
        "cost","subtotal",
        "tax","taxpercentage","total",
        "inputby","status",
        "created_at","updated_at"
    ];
}
