
<div class="container-fluid">
    <div class="row">        

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if($DESK_OPEN == true) 
                        <form action="{{ url('my/workday/status/action') }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="DESK_CLOSE">
                            <button type="submit" class="btn btn-danger waves-effect waves-light">
                                <span class="btn-label"><i class="mdi mdi-power"></i></span>Close Your Desk
                            </button>                            
                        </form>
                        <br>
                    @elseif ($DESK_OPEN == false)
                        @if($proceed == false)
                        @else
                            <form action="{{ url('my/workday/status/action') }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="DESK_OPEN">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <span class="btn-label"><i class="mdi mdi-check-all"></i></span>Open Your Desk
                                </button>                            
                            </form>
                            <br>
                        @endif
                        
                    @endif
                <div class="table-responsive">
                    <div class="form-group">
                        <input type="text" id="search" class="form-control ">          
                    </div>                   

                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>View</th>                                                                
                            </tr>
                        </thead>
                    
                    
                        <tbody id="table">
                            @forelse  ($myDailyWorkHour as $index => $item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ date("d/m/Y", strtotime($item->work_date) ) }}</td>                                                          
                                    <td>
                                        <a class="btn btn-primary" href="{{ url('my/workday').'/'.date('Y-m-d', strtotime($item->work_date) ).'/'.$item->id }}">View</a>
                                    </td>
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