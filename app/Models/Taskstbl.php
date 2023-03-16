<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taskstbl extends Model
{
    use HasFactory;
    protected $primaryKey = "taskid";
    protected $table      = "taskstbls";
    protected $fillable   = [
        "custid","contactid",
        "activity","reference",
        "notes","groupidfk",
        "taskdatetime","inputby",
        "status","created_at","updated_at"
    ];

}
