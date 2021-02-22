<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\User;
use App\Models\ProjectHistory;
use App\Models\ProjectMember;
use App\Models\ReAssignTask;
use App\Models\TaskStatus;
use App\Models\Notification;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DB;

class ProjectController extends Controller
{

    public function __construct()
    {
        
        $this->middleware('auth')->except('logout');
        
    }

    public function dashboard(){
        $auth = Auth::user();
        if($auth->type == 1){
            $TotalProject = Projects::all();
            $TotalCompletedProject = Projects::where('status', 'Completed')->count();
            $TotalTask = Task::all();
            $TotalAcceptedTask = Task::where('status', 'Accepted')->count();
            foreach($TotalProject as $index=>$item){
                $item->totalMember = $item->projectMember->count();
                $item->totalTask = $item->projectTask->count();
            }

            return view('welcome', compact('TotalProject', 'TotalCompletedProject', 'TotalTask', 'TotalAcceptedTask'));
        }
        else{
            $myTotalProject = $auth->memberProject->unique('project_id');
            $TotalProject = [];
            foreach($myTotalProject as $index=>$item ){
                $TotalProject[$index] = Projects::find($item->project_id);
            }
            // dd($TotalProject);
            $MyCompletedProject = $auth->memberProject;
            $TotalCompletedProject = 0;
            foreach($MyCompletedProject as $item){
                $project = Projects::find($item->project_id);
                if($project->status === 'Completed'){
                    ++ $TotalCompletedProject ;
                }
            }
            $TotalTask = Task::where('user_id', $auth->id)->get();
            $TotalAcceptedTask = Task::where('user_id', $auth->id)->where('status', 'Accepted')->count();
            foreach($TotalProject as $index=>$item){
                $item->totalMember = ProjectMember::where('project_id', $item->id)->count();
                $item->totalTask = Task::where('user_id', $auth->id)->count();
                
            }

            return view('welcome', compact('TotalProject', 'TotalCompletedProject', 'TotalTask', 'TotalAcceptedTask'));
        }
        
    }
    
    public function addProject(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $Projects = new Projects;        
        $Projects->title = $request->title;
        $Projects->client_name = $request->client_name;
        $Projects->start_date = $request->start_date;
        $Projects->end_date = $request->end_date;
        $Projects->deadline = $request->deadline;
        $Projects->status = 'Opened';        
        $Projects->created_by = Auth::id();        
        
        $Projects->save();
        $Projects->project_id = mt_rand(99, 999).$Projects->id;        

        $imageName = "P-{$Projects->id}.{$request->image->extension()}";  
        $request->image->move(public_path('images/project'), $imageName);

        $Projects->image = 'images/project/'.$imageName;
        
        

        if($Projects->save())
        {
            $ProjectHistory = new ProjectHistory;
            $ProjectHistory->project_id = $Projects->id;
            $ProjectHistory->note = 'Project Opened';
            $ProjectHistory->created_by = Auth::id();
            $ProjectHistory->save();


            $reference = '/projects';
            $Admins = User::where('type', 1)->get();

            foreach ($Admins as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has created a new project called <b>'. $request->title . '</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->id, 'PROJECT_ADD');                
            }
            

        }
      
