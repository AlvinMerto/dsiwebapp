<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemstbl extends Model
{
    use HasFactory;
    protected $table      = "itemstbls";
    protected $primaryKey = "itemid";
    protected $fillable   = [
        "category","itemcode","description","itemname","itemprice",
        "markup","sellprice","supplierid","suppliername",
        "mfgid","mfgname","istaxable","inputby",
        "status","created_at","updated_at"
    ];
}
