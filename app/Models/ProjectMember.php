<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    use HasFactory;
    
    protected $fillable = ['project_id', 'user_id', 'role', 'status', 'created_by', 'description'];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id' );
    }
    
    public function myProject(){
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id' );
    }


}