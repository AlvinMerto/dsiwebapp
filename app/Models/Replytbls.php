<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replytbls extends Model
{
    use HasFactory;
    protected $table      = "replytbls";
    protected $primaryKey = "replyid";
    protected $fillable   = [
        "taskid","custid",
        "groupidfk","thereply",
        "inputby","status", 
        "created_at", "updated_at"
    ];
}
