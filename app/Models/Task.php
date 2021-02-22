<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = ['project_id', 'user_id', 'task_id', 'title', 'description', 'submission_date', 'submission_time', 'status', 'revision_type', 'priority', 'testable', 'created_by', 'satisfaction_level'];
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id' );
    }

    public function project(){
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id' );
    }

    public function taskStatus(){
        return $this->hasOne('App\Models\TaskStatus', 'task_id', 'task_id' )->latest();
    }

    public function developer(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id' );
    }

  


}
