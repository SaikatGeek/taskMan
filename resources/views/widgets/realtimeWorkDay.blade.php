<div class="container-fluid">
   
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">     

            <h4 class="mb-3 header-title">{{ date('j F, Y') }}</h4>
            <div class="form-group">
                <input type="text" id="search" class="form-control " Placeholder="Search">          
            </div>
            
            <div class="table-responsive">
                <table  class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Latest Time</th>
                            <th width="10%">Latest Status</th>
                            <th>Note</th>
                            <th>View</th>                                                          
                        </tr>
                    </thead>                
                
                    <tbody id="employeeHistory">                         
                    
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
$(document).ready(function() {
    GetEmployeeDataTable();

    var workHistory = window.setInterval(function(){
      GetEmployeeDataTable();
    }, 10000);

    function GetEmployeeDataTable() {
        let TableList = $('#employeeHistory');
        $.ajax({
            type:'get',
            url:"{{ url('ajax/employee/workday/daily/list') }}",
            data:{},
            success:function(data){
                TableList.empty();
                $.each(data, function(key, value) {
                    TableList.append(`<tr>
                        <td>${++key}</td>
                        <td>${ value.name }</td>
                        <td>${ value.designation }</td>
                        <td>${ value.time }</td>  
                        <td width="10%"> <span class="btn btn-sm btn-block
                            ${value.status == 'ON_DESK' ? 'btn-success':'' }
                            ${value.status == 'OFF_DESK' ? 'btn-danger':'' }
                            ${value.status == 'DESK_OPEN' ? 'btn-primary':'' }
                            ${value.status == 'DESK_CLOSE' ? 'btn-dark':'' }                                           
                        ">  
                            ${value.status == 'ON_DESK' ? 'ON':'' }
                            ${value.status == 'OFF_DESK' ? 'PAUSE':'' }
                            ${value.status == 'DESK_OPEN' ? 'OPENED':'' }
                            ${value.status == 'DESK_CLOSE' ? 'CLOSED':'' }
                        </td>  
                        <td>${ value.note }</td>  
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('employee/single/workday') }}/${value.id}">View</a>
                        </td>                      
                      </tr>`);
                });
            }
        });
    }




});
        
    
</script>
@endpush

























