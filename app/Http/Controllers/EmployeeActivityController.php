<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyEmployeeActivityDetail;
use App\Models\DailyEmployeeActivity;
use App\Models\Notification;
use App\Models\User;
use App\Http\Controllers\Helper;
use Auth;
use DB;
use Carbon\Carbon;
use DateTime;

class EmployeeActivityController extends Controller
{

	public function productiveTime($activity_id){
		$day = DailyEmployeeActivityDetail::where('employee_activity_id', $activity_id)->get();		
		$ondesk = [];
		$offdesk = [];
		$productiveTime = [];
		$time = [];
		foreach($day as $index=>$value){

			if($value->status == 'DESK_OPEN'){
				$deskOpen = $value->action_time;
			}
			elseif($value->status == 'DESK_CLOSE'){
				$deskClose = $value->action_time;
			}			
			// elseif ($value->status == 'ON_DESK'){
			// 	$ondesk[$index] = $value->action_time;
			// 	$ondeskLastKey = $index;
			// }
			// elseif ($value->status == 'OFF_DESK'){
			// 	$offdesk[$index] = $value->action_time;
			// 	$offdeskLastKey = $index;
			// }
			else{
				$time[$index] =  $value->action_time;
			}
		}

		$p = 0;

		foreach($time as $index => $value ){
			dump($value);
		}
		



		dd($deskOpen,  $time );   

	}

