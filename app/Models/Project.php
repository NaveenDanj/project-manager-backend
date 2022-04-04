<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_name',
        'description',
        'work_space_id'
    ];

    // project belongs to workspace
    public function workspace()
    {
        return $this->belongsTo(WorkSpace::class, 'workspace_id');
    }



}
