<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyEmployeeActivityDetail extends Model
{
  use HasFactory;
  protected $table = 'daily_employee_activity_details';
	protected $fillable = ['id', 'employee_activity_id', 'action_time', 'status', 'note', 'user_agent', 'user_ip', 'created_by', 'created_at', 'updated_at'];
	
}
