@if(Auth::user()->type == 1)
<div class="row">
    <div class="col-md-6 col-xl-3">
      <a href="{{ url('/projects') }}">
        <div class="card-box">
          <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
          <h4 class="mt-0 font-16">Total Projects</h4>
          <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{Count($TotalProject)}}</span></h2>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-xl-3">
      <a href="{{ url('total/completed/project') }}">
        <div class="card-box">
          <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
          <h4 class="mt-0 font-16">Total Completed Projects</h4>
          <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{$TotalCompletedProject}}</span></h2>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-xl-3">
      <a href="{{ url('global/task/assign') }}">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16">Total Tasks</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{Count($TotalTask)}}</span></h2>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-xl-3">
      <a href="{{ url('member/accepted/tasks') }}">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16">Total Accepted Tasks</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{$TotalAcceptedTask}}</span></h2>
        </div>
      </a>
    </div>

</div> <!-- end row -->
@endif

@if(Auth::user()->type == 2)
<div class="row">
    <div class="col-md-6 col-xl-4">
      <a href="{{ url('/my/projects/list') }}">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16">Total Projects</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{Count($TotalProject)}}</span></h2>
        </div>
      </a>
    </div>

   

    <div class="col-md-6 col-xl-4">
      <a href="{{ url('/member/tasks') }}">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16">Total Tasks</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{Count($TotalTask)}}</span></h2>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-xl-4">
      <a href="{{ url('/member/accepted/tasks') }}">
        <div class="card-box">
          <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
          <h4 class="mt-0 font-16">Total Accepted Tasks</h4>
          <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{$TotalAcceptedTask}}</span></h2>
        </div>
      </a>
    </div>

    
</div> <!-- end row -->
@endif



{{-- For Team Type  --}}
@if(Auth::user()->type == 1)
<div class="row">

    @foreach($TotalProject as $index => $item)
        <div class="col-lg-4">
            <div class="card-box bg-pattern">
                <div class="text-center">
                    @if($item->image)
                        <img src="{{ asset($item->image) }}" alt="logo" class="avatar-xl rounded-circle mb-3">
                    @else
                        <img src="{{ asset( url('assets/images/companies/amazon.png')) }}" alt="logo" class="avatar-xl rounded-circle mb-3">
                    @endif
                    <h4 class="mb-1 font-20">{{ $item->title }} </h4>
                    <p class="text-muted  font-14">{{ $item->client_name }}</p>
                </div>

                {{-- <p class="font-14 text-center text-muted">
                    Amazon.com, Inc., doing business as Amazon, is an American electronic commerce and cloud computing company based in Seattle..
                </p> --}}

              

                <div class="text-center">
                    <a href="{{ url('project/details') }}/{{$item->id }}" class="btn btn-sm btn-light">View more info</a>
                </div>
               
               

                <div class="row mt-4 text-center">
                    <div class="col-6">
                        <h5 class="font-weight-normal text-muted">Total Assigned Member</h5>
                        <h4>{{ $item->totalMember }}</h4>
                    </div>
                    <div class="col-6">
                        <h5 class="font-weight-normal text-muted">Total Task</h5>
                        <h4>{{$item->totalTask}}</h4>
                    </div>
                </div>
            </div> <!-- end card-box -->
        </div><!-- end col -->
    @endforeach

  
    
</div>
@endif

 {{-- For Admin Type  --}}
  @if(Auth::user()->type == 2)
<div class="row">
    @foreach($TotalProject as $index => $item)
        <div class="col-lg-4">
            <div class="card-box bg-pattern">
                <div class="text-center">
                    @if($item->image)
                        <img src="{{ asset($item->image) }}" alt="logo" class="avatar-xl rounded-circle mb-3">
                    @else
                        <img src="{{ asset( url('assets/images/companies/amazon.png')) }}" alt="logo" class="avatar-xl rounded-circle mb-3">
                    @endif
                    <h4 class="mb-1 font-20">{{ $item->title }} </h4>
                    <p class="text-muted  font-14">{{ $item->client_name }}</p>
                </div>

                {{-- <p class="font-14 text-center text-muted">
                    Amazon.com, Inc., doing business as Amazon, is an American electronic commerce and cloud computing company based in Seattle..
                </p> --}}                

                <div class="text-center">
                    <a href="{{ url("my/projects/{$item->id}/details") }}" class="btn btn-sm btn-light">View more info</a>
                </div>
                

                <div class="row mt-4 text-center">
                    <div class="col-6">
                        <h5 class="font-weight-normal text-muted">Total Assigned Member</h5>
                        <h4>{{ $item->totalMember }}</h4>
                    </div>
                    <div class="col-6">
                        <h5 class="font-weight-normal text-muted">Total Task</h5>
                        <h4>{{$item->totalTask}}</h4>
                    </div>
                </div>
            </div> <!-- end card-box -->
        </div><!-- end col -->
    @endforeach
</div>
@endif