<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;
    protected $fillable = ['task_id', 'status', 'note', 'created_by'];
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id' );
    }

     public function task(){
        return $this->belongsTo('App\Models\Task', 'task_id', 'task_id' );
    }

}
