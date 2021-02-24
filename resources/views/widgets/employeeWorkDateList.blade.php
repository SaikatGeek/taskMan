<div class="container-fluid">
   
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">     

            <h4 class="mb-3 header-title">Employee Work Date List</h4>
            <div class="form-group">
                <input type="text" id="search" class="form-control ">          
            </div>
            
            <div class="table-responsive">
                <table  class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Date</th>                            
                            <th>View</th>                                                          
                        </tr>
                    </thead>                
                
                    <tbody >                         
                      @foreach($List as $index => $entity)
                        <tr>
                          <td>{{ date('d/m/Y', strtotime($index) ) }}</td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('employee/workday').'/'.$index  }}">View</a>
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


        