	public function __productiveTime($activity_id){
		$day = DailyEmployeeActivityDetail::where('employee_activity_id', $activity_id)->get();

		foreach($day as $value){
			if($value->status == 'ON_DESK'){
				$deskOpen = $value->action_time;
			}
			elseif($value->status == 'OFF_DESK'){
				$deskClose = $value->action_time;
			}			
		}


		// dd($deskOpen, $deskClose);

	}
    
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
	  		$details = $User->name." has opended their desk at <b>" . date('h:i A', strtotime($newRow->action_time))."</b> with IP: <b>" . $newRow->user_ip."</b>.";
	  		$reference = "/employee/workday/list";
	  		$entity = "DESK_OPEN";
	  	}elseif ($info['status'] == "DESK_CLOSE") {
	  		$details = $User->name." has closed their desk at <b>" . date('h:i A', strtotime($newRow->action_time))."</b> with IP: <b>" . $newRow->user_ip."</b>.";
	  		$reference = "/employee/workday/list";
	  		$entity = "DESK_CLOSE";
	  	}elseif ($info['status'] == "ON_DESK") {
	  		$details = $User->name." has joined at their work at <b>" . date('h:i A', strtotime($newRow->action_time))."</b> with IP: <b>" . $newRow->user_ip."</b>.";
	  		$reference = "/employee/workday/list";
	  		$entity = "ON_DESK";
	  	}elseif ($info['status'] == "OFF_DESK") {
	  		$details = $User->name." has taken a break at <b>" . date('h:i A', strtotime($newRow->action_time))."</b> with IP: <b>" . $newRow->user_ip."</b>.";
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
				$info['note'] = 'The Desk Is Open, Working Hours Have Started!';
				$info['userAgent'] = $request->header('User-Agent');
				$info['userIp'] = $request->ip();
				$info['createdBy'] = $UserId;

				$this->__newActivity($info);

			}

		}
		elseif ($request->status == 'DESK_CLOSE') {
			$proceed = true;
			$employeeActivityId = DailyEmployeeActivity::where('created_by', Auth::id())->whereDate('work_date', Carbon::today())->first()->id;
			$lastStatus = DailyEmployeeActivityDetail::where('employee_activity_id', $employeeActivityId)
										->orderBy('id', 'desc')
										->limit(1)->first()->status;


			// $employeeActivityId = DailyEmployeeActivity::where('created_by', Auth::id())->whereDate('work_date', Carbon::today())->first();
			// dd($employeeActivityId);
			if ($proceed == true) {
				if($lastStatus == 'OFF_DESK'){				

					$info['employeeActivityId'] = $employeeActivityId;
					$info['actionTime'] = date('H:i:s');
					$info['status'] = $request->status;
					$info['note'] =  'DESK CLOSED';
					$info['userAgent'] = $request->header('User-Agent');
					$info['userIp'] = $request->ip();
					$info['createdBy'] = $UserId;

					$this->__newActivity($info);
				}else{
					$info['employeeActivityId'] = $employeeActivityId;
					$info['actionTime'] = date('H:i:s');
					$info['status'] = 'OFF_DESK';
					$info['note'] = 'The Desk Is Closed, Working Hours Have Ended!';
					$info['userAgent'] = $request->header('User-Agent');
					$info['userIp'] = $request->ip();
					$info['createdBy'] = $UserId;

					$this->__newActivity($info);

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
		$DailyActivityList = DailyEmployeeActivity::where('created_by', Auth::id());
		$List = $DailyActivityList->orderBy('id', 'desc');
		$DESK_OPEN = '';
		$Today = $DailyActivityList->whereDate('work_date', Carbon::today())->count();
		$Activity = DailyEmployeeActivityDetail::where('created_by', Auth::id())->orderBy('id', 'desc')->whereDate('created_at', date('Y-m-d'))->limit(1)->first();
		$CLOSED = false;
		$proceed = '';


		if($Activity != null){
			if($Activity->status == 'DESK_OPEN' ){
				$DESK_OPEN = 'DESK_OPEN';
			}
			else if($Activity->status == 'ON_DESK'){
				$DESK_OPEN = 'ON_DESK';
			}
			else if($Activity->status == 'OFF_DESK'){
				$DESK_OPEN = 'OFF_DESK';
			}else{
				$proceed = 'DESK_CLOSE';
				$DESK_OPEN = 'DESK_CLOSE';
			}
		}

		

		$myDailyWorkHour = DailyEmployeeActivity::where('created_by', Auth::id())->orderBy('id', 'desc')->get();
		


		

		return view('myDailyWorkHour', compact('myDailyWorkHour', 'DESK_OPEN', 'proceed', 'CLOSED', 'Today'));
	}

	public function myWorkDayDetails($date, $activity_id){
		$data = DailyEmployeeActivityDetail::where('employee_activity_id', $activity_id)->where('created_by', Auth::id());
		$myWorkDayDetails = $data->orderBy('id', 'desc')->get();
		$Activity = DailyEmployeeActivityDetail::where('employee_activity_id', $activity_id)->where('created_by', Auth::id())->orderBy('id', 'desc')->limit(1)->first();
		
		$status = DailyEmployeeActivity::where('created_by', Auth::id())->whereDate('work_date', Carbon::today())->count();

		// $ProductiveTime = $this->__productiveTime($activity_id);

		$DESK_OPEN = false;

		if($status == 1 ){
			$DESK_OPEN = true;
		}

		return view('myDailyDetails', compact('myWorkDayDetails', 'DESK_OPEN', 'Activity', 'date'));
	}

	public function employeeWorkDateList(){
		$List = DailyEmployeeActivity::orderBy('id', 'desc')->get('work_date')->groupBy(function ($val) {
        return Carbon::parse($val->work_date)->format('Y-m-d');
    });
		
		return view('employeeWorkDateList', compact('List'));
	}

	public function ajaxEmployeeWorkdayList($work_date){
		$DailyEmployeeActivity = DailyEmployeeActivity::whereDate('work_date', $work_date)->orderBy('id', 'desc')->get();
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
		$User = DailyEmployeeActivity::find($workday_id);

		return view('employeeSingleWorkdayDetails', compact('List', 'User'));
	}

	public function employeeDailyHourList($work_date){
		// $List = DailyEmployeeActivity::whereDate('work_date', $work_date)->orderBy('id', 'desc')->get();

		return view('employeeWorkDayList', compact('work_date'));
	}

	public function realtimeWorkday(){
			return view('realtimeWorkday');
	}
	
	public function ajaxEmployeeWorkdayDailyList(){
		$DailyEmployeeActivity = DailyEmployeeActivity::whereDate('work_date', Carbon::today())->orderBy('id', 'desc')->get();

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






}
