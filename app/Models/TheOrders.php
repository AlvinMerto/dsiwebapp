<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheOrders extends Model
{
    use HasFactory;
    protected $table      = "the_orders";
    protected $primaryKey = "theorderid";

    protected $fillable   = [
        "quoteid","custidfk","contidfk","processeddate",
        "bulkorderid","weeknumber","vendor","description","quoteid",
        "qty","unitcost","extendedcost","estimatedsh","estimatedshtax","tax",
        "totalcost","totalcosttax","inputby","status","created_at","updated_at"
    ];
    
}
