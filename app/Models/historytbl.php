<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historytbl extends Model
{
    use HasFactory;
    protected $table        = "historytbls";
    protected $primaryKey   = "historyid";
    protected $fillable     = [
        "custidfk","tableid",
        "tablefrom","historyactivity",
        "status","inputby",
        "created_at","updated_at"
    ];
}
