<!----------- For Project Team Leader  ----------> 
@if($ProjectRole == 1)

<div class="container-fluid">
    <div class="row">        

        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Project Details:</h4>
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{session('message')}}
                        </div>                    
                    @endif

                   
                        <div class="form-group row ">
                            <label for="inputEmail3" class="col-4 ">Project Id:</label>
                            <div class="col-8">
                                {{ $Project->project_id }}
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="inputEmail3" class="col-4 ">Title:</label>
                            <div class="col-8">
                               <p class="text-wrap"> {{ $Project->title }}  </p> 
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="designation" class="col-4">Client Name:</label>
                            <div class="col-8">
                                {{ $Project->client_name }}
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="start" class="col-4 ">Start Date:</label>
                            <div class="col-8">
                                {{ date('d/m/Y ', strtotime($Project->start_date)) }}
                                
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label for="end" class="col-4">End Date:</label>
                            <div class="col-8">
                                {{ date('d/m/Y ', strtotime($Project->end_date)) }}
                            </div>
                        </div>         
                        
                        <div class="form-group row ">
                            <label for="deadline" class="col-4">Deadline:</label>
                            <div class="col-8">
                                {{ date('d/m/Y ', strtotime($Project->deadline)) }}
                            </div>
                        </div>
                       
                        <div class="form-group row ">
                            <label for="deadline" class="col-4">Status:</label>
                            <div class="col-8">
                                {{ $Project->status }}
                            </div>
                        </div>
                        
                    <div>
                        <h4 class="mb-3 header-title">Project History:</h4>
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateProjectStatus">Update History </button>

                        <div class="col-lg-12 my-3">
                            @if(session('projectStatus'))
                                <div class="alert alert-success" role="alert">
                                    {{session('projectStatus')}}
                                </div>                    
                            @endif
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="updateProjectStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form class="form-horizontal" method="post" action="{{ url('my/projects').'/'.$project_id.'/history' }}">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update History</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">                                        
                                        @csrf
                                        <div class="form-group row mb-3">
                                            <label for="note12" class="col-2 col-form-label">Note</label>
                                            <div class="col-10">
                                                <textarea class="form-control" rows="5" id="note12" name="note" placeholder="Note" required></textarea> 
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button  type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    
                    
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100 mt-3">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Note</th>                                              
                                    <th>By</th>            
                                    <th>Date</th>            
                                    <th>Time</th>            
                                </tr>
                            </thead>
                                @foreach ($ProjectHistory as $index=>$item)
                                    <tr>
                                        <td>{{ ++$index }}</td>                                        
                                        <td>{{$item->note}}</td>                                   
                                        <td>{{$item->user->name}}</td>                                   
                                        <td>{{ date('d/m/Y ', strtotime($item->created_at)) }}</td>                                   
                                        <td>{{ date('H:i A ', strtotime($item->created_at)) }}</td>                                   
                                    </tr>
                               
                                @endforeach                    
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                        

                    </div>

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->





        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    
                    @if(session('member'))
                        <div class="alert alert-success" role="alert">
                            {{session('member')}}
                        </div>                    
                    @endif
                    

                    <h4 class="mb-3 header-title">Project Member List</h4>
                    <form class="form-horizontal" method="post" action="{{ url('project').'/'.$project_id.'/member' }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <label  class="col-3 col-form-label">Member</label>
                            <div class="col-9">
                                <select id="inputState" class="form-control" name="user_id" required>
                                    <option value="">Choose Member</option>
                                    @foreach ($UserList as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label  class="col-3 col-form-label">Project Role</label>
                            <div class="col-9">
                                    <select id="inputState" class="form-control" name="role" required>
                                        <option value="">Choose</option>
                                        <option value="2">Team Member</option>
                                    </select>
                            </div>
                        </div>  

                        <div class="form-group row mb-3">
                            <label for="description12" class="col-3 col-form-label">Details</label>
                            <div class="col-9">
                                <textarea  class="form-control" rows="7" id="description12" name="description" placeholder="Details"></textarea>
                            </div>
                        </div>


                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-info waves-effect waves-light">Add Project Member</button>
                            </div>
                        </div>

                    </form>
                   
                    <div class="form-group mt-3">
                        <input type="text" id="search" class="form-control ">                  
                    </div>
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100 mt-3">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Designation</th>            
                                <th>Details</th>            
                                <th>Action</th>            
                            </tr>
                        </thead>
                        <tbody id="table">
                            @foreach ($ProjectMember as $index=>$item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{$item->user->name}}</td>
                                    <td>{{$item->role == 1 ? 'Team Leader' : 'Team Member' }}</td>
                                    <td>{{$item->user->designation}}</td>                                   
                                    <td>{{$item->description}}</td>     
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{ url('project').'/'.$project_id.'/member/'.$item->user->id.'/tasks' }}">View</a>
                                    </td>                                                               
                                </tr>
                            @endforeach                    
                        
                            
                        </tbody>
                    </table>
                   

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->
     
        
        

    </div>
