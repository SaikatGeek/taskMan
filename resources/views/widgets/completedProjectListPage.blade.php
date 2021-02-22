<div class="row">
  <div class="col-sm-12">
    <div class="card-box">
      <h4 class="header-title">Completed Project</h4>

      <div class="form-group">
        <input type="text" id="search" class="form-control ">
      
      </div>
    <div class="table-responsive">
      <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th >SL</th>
              <th >Project Id</th>
              <th >Title</th>
              <th >Client</th>
              <th >Deadline</th>
              <th >Started Date</th>
              <th >Ending Date</th>
              <th >Ended Date</th>              
              <th >View</th>
            </tr>
          </thead>

          <tbody id="table" >
            @foreach($ProjectList as $index => $item)
              <tr>                      
                <td>{{ ++$index }}</td>
                <td>{{ $item->project_id }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->client_name }}</td>
                <td>{{ date("d/m/Y", strtotime($item->deadline)) }}</td>
                <td>{{ date("d/m/Y", strtotime($item->start_date)) }}</td>
                <td>{{ date("d/m/Y", strtotime($item->end_date)) }}</td>
                <td>{{ date("d/m/Y", strtotime($item->updated_at)) }}</td>                
                <td><a class="btn btn-primary btn-sm" href="{{ url('project/details').'/'.$item->id }}" >View</a></td>
              </tr>
            @endforeach
          
         
          </tbody>
      </table>
    </div>
    </div> <!-- end card-box-->
  </div> <!-- end col-->
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