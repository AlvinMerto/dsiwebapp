<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemtbl extends Model
{
    use HasFactory;
    protected $table      = "itemtbls";
    protected $primaryKey = "itemid";
    protected $fillable   = [
        "itemname","itemprice",
        "supplierid","mfgid",
        "description","inputby",
        "status","created_at","updated_at"
    ];

}
