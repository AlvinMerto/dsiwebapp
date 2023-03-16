<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sharewithtbn extends Model
{
    use HasFactory;
    protected $primaryKey = "swid";
    protected $table      = "sharewithtbns";
    protected $fillable   = [
        "groupidpk","tableid","tablefrom","sharedwith","status","inputby","created_at","updated_at"
    ];
}
