<div class="row">
  <div class="col-sm-12">
    <div class="card-box">
      <h4 class="header-title">Accepted Task List</h4>

    <div class="table-responsive">
        <div class="form-group">
          <input type="text" id="search" class="form-control ">
        
        </div>

      <table id="table" class="table table-striped table-hover">
          <thead >
            <tr>
              <th >SL</th>
              <th >TaskId</th>
              <th >Title</th>
              <th >Project</th>
              <th >Assigned To</th>
              <th >Assigned By</th>
              <th >Assigned Date</th>
              <th >Submission Time</th>
              <th >Accepted Time</th>
              <th >Type</th>
              <th >View</th>
            </tr>
          </thead>

          <tbody>
            @foreach($TaskList as $index => $item)
              <tr>                      
                <td>{{ ++$index }}</td>
                <td>{{ $item->task_id }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->project->title }}</td>
                <td>{{ $item->developer->name  }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ date("d/m/Y", strtotime($item->created_at)) }}</td>
                <td>{{ date('h:i A', strtotime($item->submission_time)) }}</td>
                <td>{{ date('d/m/Y h:i A', strtotime($item->taskStatus->created_at)) }}</td>
                <td>{{ $item->task_type }}</td>                
                <td><a class="btn btn-primary btn-sm" 
                  href="{{ url('project').'/'.$item->project_id.'/member/'.$item->user_id.'/task/'.$item->task_id }}" >View</a></td>             
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