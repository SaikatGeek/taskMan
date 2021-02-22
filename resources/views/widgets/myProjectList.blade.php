
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
                                <th>Id</th>
                                <th>Title</th>
                                <th>Client</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Deadline</th>
                                <th>Status</th>                                
                                <th>Action</th>                                
                            </tr>
                        </thead>
                    
                    
                        <tbody id="table">
                            @forelse  ($myProjectList as $index=>$project)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{$project->myProject->project_id}}</td>
                                    <td>{{$project->myProject->title}}</td>
                                    <td>{{$project->myProject->client_name}}</td>
                                    <td>{{ date('d/m/Y ', strtotime($project->myProject->start_date)) }}</td>
                                    <td>{{ date('d/m/Y ', strtotime($project->myProject->end_date)) }}</td>
                                    <td>{{ date('d/m/Y ', strtotime($project->myProject->deadline)) }}</td>
                                    <td>{{ $project->myProject->status }}</td>                                 
                                    <td>
                                        <a class="btn btn-primary" href="{{ url('my/projects').'/'.$project->project_id.'/details' }}">View</a>
                                      
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