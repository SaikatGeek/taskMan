
<div class="container-fluid">
    <div class="row">
        

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">  


                <div class="table-responsive">
                    <div class="form-group">
                        <input type="text" id="search" class="form-control ">          
                    </div>                   

                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Time</th>
                                <th>Activity</th>
                                <th>Note</th>
                                                                
                            </tr>
                        </thead>
                    
                    
                        <tbody id="table">
                            @forelse($List as $index => $item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ date("h:i A", strtotime($item->action_time) ) }}</td>
                                    <td><span class="btn 
                                            @if($item->status == 'ON_DESK')
                                                btn-success
                                            @elseif($item->status == 'OFF_DESK')
                                                btn-danger
                                            @elseif($item->status == 'DESK_OPEN')
                                                btn-primary
                                            @elseif($item->status == 'DESK_CLOSE')
                                                btn-black
                                            @endif
                                        ">                                            
                                            {{ $item->status }}
                                        </span></td>
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