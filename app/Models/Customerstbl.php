<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerstbl extends Model
{
    use HasFactory;

    protected $table      = "Customerstbls";
    protected $primaryKey = "id";
    protected $fillable   = ["companyname",
                             "contactperson",
                            "contactnumber",
                            "email",
                            "website",
                            "dept",
                            "srcidfk",
                            "address",
                            "city",
                            "zip",
                            "country",
                            "state",
                            "industry",
                            "interest",
                            "siccode",
                            "salespersonidfk",
                            "status",
                            "created_at",
                            "updated_at"
                            ];
}
