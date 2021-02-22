@if(Auth::user()->type == 2)
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{session('error')}}
                </div>                    
            @endif
        </div>
    </div>
</div>
@elseif (Auth::user()->type == 1)
<div class="container-fluid">
    <div class="row">
        

        {{-- {{ dd($Project) }} --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Project Details:</h4>
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{session('message')}}
                        </div>                    
                    @endif

                    <form class="form-horizontal" method="post" action="{{ url('projects') }}">
                        @csrf
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
                        
                    </form>


                    <div>
                        <h4 class="mb-3 header-title">Project History:</h4> 
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateProjectHistory">Update History </button>
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateProjectStatus">Update Status </button>

                        <div class="col-lg-12 my-3">
                            @if(session('projectStatus'))
                                <div class="alert alert-success" role="alert">
                                    {{session('projectStatus')}}
                                </div>                    
                            @endif
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="updateProjectHistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form class="form-horizontal" method="post" action="{{ url('project').'/'.$id.'/history' }}">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update History</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">                                        
                                        @csrf
                                        <div class="form-group row mb-3">
                                            <label for="note" class="col-3 col-form-label">Note</label>
                                            <div class="col-9">                                                
                                                <textarea class="form-control" id="note" name="note" placeholder="Note" rows="7" required></textarea>
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

                        <div class="modal fade" id="updateProjectStatus" tabindex="-1" role="dialog" aria-labelledby="updateProjectStatus" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form class="form-horizontal" method="post" action="{{ url('project').'/'.$id.'/status' }}">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">                                        
                                        @csrf
                                        <div class="form-group row mb-3">
                                            <label  class="col-3 col-form-label">Status</label>
                                            <div class="col-9">
                                                <select id="inputState" class="form-control" name="projectStatus" required>
                                                    <option >Choose Status</option>
                                                    <option value="Pre Production">Pre Production</option>
                                                    <option value="In Production">In Production</option>
                                                    <option value="Queued for Testing">Queued for Testing</option>
                                                    <option value="On Test">On Test</option>
                                                    <option value="Tested">Tested</option>
                                                    <option value="Supervised">Supervised</option>
                                                    <option value="Documented">Documented</option>
                                                    <option value="Completed">Completed</option>
                                                    <option value="Delivered">Delivered</option>
                                                    <option value="Deployed">Deployed</option>
                                                    <option value="Under Maintenance">Under Maintenance</option>
                                                    <option value="In Revision">In Revision</option>                                                    
                                                </select>
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
                                <tbody>
                                    @foreach ($ProjectHistory as $index=>$item)
                                        <tr>
                                            <td>{{ ++$index }}</td>                                        
                                            <td>{{$item->note}}</td>                                   
                                            <td>{{$item->user->name}}</td>                                   
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





        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    
                    @if(session('member'))
                        <div class="alert alert-success" role="alert">
                            {{session('member')}}
                        </div>                    
                    @endif

                    <h4 class="mb-3 header-title">Project Member List</h4>
                    <form class="form-horizontal" method="post" action="{{ url('project').'/'.$id.'/member' }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <label  class="col-3 col-form-label">Member</label>
                            <div class="col-9">
                                    <select id="inputState" class="form-control" name="user_id" required>
                                        <option value="">Choose</option>
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
                                        <option value="1">Team Leader</option>
                                    </select>
                            </div>
                        </div>  

                        <div class="form-group row mb-3">
                            <label for="description" class="col-3 col-form-label">Details</label>
                            <div class="col-9">
                                <textarea class="form-control" rows="7" id="description" name="description" placeholder="Details" required></textarea>
                            </div>
                        </div>


                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-info waves-effect waves-light">Add Project Member</button>
                            </div>
                        </div>

                    </form>

                    
                    <div class="table-responsive">
                        
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100 mt-3">
                            
                            <thead>
                                <div class="form-group">
                                    <input type="text" id="search" class="form-control mt-4 mb-n2">      
                                </div>
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
                                            <a class="btn btn-primary btn-sm" href="{{ url('project').'/'.$id.'/member/'.$item->user->id.'/tasks' }}">View</a>
                                        </td>                                                               
                                    </tr> 
                                @endforeach                    
                            
                                
                            </tbody>
                        </table>
                    </div>

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