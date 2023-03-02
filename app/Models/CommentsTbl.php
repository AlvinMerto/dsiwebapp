<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsTbl extends Model
{
    use HasFactory;

    protected $table        = "comments_tbls";
    protected $primaryKey   = "comid";
    protected $fillable     = [
        "quoteidfk","quoteitemidfk",
        "thecomment","inputby",
        "status","created_at","updated_at"
    ];
}
