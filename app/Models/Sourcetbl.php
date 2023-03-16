<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sourcetbl extends Model
{
    use HasFactory;
    protected $table = "sourcetbls";
    protected $primaryKey = "id";
    protected $fillable = [
        "source","status","created_at","updated_at"
    ];
}
