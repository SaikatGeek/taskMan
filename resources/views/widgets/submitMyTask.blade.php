<div class="container-fluid">

    <div class="row">
        <div class="col-md-4 col-xl-4">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">Total </h4>
                <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{ count($TaskList) }}</span></h2>
                <p class="text-muted mb-0">Total Task: {{ count($TaskList) }} <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>{{ count($TaskList) }}</span></p>
            </div>
        </div>

        <div class="col-md-4 col-xl-4">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">Total Submitted </h4>
                <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{ count($Submitted) }}</span></h2>
                <p class="text-muted mb-0">Total Submitted Task: {{ count($Submitted) }} <span class="float-right"><i class="fa fa-caret-down text-danger mr-1"></i>{{ count($Submitted) }}</span></p>
            </div>
        </div>

        <div class="col-md-4 col-xl-4">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">Total Completed </h4>
                <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{ count($Completed) }}</span></h2>
                <p class="text-muted mb-0">Total Completed Task: {{ count($Completed) }} <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>{{ count($Completed) }}</span></p>
            </div>
        </div>

        <div class="col-md-6 col-xl-6">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">In Review</h4>
                <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{ $InReview }}</span></h2>
                <p class="text-muted mb-0">In Review: {{ $InReview }} <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>{{ $InReview }}</span></p>
            </div>
        </div>

        <div class="col-md-6 col-xl-6">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">Re Assigned</h4>
                <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{ $ReAssigned }}</span></h2>
                <p class="text-muted mb-0">Re Assigned: {{ $ReAssigned }} <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>{{ $ReAssigned }}</span></p>
            </div>
        </div>
        
    </div> <!-- end row -->
    
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
                                    <span class="badge 
                                    @if($item->priority == 'Low')
                                        badge-warning
                                    @elseif($item->priority == 'Medium')
                                        badge-success
                                    @else
                                        badge-danger
                                    @endif
                                     ">{{ $item->priority }}</span>
                                   
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
                                 <form class="form-horizontal" method="post" action="{{ url('member/tasks/inprocess') }}">
                                @elseif($item->status == 'In Process...')
                                 <form class="form-horizontal" method="post" action="{{ url('member/tasks/submit') }}">
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
                            <div class="ribbon-content row mb-3">
                                
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

