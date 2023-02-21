<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productline extends Model
{
    use HasFactory;

    protected $table        = "productlines";
    protected $primaryKey   = "productlineid";
    protected $fillable     = [
        "theproductline","minimummarkup",
        "iscustom","thegrpid",
        "inputby","status",
        "created_at","updated_at"
    ];
}
