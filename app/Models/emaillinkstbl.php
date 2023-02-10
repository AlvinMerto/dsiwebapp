<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emaillinkstbl extends Model
{
    use HasFactory;

    protected $table      = "emaillinkstbls";
    protected $primaryKey = "emaillinkid";
    protected $fillable   = [
        "thecode","linktoapprove",
        "idfk","idfld","thetbl",
        "approver","requestor",
        "inputby","status",
        "created_at","updated_at",
    ];
}
