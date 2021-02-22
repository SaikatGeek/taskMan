<!-- Start Content-->
<div class="container-fluid">
    
    

         

    <div class="row">
        @foreach($UserList as $item)
        <div class="col-lg-4">
            <div class="text-center card-box">
                <div class="pt-2 pb-2">
                    <img src="{{ asset($item->image) }}" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                    <h4 class="mt-3 text-dark">{{ $item->name }}</h4>
                    <p class="text-muted">{{ $item->designation }} <span> | </span> 
                    <span class="text-muted">{{ $item->phone }}</span> <span> | </span> <span class="text-muted">{{ $item->email }}</span></p>

                    <!-- <a type="button"  href="{{ url('/') }}" class="btn btn-primary btn-sm waves-effect waves-light">Message</a> -->

                   

                </div> <!-- end .padding -->
            </div> <!-- end card-box-->
        </div> <!-- end col -->
        @endforeach

        
    </div>
    <!-- end row -->

   
    
</div> <!-- container -->