        return redirect()->back()->with('message', 'New Project Created Successfully!');
    }

    public function projectPage(){
        $ProjectList = Projects::orderBy('id', 'desc')->get();
        return view('projects', compact('ProjectList'));
    }

    public function projectDetails($id){
        
        if(auth()->user()->type == 1){
            $Project = Projects::find($id);          
            $UserList = User::where('type', '2')->where('status', '1')->get();
            $ProjectMember = ProjectMember::where('project_id', $id)->where('status', '1')->get();
            $ProjectHistory = ProjectHistory::where('project_id', $id)->orderBy('created_at', 'desc')->get();

            return view('projectDescribe', compact('Project', 'UserList', 'ProjectMember', 'id', 'ProjectHistory'));
        }
        else{
            return view('projectDescribe')->with('error', 'Please Avoid this type of action!');
        }
    }

    public function submitProjectHistoryStatus ($project_id, Request $request) {
        // dd($request->all());
        $ProjectHistory = new ProjectHistory;
        $ProjectHistory->note = $request->note;
        $ProjectHistory->project_id = $project_id;
        $ProjectHistory->created_by = Auth::id();
        $ProjectHistory->save();

        return redirect('/project/details/'.$project_id)->with('projectStatus', 'New Project Status Added Successfully!');
    }

    public function addProjectMember ($project_id, Request $request){ 
        // dd($request->role);
        
        $UserId = Auth::id();
        $ProjectMember = new ProjectMember;
        $ProjectMember->project_id = $project_id;
        $ProjectMember->user_id = $request->user_id;
        $ProjectMember->role = $request->role;
        $ProjectMember->description = $request->description;
        $ProjectMember->status = 1;
        $ProjectMember->created_by = $UserId; 

        if($ProjectMember->save())
        {
            $User = User::find($request->user_id);
            $role = $request->role == 1 ? " Team Leader":" Team Member"; 
            $ProjectHistory = new ProjectHistory;
            $ProjectHistory->project_id = $project_id;
            $ProjectHistory->note = $User->name." has been assigned as". $role ;
            $ProjectHistory->created_by = $UserId;
            $ProjectHistory->save();

            $role = $request->role == 1 ? 'Team Leader' : 'Team Member';
            $details = '<b>'.Auth::user()->name.'</b> has assigned you as <b>'. $role. '</b> in the project <b>'.$ProjectMember->myProject->title.'</b>.';
            $reference = '/my/projects/'.$project_id.'/details';

            Helper::notify($details, $reference, Auth::id(), $request->user_id, 'PROJECT_MEMBER_ADD');

        }


        return redirect()->back()->with('member', 'New Project Member Added Successfully!');

    }

    public function memberTaskPage ($project_id, $member_id){
        $Project = Projects::find($project_id);
        
        if(Auth::user()->type == 1){
            $User = User::find($member_id);
            $userRole = Auth::user()->type;
            $projectRole = null;
            $ProjectMember = ProjectMember::where('project_id', $project_id)->where('user_id', $member_id)->first();            
        }else{
            $User = User::find($member_id);
            $userRole = User::find($member_id)->type;
            $projectRole = Auth::user()->projectMember->role;
            $ProjectMember = ProjectMember::where('project_id', $project_id)->where('user_id', $member_id)->first();            
        }
        
        $Task = Task::where('project_id', $project_id)->where('user_id', $member_id)->orderBy('submission_time', 'asc')->get();

        return view('memberTaskProfile', compact('userRole', 'projectRole', 'Project', 'User', 'ProjectMember', 'project_id', 'member_id', 'Task' ));     

    }

    public function addMemberTask ($project_id, $member_id, Request $request){

        $Task = new Task;
        $Task->project_id = $project_id;
        $Task->user_id = $member_id;
        $Task->title = $request->title;
        $Task->description = $request->description;
        $Task->submission_date = $request->submission_date;
        $Task->submission_time =  $request->submission_time;
        $Task->status = 'Assigned';
        $Task->revision_type = 'Original';
        $Task->task_type = $request->task_type;
        $Task->priority = $request->priority;
        $Task->testable = 'No';
        $Task->created_by = Auth::id();
        $Task->satisfaction_level = 0;
        $Task->save();
        $Task->task_id = mt_rand(101, 999).$Task->id;

        if($Task->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->task_id = $Task->task_id ;
            $TaskStatus->status = 'Assigned';
            $TaskStatus->note = 'Task has been assigned';
            $TaskStatus->created_by = Auth::id();
            $TaskStatus->save(); 

            $details = '<b>'.Auth::user()->name.'</b> has assigned you in a new task called <b>'. $request->title . '</b> in the project <b>'.$Task->project->title.'</b>.';
            $reference = '/project/'.$project_id.'/member/'.$member_id.'/task/'. $Task->task_id;

            Helper::notify($details, $reference, Auth::id(), $member_id, 'TASK_ADD');
        }


        return redirect('/project/'.$project_id.'/member/'.$member_id.'/tasks')->with('task', 'New Task Added Successfully!');
    }

    public function memberSingleTaskPage ($project_id, $member_id, $taskId){
        $Task = Task::where('task_id', $taskId)->first();

        $TaskStatus = TaskStatus::where('task_id', $taskId)->orderBy('created_at', 'desc')->get();
        $OwnTask = Task::where('user_id', Auth::id())->where('task_id', $taskId)->first();
        $ReAssignedTask = ReAssignTask::where('revised_id', $Task->id)->first();
        $own = false;
        if($OwnTask == null){
        }
        else{
            if($Task->task_id == $OwnTask->task_id){
                $own = true;
            }
        }

        return view('memberSingleTaskPage', compact('Task', 'project_id', 'member_id', 'taskId', 'TaskStatus', 'own', 'ReAssignedTask'));
    }
    
    public function submitSingleTaskStatus ($project_id, $member_id, $taskId, Request $request){
        
        $TaskStatus = new TaskStatus;
        $TaskStatus->task_id = $taskId;
        $TaskStatus->status = $request->status;
        $TaskStatus->note = $request->note;
        $TaskStatus->created_by = Auth::id();
        $TaskStatus->save();

        $Task = Task::where('task_id', $taskId)->first();        
        $Task->status = $request->status;        
        $Task->save();

        if($TaskStatus->status == 'Re Assigned')
        {
            $currentTask = Task::where('task_id', $taskId)->first();
            $Task = new Task;
            $Task->project_id = $project_id;
            $Task->user_id = $member_id;
            $Task->title = $currentTask->title." - Re Assigned";
            $Task->description = $currentTask->description;
            $Task->submission_date = $request->submission_date;
            $Task->submission_time =  $request->submission_time;
            $Task->status = 'Assigned';
            $Task->revision_type = 'Revised';
            $Task->task_type = $currentTask->task_type;
            $Task->priority = 'High';
            $Task->testable = 'No';
            $Task->created_by = Auth::id();
            $Task->satisfaction_level = 0;
            $Task->save();
            $Task->task_id = mt_rand(101, 999).$Task->id;

            if($Task->save()){
                $TaskStatus = new TaskStatus;
                $TaskStatus->task_id = $Task->task_id ;
                $TaskStatus->status = 'Assigned';
                $TaskStatus->note = 'Task has been assigned';
                $TaskStatus->created_by = Auth::id();
                $TaskStatus->save(); 
            }

            $ReAssignRow = ReAssignTask::where('last_id', $currentTask->id);
            $ReAssignNumRow = $ReAssignRow->count();
            
            if($ReAssignNumRow == 0){
                $ReAssignTask = new ReAssignTask();
                $ReAssignTask->orginal_id = $currentTask->id;
                $ReAssignTask->last_id = $currentTask->id;
                $ReAssignTask->revised_id = $Task->id;
                $ReAssignTask->created_by = Auth::id();
                $ReAssignTask->save();
            }else{
                $ReAssignTask = new ReAssignTask();
                $ReAssignTask->orginal_id = $ReAssignRow->first()->orginal_id;
                $ReAssignTask->last_id = $ReAssignRow->first()->revised_id;
                $ReAssignTask->revised_id = $Task->id;
                $ReAssignTask->created_by = Auth::id();
                $ReAssignTask->save();
            }

            $date = date('d/m/Y', strtotime($Task->submission_date));
            $time = date('h:i A', strtotime($Task->submission_time));
            $details = 'Your task <b>' .$currentTask->title. '</b> has been <b><i>'. $request->status .'</i></b> by <b>'. Auth::user()->name.'</b> in <b>'.$date.'</b> at <b>'.$time.'</b>.';
            $reference = '/project/'.$project_id.'/member/'.$member_id.'/task/'. $Task->task_id;
            Helper::notify($details, $reference, Auth::id(), $member_id, 'TASK_REASSIGNED');

        }
        else{
            $details = 'Your task <b>' .$Task->title. '</b> has been <b><i>'. $request->status .'</i></b> by <b>'. Auth::user()->name.'</b>.';
            $reference = '/project/'.$project_id.'/member/'.$member_id.'/task/'. $taskId;
            Helper::notify($details, $reference, Auth::id(), $member_id, 'TASK_STATUS_UPDATE');
        }


        return redirect('/project/'.$project_id.'/member/'.$member_id.'/task/'.$taskId)->with('taskStatus', 'New Task Status Added Successfully!');
    }


    public function myTaskPage(){

        $id = Auth::id();

        $TaskList = DB::select(DB::raw("select * from tasks where user_id='$id' and (status='Assigned' or status = 'In Process...') ORDER BY submission_date ASC, submission_time ASC "));

        foreach($TaskList as $item){
            $item->projectName = Projects::find($item->project_id)->title;
        }

        $Submitted = Task::where('user_id', $id)->where('status', 'Submitted')->get();
        $Completed = Task::where('user_id', $id)->where('status', 'Accepted')->get();
        $InReview = Task::where('user_id', $id)->where('status', 'In Review')->count();
        $ReAssigned = Task::where('user_id', $id)->where('status', 'Re Assigned')->count();
        
        return view('myTaskPage', compact('TaskList', 'Submitted', 'Completed', 'InReview', 'ReAssigned'));
    }  

    public function myAcceptedTaskPage(){
        $auth = Auth::user();
        $id = $auth->id;

        if($auth->type ==1){
            $TaskList = Task::where('status', 'Accepted')->get();
        }
        else{
            $TaskList = Task::where('user_id', $id)->where('status', 'Accepted')->get();
        }        
        
        
        return view('myAcceptedTaskPage', compact('TaskList'));
    }  
    
    
    public function myTaskSubmit(Request $request){

        $id = Auth::id();
        $TaskSubmmit = Task::where('task_id', $request->task_id)->first();
        $TaskSubmmit->status = 'Submitted';
        if($TaskSubmmit->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->note = $request->note;
            $TaskStatus->task_id = $request->task_id;
            $TaskStatus->status = 'Submitted';
            $TaskStatus->created_by = $id;
            $TaskStatus->save();

            $reference = '/project/'.$TaskSubmmit->project->id.'/member/'.Auth::id().'/task/'. $TaskSubmmit->task_id;
            $Admins = User::where('type', 1)->get();
            $TL = ProjectMember::where('project_id', $TaskSubmmit->project->id)->where('role', 1)->get();

            foreach ($Admins as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>submitted</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$TaskSubmmit->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->id, 'TASK_SUBMIT');                
            }

            foreach ($TL as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>submitted</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$TaskSubmmit->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->user_id, 'TASK_SUBMIT');                
            }
        }       
        
        return redirect('/member/tasks')->with('msg', 'Task Submitted Successfully!');
    }

    public function myTaskSubmit2(Request $request){

        $id = Auth::id();
        $TaskSubmmit = Task::where('task_id', $request->task_id)->first();
        $TaskSubmmit->status = 'Submitted';
        if($TaskSubmmit->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->note = $request->note;
            $TaskStatus->task_id = $request->task_id;
            $TaskStatus->status = 'Submitted';
            $TaskStatus->created_by = $id;
            $TaskStatus->save();

            $reference = '/project/'.$TaskSubmmit->project->id.'/member/'.Auth::id().'/task/'. $TaskSubmmit->task_id;
            $Admins = User::where('type', 1)->get();
            $TL = ProjectMember::where('project_id', $TaskSubmmit->project->id)->where('role', 1)->get();

            foreach ($Admins as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>submitted</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$TaskSubmmit->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->id, 'TASK_SUBMIT');                
            }

            foreach ($TL as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>submitted</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$TaskSubmmit->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->user_id, 'TASK_SUBMIT');                
            }
        }       
        
        return redirect('/my/projects/'.$TaskSubmmit->project_id.'/details')->with('msg', 'Task Submitted Successfully!');
    }

    public function myTaskInProcess(Request $request){

        $id = Auth::id();
        $TaskSubmmit = Task::where('task_id', $request->task_id)->first();
        $TaskSubmmit->status = 'In Process...';
        if($TaskSubmmit->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->note = $request->note;
            $TaskStatus->task_id = $request->task_id;
            $TaskStatus->status = 'In Process...';
            $TaskStatus->created_by = $id;
            $TaskStatus->save();

            
            $reference = '/project/'.$TaskSubmmit->project->id.'/member/'.Auth::id().'/task/'. $TaskSubmmit->task_id;
            $Admins = User::where('type', 1)->get();
            $TL = ProjectMember::where('project_id', $TaskSubmmit->project->id)->where('role', 1)->get();

            foreach ($Admins as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>started</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$TaskSubmmit->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->id, 'TASK_START');                
            }

            foreach ($TL as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>started</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$TaskSubmmit->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->user_id, 'TASK_START');                
            }

        }       
        
        return redirect('/member/tasks')->with('msg', 'Task In Processing Successfully!');
    }

    public function myTaskInProcess2(Request $request){

        $id = Auth::id();
        $TaskSubmmit = Task::where('task_id', $request->task_id)->first();
        $TaskSubmmit->status = 'In Process...';
        if($TaskSubmmit->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->note = $request->note;
            $TaskStatus->task_id = $request->task_id;
            $TaskStatus->status = 'In Process...';
            $TaskStatus->created_by = $id;
            $TaskStatus->save();

            $reference = '/project/'.$TaskSubmmit->project->id.'/member/'.Auth::id().'/task/'. $TaskSubmmit->task_id;
            $Admins = User::where('type', 1)->get();
            $TL = ProjectMember::where('project_id', $TaskSubmmit->project->id)->where('role', 1)->get();

            foreach ($Admins as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>started</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$TaskSubmmit->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->id, 'TASK_START');                
            }

            foreach ($TL as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>started</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$TaskSubmmit->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->user_id, 'TASK_START');                
            }

        }       
        
        return redirect('/my/projects/'.$TaskSubmmit->project_id.'/details')->with('msg', 'Task In Processing Successfully!');
    }

    public function mySingleProjectTaskSubmit(Request $request){

        $id = Auth::id();
        $TaskSubmmit = Task::where('task_id', $request->task_id)->first();
        $TaskSubmmit->status = 'Submitted';
        if($TaskSubmmit->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->note = $request->note;
            $TaskStatus->task_id = $request->task_id;
            $TaskStatus->status = 'Submitted';
            $TaskStatus->created_by = $id;
            $TaskStatus->save();
        }       
        
        return redirect("my/projects/{$TaskSubmmit->project_id}/details")->with('msg', 'Task Submitted Successfully!');
    }


    
    public function submitSingleTaskSatisfaction ($project_id, $member_id, $taskId, Request $request){

        $id = Auth::id();        
        $Task = Task::where('project_id', $project_id)->where('user_id', $member_id)->where('task_id', $taskId)->first();        
        $Task->satisfaction_level = $request->satisfaction_level;
        $Task->created_by = $id;
        $Task->save();

        if($Task->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->note = 'Satisfaction level has been updated with the mark of '. $request->satisfaction_level;
            $TaskStatus->task_id = $taskId;
            $TaskStatus->status = 'Supervised';
            $TaskStatus->created_by = $id;
            $TaskStatus->save();
            $details = 'Your task <b>' .$Task->title. '</b> has been <b><i>supervised</i></b> by <b>'. Auth::user()->name.'</b> with the satisfaction level of <b>' .$request->satisfaction_level. '</b>.';
            $reference = '/project/'.$project_id.'/member/'.$member_id.'/task/'. $taskId;
            Helper::notify($details, $reference, Auth::id(), $member_id, $request->satisfaction_level);
        }
        return redirect()->back()->with('message', 'New Satisfaction Level Inserted Successfully!');
    }

    public function myProjectListPage(){
        $id = Auth::id();

        $myProjectList = ProjectMember::where('user_id', $id)->get();

        return view('myProjectListPage', compact('myProjectList'));
    }

    public function myProjectDetailsPage($project_id){
        $id = Auth::id();
        $Project = Projects::find($project_id);          
        $UserList = User::where('type', '2')->where('status', '1')->get();
        $ProjectMember = ProjectMember::where('project_id', $project_id)->where('status', '1')->get();
        $ProjectRole = ProjectMember::where('project_id', $project_id)->where('user_id', Auth::id())->where('status', '1')->first()->role;
        $ProjectHistory = ProjectHistory::where('project_id', $project_id)->orderBy('created_at', 'desc')->get();

        $TaskList = DB::select(DB::raw("select * from tasks where user_id='$id' and (status='Assigned' or status = 'In Process...') ORDER BY submission_time, submission_date ASC"));
        foreach($TaskList as $item){
            $item->projectName = Projects::find($item->project_id)->title;
        }

        $Submitted = Task::where('user_id',  $id )->where('project_id', $project_id)->where('status', 'Submitted')->get();

       
        return view('myProjectDetailsPage', compact('ProjectRole', 'Project', 'UserList', 'project_id', 'ProjectMember', 'ProjectHistory', 'TaskList', 'Submitted'));
    }

    public function submitMyProjectHistory($project_id, Request $request){

        $ProjectHistory = new ProjectHistory;
        $ProjectHistory->note = $request->note;
        $ProjectHistory->project_id = $project_id;
        $ProjectHistory->created_by = Auth::id();
        $ProjectHistory->save();

        return redirect('my/projects'.'/'.$project_id.'/details')->with('projectStatus', 'New Project Status Added Successfully!');
    }

    public function globalTaskAssign(Request $request){
        if($request->isMethod('get')){
            $ProjectList = Projects::orderBy('title', 'ASC')->get();
            return view('globalTaskAssign', compact('ProjectList'));
        }
        else{

        }
    }

    public function projectMemberList( $project_id, Request $request){
        $ProjectMember = ProjectMember::where('project_id', $project_id)->get();
        
        foreach($ProjectMember as $index=>$item){
            $item->name = $item->user->name;            
            $item->role = ($item->role == 1) ? 'Team Leader':'Team Member';            
        }
        
        return response()->json([
            'data' => $ProjectMember,            
        ]);
    }

    public function ajaxAddMemberTask ($project_id, $member_id, Request $request){
        $Task = new Task;
        $Task->project_id = $project_id;
        $Task->user_id = $member_id;
        $Task->title = $request->title;
        $Task->description = $request->description;
        $Task->submission_date = $request->submission_date;
        $Task->submission_time =  $request->submission_time;
        $Task->status = 'Assigned';
        $Task->revision_type = 'Original';
        $Task->task_type = $request->task_type;
        $Task->priority = $request->priority;
        $Task->testable = 'No';
        $Task->created_by = Auth::id();
        $Task->satisfaction_level = 0;
        $Task->save();
        $Task->task_id = mt_rand(101, 999).$Task->id;

        if($Task->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->task_id = $Task->task_id ;
            $TaskStatus->status = 'Assigned';
            $TaskStatus->note = 'Task has been assigned';
            $TaskStatus->created_by = Auth::id();
            $TaskStatus->save(); 

            $details = '<b>'.Auth::user()->name.'</b> has assigned you in a new task called <b>'. $request->title . '</b> in the project <b>'.$Task->project->title.'</b>.';
            $reference = '/project/'.$project_id.'/member/'.$member_id.'/task/'. $Task->task_id;

            Helper::notify($details, $reference, Auth::id(), $member_id, 'TASK_ADD');
        }

        

        return response()->json([
            'status' => "New Task Added Successfully!",            
        ]);
    }

    public function ajaxTaskList(){
        $TaskList = Task::orderBy('created_at', 'desc')->get();
        
        foreach($TaskList as $index=>$item){
            $item->submission_date = date('d/m/Y', strtotime($item->submission_date));            
            $item->submission_time = date('h:i A', strtotime($item->submission_time));            
            $item->member_id = $item->user_id;
            $item->from = $item->user->name;
            $item->to = $item->developer->name;
            $item->project_name = $item->project->title;
        }

        return response()->json([
            'TaskList' => $TaskList            
        ]);
    }

    public function todayTasks(){
        $TaskList = Task::where('submission_date', Carbon::now()->toDateString())->orderBy('submission_time', 'asc')->get();
        // dd(Carbon::now()->toDateString());
        
        foreach($TaskList as $index=>$item){
            $item->submission_date = date('d/m/Y', strtotime($item->submission_date));            
            $item->submission_time = date('h:i A', strtotime($item->submission_time));            
            $item->member_id = $item->user_id;
            $item->from = $item->user->name;
            $item->to = $item->developer->name;
            $item->project_name = $item->project->title;
        }

        return view('todayTasks', compact('TaskList'));
    }

    public function ongoingTask(){
        // $TaskList = Task::where('status', 'Submitted')->get();
        $TaskList = TaskStatus::where('status', '!=', 'Assigned')
                    ->Where('status', '!=', 'Re Assigned')
                    ->Where('status', '!=', 'Completed')
                    ->Where('status', '!=', 'Supervised')
                    ->Where('status', '!=', 'Accepted')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->unique('task_id');

        return view('ongoingTask', compact('TaskList'));
    }

    public function myPreviousTask(){
        $TaskList = Task::where('user_id', Auth::id())->where([
                        ['status', '!=', 'Assigned'],
                        ['status', '!=', 'In Process...']                       
                    ])->orderBy('updated_at', 'desc')->get();

        return view('myPreviousTask', compact('TaskList'));
    }

    public function completedProjectList(){
        $ProjectList = Projects::where('status', 'Completed')->get();

        return view('completedProjectListPage', compact('ProjectList'));
    }

    public function submitProjectStatus($project_id, Request $request){
        $Project = Projects::find($project_id);
        $Project->status = $request->projectStatus;

        if($Project->save()){
            $ProjectHistory = new ProjectHistory;
            $ProjectHistory->note = "Project is ".$request->projectStatus;
            $ProjectHistory->project_id = $project_id;
            $ProjectHistory->created_by = Auth::id();
            $ProjectHistory->save();
        }

        
        return back()->with('projectStatus', 'New Project Status Added Successfully!');
    }

    public function taskResubmit($task_id, Request $request){
        $Task = Task::find($task_id);
        $Task->status = "Resubmitted";
        if($Task->save()){
            $TaskStatus = new TaskStatus;
            $TaskStatus->task_id = $Task->task_id;
            $TaskStatus->note = $request->note;
            $TaskStatus->status = "Resubmitted";
            $TaskStatus->created_by = Auth::id();
            $TaskStatus->save();


            $reference = '/project/'.$Task->project->id.'/member/'.Auth::id().'/task/'. $Task->task_id;
            $Admins = User::where('type', 1)->get();
            $TL = ProjectMember::where('project_id', $Task->project->id)->where('role', 1)->get();

            foreach ($Admins as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>resubmitted</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$Task->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->id, 'TASK_RESUBMIT');                
            }

            foreach ($TL as $key => $value) {
                $details = '<b>'.Auth::user()->name.'</b> has <b><i>resubmitted</i></b> the task called <b>'. $TaskStatus->task->title . '</b> in the project <b>'.$Task->project->title.'</b>.';
                Helper::notify($details, $reference, Auth::id(), $value->user_id, 'TASK_RESUBMIT');                
            }


        }

        return back()->with('taskStatus', 'Task Status Added Successfully!');
    }

    public function ajaxTotalNotifications(){
        if(!empty(Auth::id())){
            $TotalNotification = Notification::where('notified_to', Auth::id())->where('read_status', 0)->count();
        }else{
            $TotalNotification = null;
        }

        return response()->json([
            'TotalNotification' => $TotalNotification            
        ]);
    }

    public function readNotifications(){
        $NotificationList = Notification::where('notified_to', Auth::id())->where('read_status', 1)->orderBy('id', 'DESC')->get();
        return view('readNotifications', compact('NotificationList'));
    }

    public function unreadNotifications(){
        $NotificationList = Notification::where('notified_to', Auth::id())->where('read_status', 0)->orderBy('id', 'DESC')->get();
        return view('unreadNotifications', compact('NotificationList'));
    }

    public function ajaxMakeNotificationRead(){
        if(!empty(Auth::id())){
            $NotificationUpdate = Notification::where('notified_to', Auth::id())->where('read_status', 0)->update(['read_status' => 1, 'read_at' => Carbon::now()]);
        }

        return response()->json(['status'=>true]);
    }




}
