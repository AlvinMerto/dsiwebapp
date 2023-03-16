<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class viewquoteopts extends Model
{
    use HasFactory;

    protected $table        = "viewquoteopts";
    protected $primaryKey   = "vopid";
    protected $fillable     = [
        "viewoptionfld","quoteidfk","optiontype",
        "inputby","status","orderfld",
        "created_at","updated_at"
    ];
}
