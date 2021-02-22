<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReAssignTask extends Model
{
    use HasFactory;
    protected $fillable = ['orginal_id', 'last_id', 'revised_id', 'created_by'];

    public function lastTask(){
        return $this->belongsTo('App\Models\Task', 'last_id', 'id' );
	}

	public function revisedTask(){
        return $this->belongsTo('App\Models\Task', 'revised_id', 'id' );
	}
}


