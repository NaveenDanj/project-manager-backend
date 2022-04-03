<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkSpace extends Model
{
    use HasFactory;
    protected $table = 'user_work_spaces';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'work_space_id',
    ];

}
