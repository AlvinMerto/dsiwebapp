<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notestbl extends Model
{
    use HasFactory;
    protected $primaryKey = "notedid";
    protected $table      = "notestbls";
    protected $fillable   = [
        "custid","reference","label","thenote","groupidfk","status","inputby","created_at","updated_at"
    ];
}
