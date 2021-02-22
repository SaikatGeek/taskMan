<div class="container-fluid">
    <div class="row">

    @if( (($projectRole == 1) && ($userRole == 2)) || $userRole == 1 )
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    
                    <div class="widget-rounded-circle card-box mt-n2">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar-lg ">
                                    <img src="{{ asset($User->image) }}" class="img-fluid rounded-circle" alt="user-img" />
                                </div>
                            </div>
                            <div class="col">
                                <h5 class="mb-1">{{ $User->name }}</h5>
                                <p class="mb-1 text-muted">{{ $Project->title }}</p>
                                <span class="badge badge-primary">{{ $ProjectMember->role == 1 ? 'Team Lead': 'Team Member' }} </span>
                                <span class="badge badge-success">{{ $User->designation }}</span>                                
                            </div>
                        </div> <!-- end row-->
                    </div> <!-- end widget-rounded-circle-->
                    

                    <h4 class="mb-3 header-title">Add Task</h4>                    

                    @if(session('task'))
                        <div class="alert alert-success" role="alert">
                            {{session('task')}}
                        </div>                    
                    @endif

                    <form class="form-horizontal" method="post" action="{{ url('project').'/'.$project_id.'/member/'.$member_id.'/tasks' }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="inputEmail3" class="col-3 col-form-label">Title</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="inputEmail3" name="title" placeholder="Title" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="designation" class="col-3 col-form-label">Description</label>
                            <div class="col-9">
                                <textarea type="text" class="form-control" rows="4"  name="description"  placeholder="Description" required></textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="sdate" class="col-3 col-form-label">Submission Date</label>
                            <div class="col-9">
                                <input type="date" class="form-control" name="submission_date" id="sdate" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="sdate" class="col-3 col-form-label">Submission Time</label>
                            <div class="col-9">
                                <input type="time" class="form-control" name="submission_time" id="sdate" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                          <label for="task_type" class="col-3 col-form-label">Task Type</label>
                          <div class="col-9">
                              <select id="task_type" class="form-control" name="task_type" required>
                                <option value="">Choose Type</option>
                                <option value="Task">Task</option>
                                <option value="Test">Test</option>
                              </select>
                          </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="sdate" class="col-3 col-form-label">Priority</label>
                            <div class="col-9">
                                <select id="inputState" class="form-control" name="priority" required>
                                    <option value="">Choose Priority</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>  


                       
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-info waves-effect waves-light">Add Task</button>
                            </div>
                        </div>
                    </form>

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->
    




        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Task List</h4>
                   
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Sub Date</th>
                                    <th>Sub Time</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Task Type</th>
                                    <th>Priority</th>
                                    <th>Testable</th>
                                    <th>By</th>
                                    <th>Satisfaction</th>
                                    @if(Auth::user()->type == 2)
                                      <th>Action</th>   
                                    @endif                             
                                </tr>
                            </thead>
                        
                        
                            <tbody>
                            @foreach ($Task as $index=>$item)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $item->task_id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->submission_date }}</td>
                                <td>{{ date('h:i A', strtotime( $item->submission_time )) }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->revision_type }}</td>
                                <td>{{ $item->task_type }}</td>
                                <td>{{ $item->priority }}</td>
                                <td>{{ $item->testable }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->satisfaction_level == 0 ? 'N/A': $item->satisfaction_level  }}</td>
                                @if(Auth::user()->type == 2)
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{ url('project').'/'.$project_id.'/member/'.$member_id.'/task/'.$item->task_id }}">View</a>
                                    </td>  
                                @endif
                            </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                   

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->
@endif
        
    @if($projectRole == 2)
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Task List</h4>
                   
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Sub Date</th>
                                    <th>Sub Time</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Task Type</th>
                                    <th>Priority</th>
                                    <th>Testable</th>
                                    <th>By</th>
                                    <th>Satisfaction</th>
                                    <th>Action</th>                                
                                </tr>
                            </thead>
                        
                        
                            <tbody>
                            @foreach ($Task as $index=>$item)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $item->task_id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->submission_date }}</td>
                                <td>{{ date('h:i A', strtotime( $item->submission_time )) }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->revision_type }}</td>
                                <td>{{ $item->task_type }}</td>
                                <td>{{ $item->priority }}</td>
                                <td>{{ $item->testable }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->satisfaction_level == 0 ? 'N/A': $item->satisfaction_level  }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ url('project').'/'.$project_id.'/member/'.$member_id.'/task/'.$item->task_id }}">View</a>
                                </td>  
                            </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                   

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div> 
    @endif
        
        

    </div>
</div>

