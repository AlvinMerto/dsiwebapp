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
        "subtotalidfk","productlineid",
        "productline","itemtype",
        "itemdesc","itemcost",
        "markup","markupvalue",
        "suppname","supppart",
        "manuname","manupart",
        "withshipping","shippingcost",
        "shippingmarkup","shippingfinalprice",
        "withexpiry","expnumber",
        "expunit","expnote",
        "profit","itemidfk",
        "qty","price",
        "extended","taxable",
        "status","inputby",
        "created_at","updated_at"
    ];
}
