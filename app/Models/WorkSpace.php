<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'description',
    ];


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_work_spaces');
    }

    // workspace hase many projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}
