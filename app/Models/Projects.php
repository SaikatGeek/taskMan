<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'title', 'client_name', 'start_date', 'end_date', 'status', 'deadline', 'created_by', 'image'];

    public function projectMember(){
        return $this->hasMany('App\Models\ProjectMember', 'project_id', 'id' );
    }

    public function projectTask(){
        return $this->hasMany('App\Models\Task', 'project_id', 'id' );
    }
}
