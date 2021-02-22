<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyEmployeeActivity extends Model
{
  use HasFactory;

  protected $table = 'daily_employee_activities';
	protected $fillable = ['id', 'work_date', 'user_agent', 'user_ip', 'created_by', 'created_at', 'updated_at'];

	public function user(){
     return $this->belongsTo('App\Models\User', 'created_by', 'id' );
  }

  public function activityDetails(){
     return $this->belongsTo('App\Models\DailyEmployeeActivityDetail', 'id', 'employee_activity_id' );
  }

	
}
