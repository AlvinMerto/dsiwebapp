<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quoteitemstbl extends Model
{
    use HasFactory;

    protected $table      = "quoteitemstbls";
    protected $primaryKey = "quoteitemid";
    protected $fillable   = [
        "quoteidfk","tblorder",
        "subtotalidfk","itemtype","itemdesc",
        "itemcost","suppname",
        "supppart","manuname",
        "manupart","profit",
        "markup","markupvalue",
        "itemidfk","qty",
        "price","extended",
        "taxable","status","inputby",
        "created_at","updated_at"
    ];
}
