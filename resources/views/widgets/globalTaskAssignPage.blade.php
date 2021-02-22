
<div class="container-fluid">
   
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
          <div class="card-body">

            <h4 class="mb-3 header-title">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTask">
                Add Task
              </button>
            </h4>

            <!-- Modal -->
            <div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="col-12 mb-3">
                      <select id="project_id" class="form-control " name="project_id" required>
                          <option value="">Choose Project</option>
                          @foreach ($ProjectList as $item)
                              <option value="{{ $item->id }}">{{ $item->title }}</option>
                          @endforeach                          
                      </select>
                    </div>

                    <div class="col-12 mb-3">
                      <select id="project_member" class="form-control" name="project_member" required>
                        <option value="">Choose Project Member</option>
                          
                      </select>
                    </div>

                    <div class="col-12 mb-3">
                      <input type="text"  class="form-control title" id="inputEmail3" name="title" placeholder="Title" required>
                    </div>

                    <div class="col-12 mb-3">
                      <textarea type="text" class="form-control description" rows="7"  name="description"  placeholder="Description" required></textarea> 
                    </div>

                    <div class="col-12 mb-3">
                      <input type="date" class="form-control submission_date" name="submission_date" id="sdate" required>
                    </div>

                    <div class="col-12 mb-3">
                      <input type="time" class="form-control submission_time" name="submission_time" id="stime" required>
                    </div>

                    <div class="col-12 mb-3">
                      <select  class="form-control mr-4 task_type" name="task_type" required>
                        <option value="">Choose Type</option>
                        <option value="Task">Task</option>
                        <option value="Test">Test</option>
                      </select>
                    </div>

                    <div class="col-12 mb-3">
                      <select class="form-control priority mr-4" name="priority" required>
                        <option value="">Choose Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                      </select>
                    </div>

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light submit">Submit</button>
                  </div>
                </div>
              </div>
            </div>

            @if(session('task'))
                <div class="alert alert-success" role="alert">
                    {{session('task')}}
                </div>                    
            @endif

            <p class="alert alert-success" id="msg"></p>

      


            

        <h4 class="mb-3 header-title">Task List</h4>
        <div class="form-group">
            <input type="text" id="search" class="form-control ">          
        </div>

        
        <div class="table-responsive">
            <table  class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Project Name</th>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Sub Date</th>
                        <th>Sub Time</th>
                        <th>Status</th>
                        <th>Revision Type</th>
                        <th>Task Type</th>
                        <th>Priority</th>
                        <th>Testable</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Satisfaction</th>
                        <th>Action</th>                                
                    </tr>
                </thead>
            
            
                <tbody id="TableList">
                

                    
                    
                
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

        
    $("#search").on("keyup", function() {
        var value = $(this).val().toUpperCase();
        $("#TableList tr").each(function(index) {
            if (index !== 0) {
                $row = $(this);
                var id = $row.text().toUpperCase();
                if (id.indexOf(value) !== -1) {
                    $row.show();
                }
                else {
                    $row.hide();
                }
            }
        });
    });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        tableData();

        $("#msg").hide()
        $('.submit').attr('disabled','disabled');
        $('.title').attr('disabled','disabled');
        $('.description').attr('disabled','disabled');
        $('.submission_date').attr('disabled','disabled');
        $('.submission_time').attr('disabled','disabled');
        $('.task_type').attr('disabled','disabled');
        $('.priority').attr('disabled','disabled');

        $('#project_member').on("change",function(){
            if($(this).val() != ''){
                $('.submit').removeAttr('disabled');
                $('.title').removeAttr('disabled');
                $('.description').removeAttr('disabled');
                $('.submission_date').removeAttr('disabled');
                $('.submission_time').removeAttr('disabled');
                $('.task_type').removeAttr('disabled');
                $('.priority').removeAttr('disabled');

                

            }else{
                $('.submit').attr('disabled','disabled');
                $('.title').attr('disabled','disabled');
                $('.description').attr('disabled','disabled');
                $('.submission_date').attr('disabled','disabled');
                $('.submission_time').attr('disabled','disabled');
                $('.task_type').attr('disabled','disabled');
                $('.priority').attr('disabled','disabled');



            }
        });

        $('#project_id').on("change",function(){
            if($(this).val() == ''){
                let member = $('#project_member');
                member.empty();
                member.append("<option value=''>Choose Project Member</option>");
            }else{
                let project_id = $("#project_id").val();
                let member = $('#project_member');
                member.empty();

                
                $.ajax({
                    type:'POST',
                    url:"{{ url('ajax/project/member') }}"+ "/" + project_id,
                    data: {"_token": "{{ csrf_token() }}"},
                    success:function(data){
                        member.append("<option value=''>Choose Project Member</option>");
                        $.each(data.data, function(key, value) {
                            member.append("<option value='"+ value.user_id +"'>" + value.name+ " - "+ value.role + "</option>");
                        });
                    }
                });

            }
        });
        

        $(".submit").click(function(event){
            event.preventDefault();
            var _token = "{{ csrf_token() }}";
            var project_id = $("#project_id").val();
            var project_member = $("#project_member").val();
            var title = $('.title').val();
            var description = $('.description').val();
            var submission_date = $('.submission_date').val();
            var submission_time = $('.submission_time').val();
            var task_type = $('.task_type').val();
            var priority = $('.priority').val();

            if( (project_id == '') ||  (project_member == '') ||  (title == '') ||  (description == '') ||  (submission_date == '') ||  (submission_time == '')  ||  (task_type == '') ||  (priority == '')) 
            {
                alert("Please Fill Up All The Field");
            }
            else{
                $.ajax({
                type:'POST',
                url:"{{ url('ajax/project') }}"+ "/" + project_id+"/member/"+project_member+"/tasks",
                data: {_token:_token, project_id:project_id, project_member:project_member, title:title, description:description, submission_date:submission_date, submission_time:submission_time, task_type:task_type, priority:priority },
                success:function(data){
                    $('#addTask').modal('hide');
                    $("#msg").show();
                    $("#msg").html(data.status);
                    $("#msg").fadeOut(10000);
                    var project_id = $("#project_id").val('');
                    var project_member = $("#project_member").val('');
                    var title = $('.title').val('');
                    var description = $('.description').val('');
                    var submission_date = $('.submission_date').val('');
                    var submission_time = $('.submission_time').val('');
                    var task_type = $('.task_type').val('');
                    var priority = $('.priority').val('');

                    tableData();
                    
                }
            });
            }
            

        });

        
        function tableData() {
            let TableList = $('#TableList');
            $.ajax({
                type:'get',
                url:"{{ url('ajax/task/list') }}",
                data:{},
                success:function(data){
                    TableList.empty();
                    $.each(data.TaskList, function(key, value) {
                        TableList.append(`<tr>
                            <td>${++key}</td>
                            <td>${ value.project_name }</td>
                            <td>${ value.task_id }</td>
                            <td>${ value.title }</td>
                            <td>${ value.submission_date }</td>
                            <td>${ value.submission_time }</td>
                            <td> <span ${ value.status == 'Accepted' ? 'class="badge badge-success"' : 'class="badge badge-secondary"'}>${ value.status }</span></td>
                            <td>${ value.revision_type }</td>
                            <td>${ value.task_type }</td>
                            <td>${ value.priority }</td>
                            <td>${ value.testable }</td>
                            <td>${ value.from }</td>
                            <td>${ value.to }</td>
                            <td>${ (value.satisfaction_level == 0) ? 'N/A': value.satisfaction_level  }</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ url('project') }}/${value.project_id}/member/${value.member_id}/task/${value.task_id}">View</a>
                            </td> 
                          </tr>`);
                    });
                }
            });
        }
        
    });
</script>
@endpush


