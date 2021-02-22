<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::any('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::any('/register', [App\Http\Controllers\Auth\LoginController::class, 'register']);
// Route::get('/404', function(){
//   return view('404');
// });

Route::group(['middleware' => ['auth']], function () { 
   
  Route::get('/', [App\Http\Controllers\ProjectController::class, 'dashboard']);
  Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
  Route::any('/password/change', [App\Http\Controllers\UserController::class, 'passwordChange']);
  Route::post('/users', [App\Http\Controllers\UserController::class, 'addUser']);
  Route::get('/users', [App\Http\Controllers\UserController::class, 'UserPage']);
  Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'addProject']);
  Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'projectPage']);
  Route::get('/project/details/{id}', [App\Http\Controllers\ProjectController::class, 'projectDetails']);
  Route::post('/project/{project_id}/member', [App\Http\Controllers\ProjectController::class, 'addProjectMember']);
  Route::get('/project/{project_id}/member/{member_id}/tasks', [App\Http\Controllers\ProjectController::class, 'memberTaskPage']);
  Route::post('/project/{project_id}/member/{member_id}/tasks', [App\Http\Controllers\ProjectController::class, 'addMemberTask']);
  Route::get('/project/{project_id}/member/{member_id}/task/{taskId}', [App\Http\Controllers\ProjectController::class, 'memberSingleTaskPage']);
  Route::post('/project/{project_id}/member/{member_id}/task/{taskId}/status', [App\Http\Controllers\ProjectController::class, 'submitSingleTaskStatus']);
  Route::post('/project/{project_id}/member/{member_id}/task/{taskId}/satisfaction', [App\Http\Controllers\ProjectController::class, 'submitSingleTaskSatisfaction']);
  Route::post('/project/{project_id}/history', [App\Http\Controllers\ProjectController::class, 'submitProjectHistoryStatus']);
  Route::post('/project/{project_id}/status', [App\Http\Controllers\ProjectController::class, 'submitProjectStatus']);
  Route::get('/member/accepted/tasks', [App\Http\Controllers\ProjectController::class, 'myAcceptedTaskPage']);
  Route::get('/member/tasks', [App\Http\Controllers\ProjectController::class, 'myTaskPage']);
  Route::get('/my/previous/tasks', [App\Http\Controllers\ProjectController::class, 'myPreviousTask']);
  Route::post('member/tasks/submit', [App\Http\Controllers\ProjectController::class, 'myTaskSubmit']);
  Route::post('member/tasks/submit2', [App\Http\Controllers\ProjectController::class, 'myTaskSubmit2']);
  Route::post('member/tasks/inprocess', [App\Http\Controllers\ProjectController::class, 'myTaskInProcess']);
  Route::post('member/tasks/inprocess2', [App\Http\Controllers\ProjectController::class, 'myTaskInProcess2']);
  Route::post('member/single/project/tasks/submit', [App\Http\Controllers\ProjectController::class, 'mySingleProjectTaskSubmit']);
  Route::get('my/projects/list', [App\Http\Controllers\ProjectController::class, 'myProjectListPage']);
  Route::get('my/projects/{project_id}/details', [App\Http\Controllers\ProjectController::class, 'myProjectDetailsPage']);
  Route::post('my/projects/{project_id}/history', [App\Http\Controllers\ProjectController::class, 'submitMyProjectHistory']);
  Route::any('global/task/assign', [App\Http\Controllers\ProjectController::class, 'globalTaskAssign']);

  Route::post('ajax/project/member/{project_id}', [App\Http\Controllers\ProjectController::class, 'projectMemberList']);
  Route::post('ajax/project/{project_id}/member/{member_id}/tasks', [App\Http\Controllers\ProjectController::class, 'ajaxAddMemberTask']);
  Route::get('ajax/task/list', [App\Http\Controllers\ProjectController::class, 'ajaxTaskList']);
  Route::get('ajax/notifications/total', [App\Http\Controllers\ProjectController::class, 'ajaxTotalNotifications']);


  // TASK ROUTE
  Route::get('today/tasks', [App\Http\Controllers\ProjectController::class, 'todayTasks']);
  Route::get('ongoing/tasks', [App\Http\Controllers\ProjectController::class, 'ongoingTask']);
  Route::get('total/completed/project', [App\Http\Controllers\ProjectController::class, 'completedProjectList']);
  Route::post('task/resubmit/{task_id}', [App\Http\Controllers\ProjectController::class, 'taskResubmit']);
  
  Route::get('notifications/read', [App\Http\Controllers\ProjectController::class, 'readNotifications']);
  Route::get('notifications/unread', [App\Http\Controllers\ProjectController::class, 'unreadNotifications']);
  Route::post('ajax/notifications/make/read', [App\Http\Controllers\ProjectController::class, 'ajaxMakeNotificationRead']);
  Route::get('ajax/employee/workday/list', [App\Http\Controllers\EmployeeActivityController::class, 'ajaxEmployeeWorkdayList']);
  
  Route::get('about', [App\Http\Controllers\HomeController::class, 'about']);




  // CHAT
  Route::get('chats/thread', [App\Http\Controllers\ChatController::class, 'myChat']);
  Route::get('contacts', [App\Http\Controllers\ChatController::class, 'contacts']);

  //DESK TIME
  Route::get('my/workdays', [App\Http\Controllers\EmployeeActivityController::class, 'myWorkDays']);
  Route::get('my/workday/{date}/{activity_id}', [App\Http\Controllers\EmployeeActivityController::class, 'myWorkDayDetails']);
  Route::get('employee/workday/list', [App\Http\Controllers\EmployeeActivityController::class, 'employeeWorkDayList']);
  Route::get('employee/single/workday/{workday_id}', [App\Http\Controllers\EmployeeActivityController::class, 'employeeSingleWorkdayDetails']);

  Route::post('my/workday/status/action', [App\Http\Controllers\EmployeeActivityController::class, 'myWorkDayStatus']);
        
});




