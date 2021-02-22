<div class="row">
  <div class="col-sm-12">
    <div class="card-box">
      <h4 class="header-title"><span class="badge badge-danger"></span>
        <button type="button" class="btn btn-lg btn-danger waves-effect waves-light">
            <span class="btn-label"><i class="mdi mdi-bell-check-outline"></i></span>{{count($NotificationList)}}
        </button>
      </h4>
      
      
    <div class="table-responsive">
      <div class="form-group">
        <input type="text" id="search" class="form-control ">
      
      </div>

     
          
            @foreach($NotificationList as $index => $item)              

            <a  href="{{ url('/').''.$item->reference }}"  >
              <div class="card-box mb-2" >
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <div class="media">
                          @php
                            $link = 'assets/images/notification/'.$item->entity.'.png';
                          @endphp
                            <img class="d-flex align-self-center mr-3 rounded-square" src="{{ asset($link) }}" alt="Generic placeholder image" height="44">
                            <div class="media-body ml-2">
                                <h4 class="mt-0 mb-2 font-16">
                                  @if($item->entity == 'USER_ADD')
                                   A New User Has Been Added
                                  @elseif($item->entity == 'PROJECT_ADD')
                                   A New Project Has Been Added
                                  @elseif($item->entity == 'PROJECT_MEMBER_ADD')
                                   A New Project Member Has Been Added
                                  @elseif($item->entity == 'TASK_ADD')
                                   A New Task Has Been Added
                                  @elseif($item->entity == 'TASK_REASSIGNED')
                                   An Old Task Has Been Reassigned
                                  @elseif($item->entity == 'TASK_STATUS_UPDATE')
                                   A Task Status Has Been Updated
                                  @elseif($item->entity == 'TASK_SUBMIT')
                                   A Task Status Has Been Submitted
                                  @elseif($item->entity == 'TASK_START')
                                   A Task Status Has Been Started
                                  @elseif($item->entity == 'TASK_RESUBMIT')
                                   A Task Status Has Been Resubmitted
                                  @elseif($item->entity == 'PASSWORD_CHANGED')
                                   Your Password Has Been Changed
                                  @elseif($item->entity == 'DESK_OPEN')
                                   Desk Opened
                                  @elseif($item->entity == 'DESK_CLOSE')
                                   Desk Closed
                                  @elseif($item->entity == 'OFF_DESK')
                                   Desk Pause
                                  @elseif($item->entity == 'ON_DESK')
                                   Desk Continue
                                  @else
                                   A Task Has Been Evaluated
                                  @endif
                                </h4>
                                <p class="mb-1 text-secondary" >{!! $item->details !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-center my-3 my-sm-0">
                            <p class="mb-0 text-muted"><i data-feather="bell" class="icon-dual-primary icons-xs  "></i> &nbsp{{ date("F jS, Y", strtotime($item->created_at)) }} {{ date('h:i A', strtotime($item->created_at)) }}</p>
                            <p></p>
                            <p class="mb-0 text-muted">
                              <i data-feather="check-circle" class="icon-dual-success icons-xs "></i> &nbsp{{ date("F jS, Y", strtotime($item->read_at)) }} {{ date('h:i A', strtotime($item->read_at)) }}
                            </p>
                        </div>
                    </div>
                    
                </div> <!-- end row -->
            </div>
          </a>
            @endforeach 

            
          
      
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