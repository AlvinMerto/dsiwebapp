<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowedUser extends Model
{
    use HasFactory;

    protected $table        = "allowed_users";
    protected $primaryKey   = "auid";
    protected $fillable     = [
        "table","idfk",
        "idfld","alloweduser",
        "inputby","status",
        "created_at","updated_at"
    ];
}
