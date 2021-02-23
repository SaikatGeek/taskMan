
<div class="container-fluid">
    <div class="row">
        

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                @if( $date == date('Y-m-d') )
                  <div class="row">
                    @if($DESK_OPEN == true)
                        @if($Activity->status == 'OFF_DESK')
                            <div class="col-4">                                

                                <form class="form-inline" action="{{ url('my/workday/status/action') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="ON_DESK">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mt-n2">
                                        <span class="btn-label"><i class="mdi mdi-briefcase-download-outline"></i></span>ON DESK
                                    </button>
                                  
                                    <div class="form-group mx-sm-3 mb-2">
                                      <label for="note22" class="sr-only">Note</label>
                                      <input type="text" class="form-control" id="note22" name="note" placeholder="Note"  required>
                                    </div>
                                    
                                </form>

                                <br><br>

                            </div>
                            <div class="col-4"></div>

                            <div class="col-4">
                                <form action="{{ url('my/workday/status/action') }}" method="POST" >
                                    @csrf
                                    <input type="hidden" name="status" value="DESK_CLOSE">
                                    <button type="submit" class="btn btn-danger waves-effect waves-light float-right">
                                        <span class="btn-label"><i class="mdi mdi-power"></i></span>Close Your Desk
                                    </button>
                                    <br><br>
                                
                                </form>
                            </div>
                            
                            <br>


                        @elseif($Activity->status == 'ON_DESK')

                            <div class="col-4">
                                <form class="form-inline" action="{{ url('my/workday/status/action') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="OFF_DESK">
                                    <button type="submit" class="btn btn-dark waves-effect waves-light mt-n2">
                                      <span class="btn-label"><i class="mdi mdi-briefcase-upload-outline"></i></span>OFF DESK
                                    </button>
                                    <div class="form-group mx-sm-3 mb-2">
                                      <label for="note22" class="sr-only">Note</label>
                                      <input type="text" class="form-control" id="note22" name="note" placeholder="Note"  required>
                                    </div>
                                    
                                  
                                </form>

                                <br><br>
                            </div>
                            <div class="col-4"></div>

                            <div class="col-4">
                                <form action="{{ url('my/workday/status/action') }}" method="POST" >
                                    @csrf
                                    <input type="hidden" name="status" value="DESK_CLOSE">
                                    <button type="submit" class="btn btn-danger waves-effect waves-light float-right">
                                        <span class="btn-label"><i class="mdi mdi-power"></i></span>Close Your Desk
                                    </button>
                                    <br><br>
                                
                                </form>
                            </div>
                            
                            <br>

                        @elseif($Activity->status == 'DESK_OPEN')

                            <div class="col-4">

                                <form class="form-inline" action="{{ url('my/workday/status/action') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="status" value="OFF_DESK">
                                  <button type="submit" class="btn btn-dark waves-effect waves-light mt-n2">
                                    <span class="btn-label"><i class="mdi mdi-briefcase-upload-outline"></i></span>OFF DESK
                                  </button>
                                  <div class="form-group mx-sm-3 mb-2">
                                    <label for="note22" class="sr-only">Note</label>
                                    <input type="text" class="form-control" id="note22" name="note" placeholder="Note"  required>
                                  </div>
                                  

                                </form>

                                <br><br>

                                
                            </div>
                            <div class="col-4"></div>

                            <div class="col-4">
                                <form action="{{ url('my/workday/status/action') }}" method="POST" >
                                    @csrf
                                    <input type="hidden" name="status" value="DESK_CLOSE">
                                    <button type="submit" class="btn btn-danger waves-effect waves-light float-right">
                                        <span class="btn-label"><i class="mdi mdi-power"></i></span>Close Your Desk
                                    </button>
                                    <br><br>
                                
                                </form>
                            </div>
                            
                            <br>

                        @endif


                    @else
                        
                        <div class="col-4"></div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <form action="{{ url('my/workday/status/action') }}" method="POST" >
                                @csrf
                                <input type="hidden" name="status" value="DESK_CLOSE">
                                <button type="submit" class="btn btn-danger waves-effect waves-light float-right">
                                    <span class="btn-label"><i class="mdi mdi-power"></i></span>Close Your Desk
                                </button>
                                <br><br>
                            
                            </form>
                        </div>
                        
                        <br>

                    @endif

                </div>

                @endif

                



                <div class="table-responsive">
                    <div class="form-group">
                        <input type="text" id="search" class="form-control ">          
                    </div>                   

                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Time</th>
                                <th width="10%">Activity</th>
                                <th></th>
                                <th>Note</th>                 
                            </tr>
                        </thead>
                    
                    
                        <tbody id="table">
                            @forelse($myWorkDayDetails as $index => $item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ date("h:i A", strtotime($item->action_time) ) }}</td>                                                         
                                    <td>
                                        <span class="btn btn-sm btn-block
                                            @if($item->status == 'ON_DESK')
                                                btn-success
                                            @elseif($item->status == 'OFF_DESK')
                                                btn-warning
                                            @elseif($item->status == 'DESK_OPEN')
                                                btn-primary
                                            @elseif($item->status == 'DESK_CLOSE')
                                                btn-dark
                                            @endif
                                        ">                                            
                                            @if($item->status == 'ON_DESK')
                                                ON
                                            @elseif($item->status == 'OFF_DESK')
                                                PAUSE
                                            @elseif($item->status == 'DESK_OPEN')
                                                OPENED
                                            @elseif($item->status == 'DESK_CLOSE')
                                                CLOSED
                                            @endif
                                        </span>
                                        
                                    </td>
                                    <td></td>
                                    <td>{{ $item->note }}</td>
                                    
                                </tr>

                            @empty
                                <p class="bg-danger text-white p-1">No Data</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                   

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->

        
        
        

    </div>
</div>

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