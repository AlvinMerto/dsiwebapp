<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationCorner extends Model
{
    use HasFactory;
    protected $table      = "quotation_corners";
    protected $primaryKey = "quoteid";
    protected $fillable   = [
        "custidfk","quotedate","quotevalidity","orderdate",
        "quoteprice","quotationsentto","quotationname",
        "taxused","inputby",
        "status","created_at","updated_at"
    ];
}
