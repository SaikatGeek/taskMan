<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyEmployeeActivityDetail;
use App\Models\DailyEmployeeActivity;
use App\Models\Notification;
use App\Models\User;
use App\Http\Controllers\Helper;
use Auth;
use Carbon\Carbon;

class EmployeeActivityController extends Controller
{
    
	public function __newActivity($info){

		$newRow = new DailyEmployeeActivityDetail;
	  $newRow->employee_activity_id = $info['employeeActivityId'];
	  $newRow->action_time = $info['actionTime'];
	  $newRow->status = $info['status'];
	  $newRow->note = $info['note'];
	  $newRow->user_agent = $info['userAgent'];
	  $newRow->user_ip = $info['userIp'];
	  $newRow->created_by = $info['createdBy'];
	  $User = User::where('id', $newRow->created_by)->first();

	  if($newRow->save()){
	  	if($info['status'] == "DESK_OPEN"){
	  		$details = $User->name." has opended their desk at " . date('h:i A', strtotime($newRow->action_time))." with IP: " . $newRow->user_ip.".";
	  		$reference = "/employee/workday/list";
	  		$entity = "DESK_OPEN";
	  	}elseif ($info['status'] == "DESK_CLOSE") {
	  		$details = $User->name." has closed their desk at " . date('h:i A', strtotime($newRow->action_time))." with IP: " . $newRow->user_ip.".";
	  		$reference = "/employee/workday/list";
	  		$entity = "DESK_CLOSE";
	  	}elseif ($info['status'] == "ON_DESK") {
	  		$details = $User->name." has joined at their work at " . date('h:i A', strtotime($newRow->action_time))." with IP: " . $newRow->user_ip.".";
	  		$reference = "/employee/workday/list";
	  		$entity = "ON_DESK";
	  	}elseif ($info['status'] == "OFF_DESK") {
	  		$details = $User->name." has taken a break at " . date('h:i A', strtotime($newRow->action_time))." with IP: " . $newRow->user_ip.".";
	  		$reference = "/employee/workday/list";
	  		$entity = "OFF_DESK";
	  	}

	  	$Admins = User::where('type', 1)->get();

      foreach ($Admins as $key => $value) {          
         Helper::notify($details, $reference, $newRow->created_by, $value->id, $entity);               
      }

	  	

	  }

	  return $newRow;

	}

	function __statusExists($info){
		if (isset($info['date']) ) {
			$rowExists = DailyEmployeeActivityDetail::where('created_by', Auth::id())->whereDate('created_at', date('Y-m-d'))->exists();
		}
	}

	function myWorkDayStatus(Request $request){
		

		$info =[];
		$UserId = Auth::id();
			
		if($request->status == 'DESK_OPEN'){
			$proceed = true;
			$rowExists = DailyEmployeeActivity::where('created_by', Auth::id())->whereDate('work_date', Carbon::today())->exists();

			if($rowExists ){
				$proceed = false;
			}

			if ($proceed == true) {
				
				$new = new DailyEmployeeActivity;
				$new->work_date = date('Y-m-d H:i:s');
				$new->user_agent = $request->header('User-Agent');
				$new->user_ip = $request->ip();
				$new->created_by = $UserId;
				$new->save();

				$info['employeeActivityId'] = $new->id;
				$info['actionTime'] = date('H:i:s');
				$info['status'] = $request->status;
				$info['note'] = 'DESK OPENED.';
				$info['userAgent'] = $request->header('User-Agent');
				$info['userIp'] = $request->ip();
				$info['createdBy'] = $UserId;

				$this->__newActivity($info);

				$info['employeeActivityId'] = $new->id;
				$info['actionTime'] = date('H:i:s');
				$info['status'] = 'ON_DESK';
				$info['note'] = 'Started Working Immidiately After Opening Desk.';
				$info['userAgent'] = $request->header('User-Agent');
				$info['userIp'] = $request->ip();
				$info['createdBy'] = $UserId;

				$this->__newActivity($info);

			}

		}
		elseif ($request->status == 'DESK_CLOSE') {
			$proceed = true;
			$employeeActivityId = DailyEmployeeActivity::where('created_by', Auth::id())->whereDate('work_date', Carbon::today())->first()->id;
			if ($proceed == true) {
				$info['employeeActivityId'] = $employeeActivityId;
				$info['actionTime'] = date('H:i:s');
				$info['status'] = $request->status;
				$info['note'] =  'DESK CLOSED';
				$info['userAgent'] = $request->header('User-Agent');
				$info['userIp'] = $request->ip();
				$info['createdBy'] = $UserId;

				$this->__newActivity($info);
			}
		}
		elseif ($request->status == 'OFF_DESK') {
			$proceed = true;
			$employeeActivityId = DailyEmployeeActivity::where('created_by', Auth::id())->whereDate('work_date', Carbon::today())->first()->id;
			if ($proceed == true) {
				$info['employeeActivityId'] = $employeeActivityId;
				$info['actionTime'] = date('H:i:s');
				$info['status'] = $request->status;
				$info['note'] = $request->note;
				$info['userAgent'] = $request->header('User-Agent');
				$info['userIp'] = $request->ip();
				$info['createdBy'] = $UserId;

				$this->__newActivity($info);
			}
		}
		elseif ($request->status == 'ON_DESK') {

			$proceed = true;
			$employeeActivityId = DailyEmployeeActivity::where('created_by', Auth::id())->whereDate('work_date', Carbon::today())->first()->id;
			if ($proceed == true) {
				$info['employeeActivityId'] = $employeeActivityId;
				$info['actionTime'] = date('H:i:s');
				$info['status'] = $request->status;
				$info['note'] = $request->note;
				$info['userAgent'] = $request->header('User-Agent');
				$info['userIp'] = $request->ip();
				$info['createdBy'] = $UserId;

				$this->__newActivity($info);
			}
		}

		return back();
		

	}