</div>

@elseif($ProjectRole == 2)
<div class="container-fluid">
    <div class="row">        

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Project Details:</h4>
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{session('message')}}
                        </div>                    
                    @endif

                   
                        <div class="form-group row ">
                            <label for="inputEmail3" class="col-4 ">Project Id:</label>
                            <div class="col-8">
                                {{ $Project->project_id }}
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="inputEmail3" class="col-4 ">Title:</label>
                            <div class="col-8">
                               <p class="text-wrap"> {{ $Project->title }}  </p> 
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="designation" class="col-4">Client Name:</label>
                            <div class="col-8">
                                {{ $Project->client_name }}
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="start" class="col-4 ">Start Date:</label>
                            <div class="col-8">
                                {{ date('d/m/Y ', strtotime($Project->start_date)) }}
                                
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label for="end" class="col-4">End Date:</label>
                            <div class="col-8">
                                {{ date('d/m/Y ', strtotime($Project->end_date)) }}
                            </div>
                        </div>         
                        
                        <div class="form-group row ">
                            <label for="deadline" class="col-4">Deadline:</label>
                            <div class="col-8">
                                {{ date('d/m/Y ', strtotime($Project->deadline)) }}
                            </div>
                        </div>
                       
                        <div class="form-group row ">
                            <label for="deadline" class="col-4">Status:</label>
                            <div class="col-8">
                                {{ $Project->status }}
                            </div>
                        </div>
                        
                    

                    

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->





        
        

    </div>

   



    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">My Ongoing Task</h4>
                    

                    @foreach ($TaskList as $index=>$item)
                    
                        <div class="card-box border ribbon-box">
                            @if($item->status == 'Assigned')
                                
                                <button type="button" class="btn waves-effect waves-light ribbon ribbon-secondary float-right"  data-toggle="modal" data-target="#con-close-modal-{{$item->task_id}}" ><i class="mdi mdi-arrow-right-drop-circle-outline mr-1"></i> Start</button>
                            @elseif($item->status == 'In Process...')
                                <button type="button" class="btn waves-effect waves-light ribbon ribbon-primary float-right"  data-toggle="modal" data-target="#con-close-modal-{{$item->task_id}}" ><i class="mdi mdi-apple-keyboard-shift mr-1"></i> Submit</button>
                            @endif
                            

                            <h5 class="text-primary float-left mt-0">{{ ++$index }}. {{ $item->title }}</h5>
                            <div class="ribbon-content row">
                                <label for="inputEmail3" class="col-4"><b>Priority:</b></label>
                                <div class="col-8 ml-n2">
                                    <span class="badge badge-danger">{{ $item->priority }}</span>
                                   
                                </div>                                
                                <label for="inputEmail3" class="col-4"><b>Submission Time:</b></label>
                                <div class="col-8 ml-n2">
                                    {{ date('h:i A', strtotime($item->submission_time)) }} 
                                </div>

                                <label for="inputEmail3" class="col-4"><b>Submission Date:</b></label>
                                <div class="col-8 ml-n2">
                                    {{ date('d/m/Y', strtotime($item->submission_date)) }} 
                                </div>

                                <label for="inputEmail3" class="col-4"><b>Project Name:</b></label>
                                <div class="col-8 ml-n2 mb-3">
                                    {{ $item->projectName }} 
                                </div>
                                                                
                            </div>

                            <div class="row">
                                    <div class="col-6">
                                        <a type="button" class="btn btn-primary mb-3 btn-block" data-toggle="modal" data-target="#exampleModal{{$index}}">
                                          Description
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-block btn-success " href="{{url('project').'/'.$item->project_id.'/member/'.$item->user_id.'/task/'.$item->task_id }}">View</a>
                                    </div>
                                    

                                    

                                </div>
                        </div>



                        {{-- Task Details Modal --}}


                        <div class="modal fade" id="exampleModal{{$index}}" tabindex="-1" role="dialog" aria-labelledby="exampleModal{{$index}}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $item->title }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                {{ $item->description }}
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>


                        <div id="con-close-modal-{{$item->task_id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                @if($item->status == 'Assigned')
                                 <form class="form-horizontal" method="post" action="{{ url('member/tasks/inprocess2') }}">
                                @elseif($item->status == 'In Process...')
                                 <form class="form-horizontal" method="post" action="{{ url('member/tasks/submit2') }}">
                                @endif
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $item->title }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body p-4">                                    
                                        @csrf

                                        <input type="hidden" name="task_id" value="{{ $item->task_id }}">

                                        <div class="form-group row mb-3">
                                            <label for="NOTE" class="col-3 col-form-label">Note</label>
                                            <div class="col-9 ml-n3">
                                                <textarea type="text" rows="4" class="form-control" id="NOTE" name="note" placeholder="Note" required></textarea>
                                            </div>
                                        </div> 
                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info waves-effect waves-light">Submit</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div><!-- /.modal -->
                    @endforeach

                    

                   

                    

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->





        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">My Submitted Task List</h4>

                    @if(session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{session('msg')}}
                        </div>                    
                    @endif
                   
                    @foreach ($Submitted as $index=>$item)
                        <div class="card-box border ribbon-box">
                            <div class="ribbon ribbon-success float-right"><i class="mdi mdi-access-point mr-1"></i> {{$item->status}}</div>
                            <h5 class="text-primary float-left mt-0">{{ ++$index }}. {{ $item->title }}</h5>
                            <div class="ribbon-content row">
                                <label for="inputEmail3" class="col-4"><b>Description:</b></label>
                                <div class="col-8 ml-n3">
                                    {{ $item->description }}
                                </div>
                                <label for="inputEmail3" class="col-4"><b>Note:</b></label>
                                <div class="col-8 ml-n3">
                                    {{ $item->taskStatus->note}}
                                </div>
                                <label for="inputEmail3" class="col-4"><b>Submission Time:</b></label>
                                <div class="col-8 ml-n3">
                                    {{ date('h:i A', strtotime($item->submission_time)) }} 
                                </div>

                                <label for="inputEmail3" class="col-4"><b>Submission Date:</b></label>
                                <div class="col-8 ml-n3">
                                    {{ date('d/m/Y', strtotime($item->submission_date)) }} 
                                </div>

                                <label for="inputEmail3" class="col-4"><b>Project Name:</b></label>
                                <div class="col-8 ml-n3">
                                    {{ $item->project->title }} 
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a type="button" class="btn btn-primary btn-sm mb-3 " data-toggle="modal" data-target="#exampleModalD{{$index}}">
                                      Description
                                    </a>                                
                                    <a class="btn btn-success btn-sm mb-3" href="{{url('project').'/'.$item->project_id.'/member/'.$item->user_id.'/task/'.$item->task_id }}">View</a>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="exampleModalD{{$index}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalD{{$index}}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $item->title }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                {{ $item->description }}
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        
                    @endforeach
                   

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->

        
        
        

    </div>
</div>
@endif



@push('scripts')
<script type="text/javascript">
    $( document ).ready(function() {
        
      var $rows = $('#table tr');
      $('#search').keyup(function() {
          var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
          
          $rows.show().filter(function() {
              var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
              return !~text.indexOf(val);
          }).hide();
});        
        
    });
</script>
@endpush