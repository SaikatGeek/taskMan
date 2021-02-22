<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center">
                <img src="{{ asset($Task->project->image) }}" class="rounded-circle avatar-lg img-thumbnail"
                    alt="profile-image">

                <h4 class="mb-0">{{ $Task->project->title }}</h4>
                <p class="text-muted">{{ $Task->project->client_name }}</p>

                <div class="text-left mt-3">
                    <h4 class="text-muted mb-2 font-13"><strong>Title :</strong> <span class="ml-2"> {{ $Task->title }} </span></h4>

                    <p class="text-muted font-13 mb-3">
                        <strong>Description :</strong><span class="ml-2">
                        {{ $Task->description }}
                    </p>
                    

                    <p class="text-muted mb-2 font-13"><strong>Submission Date :</strong><span class="ml-2">{{ date('d/m/Y ', strtotime($Task->submission_date)) }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Submission Time :</strong> <span class="ml-2 ">{{ date('h:i A ', strtotime($Task->submission_time)) }}</span></p>

                    <p class="text-muted mb-1 font-13"><strong>Status :</strong> <span class="ml-2">{{ $Task->status }}</span></p>
                    <p class="text-muted mb-1 font-13"><strong>Revision Type :</strong> <span class="ml-2">{{ $Task->revision_type }}</span></p>
                    <p class="text-muted mb-1 font-13"><strong>Priority :</strong> <span class="ml-2">{{ $Task->priority }}</span></p>
                    <p class="text-muted mb-1 font-13"><strong>Testable :</strong> <span class="ml-2">{{ $Task->testable }}</span></p>
                    <p class="text-muted mb-1 font-13"><strong>Assigned To :</strong> <span class="ml-2">{{ $Task->developer->name }}</span></p>
                    <p class="text-muted mb-1 font-13"><strong>Created By :</strong> <span class="ml-2">{{ $Task->user->name }}</span></p>
                    <p class="text-muted mb-1 font-13"><strong>Satisfaction Level :</strong> <span class="ml-2 badge badge-success">{{ $Task->satisfaction_level }}</span></p>
                    <br>
                    @if(Auth::user()->type == 2)
                    <div class="form-group">
                        <a href="{{ url('member/tasks') }}" class="btn btn-block btn-lg btn-primary">Go To Task Panel</a>
                    </div>
                    @endif
                </div>
            </div> <!-- end card-box -->
        </div>
        
        <div class="col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-body">  

                    <div>
                        <h4 class="mb-3 header-title">Task Status:</h4>         
                        
                        @if($own)
                        @else
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateStatus">Update Status</button>

                        @endif
                        

                        @if(Auth::user()->type == 1)
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateSatisfaction">Satisfaction Level</button>
                            <!-- Modal -->
                            <div class="modal fade" id="updateSatisfaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form class="form-horizontal" method="post" action="{{ url('project').'/'.$project_id.'/member/'.$member_id.'/task/'.$taskId.'/satisfaction' }}">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update Satisfaction Level</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">                                            
                                            @csrf 
                                            <div class="form-group row mb-3">
                                                <label for="sdate" class="col-3 col-form-label">Satisfaction Level</label>
                                                <div class="col-9">
                                                    <select id="satisfaction_level" class="form-control" name="satisfaction_level" required>
                                                        <option value="">Choose Level</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                </div>
                                            </div> 
                                            
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button  type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-lg-12 my-3">
                            @if(session('taskStatus'))
                                <div class="alert alert-success" role="alert">
                                    {{session('taskStatus')}}
                                </div>                    
                            @endif
                        </div>

                        <div class="col-lg-12 my-3">
                            @if(session('message'))
                                <div class="alert alert-success" role="alert">
                                    {{session('message')}}
                                </div>                    
                            @endif
                        </div>

                        

                        <!-- Modal -->
                        <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form class="form-horizontal" method="post" action="{{ url('project').'/'.$project_id.'/member/'.$member_id.'/task/'.$taskId.'/status' }}">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        @csrf
                                        <div class="form-group row mb-3">
                                            <label for="note" class="col-3 col-form-label">Note</label>
                                            <div class="col-9">
                                                <textarea class="form-control" id="note" name="note" placeholder="Note" required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="sdate" class="col-3 col-form-label">Status</label>
                                            <div class="col-9">
                                                <select id="inputState" class="form-control" name="status" required>
                                                    <option value="">Choose Status</option>
                                                    <option value="Submitted">Submitted</option>
                                                    <option value="In Revision">In Revision</option>
                                                    <option value="Revision Needed">Revision Needed</option>
                                                    <option value="Re Assigned">Re Assigned</option>
                                                    <option value="Tested">Tested</option>
                                                    <option value="Completed">Completed</option>
                                                    <option value="Accepted">Accepted</option>
                                                   
                                                </select>
                                            </div>
                                        </div> 

                                        

                                        <div class="form-group row mb-3 dateTime">
                                            <label for="sdate" class="col-3 col-form-label">Submission Date</label>
                                            <div class="col-9">
                                                <input type="date" class="form-control" name="submission_date" id="sdate" >
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3 dateTime">
                                            <label for="sdate" class="col-3 col-form-label">Submission Time</label>
                                            <div class="col-9">
                                                <input type="time" class="form-control" name="submission_time" id="sdate" >
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button  type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100 mt-3">
                                @if($Task->status == "Submitted" || $Task->status == "In Revision" || $Task->status == "Revision Needed" || $Task->status == "Tested" || $Task->status == "Supervised" || $Task->status == "Resubmitted")
                                    <thead>
                                        <form method="post" action="{{ url('/task/resubmit').'/'.$Task->id }}">
                                            @csrf
                                            <tr>
                                                <th></th> 
                                                <th>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="note" placeholder="Note" required>
                                                    </div>
                                                </th>                                           
                                                <th></th>                                              
                                                <th></th>            
                                                <th></th>            
                                                <th>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Resubmit</button>
                                                    </div>
                                                </th>            
                                            </tr>
                                        </form>
                                    </thead>
                                @endif

                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Note</th>                                              
                                        <th>Status</th>                                              
                                        <th>By</th>            
                                        <th>Date</th>            
                                        <th>Time</th>            
                                    </tr>
                                </thead>
                                            
                                <tbody>

                                    @foreach ($TaskStatus as $index=>$item)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $item->note }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ date('d/m/Y ', strtotime($item->created_at)) }}</td>
                                            <td>{{ date('h:i A ', strtotime($item->created_at)) }}</td>
                                        </tr>                                        
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>  
                        

                    </div>

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->

    @if($ReAssignedTask != null)
    <div class="col-lg-4 col-xl-4">
      <div class="card-box text-left">

        
          <p class="text-muted mb-2 font-13"><strong>Revised Task Of :</strong> <span class="ml-2"> {{ $ReAssignedTask->lastTask->title }} </span></p>
          <p class="text-muted mb-2 font-13"><strong>Task ID :</strong> <span class="ml-2"> {{ $ReAssignedTask->lastTask->task_id }} </span></p>
          <p class="text-muted mb-2 font-13"><strong>Details :</strong> <span class="ml-2"> {{ Str::limit($ReAssignedTask->revisedTask->description, 5) }} </span></p>
          <p class="text-muted mb-2 font-13"><strong>Submission Date :</strong> <span class="ml-2"> {{ date("d/m/Y", strtotime($ReAssignedTask->lastTask->submission_date)) }} </span></p>
          <p class="text-muted mb-2 font-13"><strong>Submission Time :</strong> <span class="ml-2"> {{ date("h:i A", strtotime($ReAssignedTask->lastTask->submission_time)) }} </span></p>
          
          <p class="text-muted mb-2 font-13">
            <a class="btn btn-primary btn-block" href="{{ url('project').'/'.$ReAssignedTask->lastTask->project_id.'/member/'.$ReAssignedTask->lastTask->user_id.'/task/'.$ReAssignedTask->lastTask->task_id }}" >View</a>

          </p>
           
        


          
      </div> <!-- end card-box -->
       
    </div>
    @endif
        
        
        

    </div>
</div>



@push('scripts')
<script type="text/javascript">
    $( document ).ready(function() {



        
        $('.dateTime').hide();

        $('#inputState').on("change",function(){
            if($(this).val() == 'Re Assigned'){
                $('.dateTime').show();
            }else{
                $('.dateTime').hide();

            }
        });

                
        
    });
</script>
@endpush