	public function myWorkDays(){
		$List = DailyEmployeeActivity::where('created_by', Auth::id())->orderBy('id', 'desc');
		$DESK_OPEN = false;
		$Activity = DailyEmployeeActivityDetail::where('created_by', Auth::id())->orderBy('id', 'desc')->limit(1)->first();

		if($Activity != null){
			if($Activity->status == 'DESK_OPEN' ){
				$DESK_OPEN = true;
			}
			else if($Activity->status == 'ON_DESK'){
				$DESK_OPEN = true;
			}
			else if($Activity->status == 'OFF_DESK'){
				$DESK_OPEN = true;
			}
		}

		$myDailyWorkHour = $List->get();
		$proceed = true;

		if($List->exists()){
			$proceed = false;
		}	


		

		return view('myDailyWorkHour', compact('myDailyWorkHour', 'DESK_OPEN', 'proceed'));
	}

	public function myWorkDayDetails($date, $activity_id){
		$data = DailyEmployeeActivityDetail::where('employee_activity_id', $activity_id)->where('created_by', Auth::id());
		$myWorkDayDetails = $data->orderBy('id', 'desc')->get();
		$Activity = DailyEmployeeActivityDetail::where('employee_activity_id', $activity_id)->where('created_by', Auth::id())->orderBy('id', 'desc')->limit(1)->first();
		$status = DailyEmployeeActivity::where('created_by', Auth::id())->whereDate('work_date', Carbon::today())->count();
		$DESK_OPEN = false;

		if($status == 1 ){
			$DESK_OPEN = true;
		}

		return view('myDailyDetails', compact('myWorkDayDetails', 'DESK_OPEN', 'Activity'));
	}

	public function employeeWorkDayList(){

		return view('employeeWorkDayList');

	}

	public function ajaxEmployeeWorkdayList(){
		$DailyEmployeeActivity = DailyEmployeeActivity::orderBy('id', 'desc')->get();
		$List = [];

		foreach ($DailyEmployeeActivity as $key => $value) {

			$value->date = date('d/m/Y', strtotime($value->work_date));
			$value->time = date('h:i A', strtotime($value->activityDetails->action_time));
			$value->status = DailyEmployeeActivityDetail::where('employee_activity_id', $value->id)->orderBy('id', 'desc')->limit(1)->first()->status;
			$value->note = DailyEmployeeActivityDetail::where('employee_activity_id', $value->id)->orderBy('id', 'desc')->limit(1)->first()->note;
			$value->name = $value->user->name;
			$value->designation = $value->user->designation;
			$List[$key] = $value;
		}

		return response()->json($List);
	}

	public function employeeSingleWorkdayDetails($workday_id){
		$List = DailyEmployeeActivityDetail::where('employee_activity_id', $workday_id)->orderBy('id', 'desc')->get();

		return view('employeeSingleWorkdayDetails', compact('List'));
	}






}
