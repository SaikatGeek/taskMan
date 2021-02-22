
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Password Change</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{session('message')}}
                        </div>                    
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{session('error')}}
                        </div>                    
                    @endif

                    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('password/change') }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="old" class="col-4 col-form-label">Old Password</label>
                            <div class="col-8">
                                <input type="password" class="form-control" id="old" name="old_password" placeholder="Current Password" required>
                            </div>
                        </div>
                       

                        <div class="form-group row mb-3">
                            <label for="pass" class="col-4 col-form-label">New Password</label>
                            <div class="col-8">
                                <input type="password" class="form-control" id="pass" name="password" placeholder="New Password" required>
                            </div>
                        </div>
                                              
                        
                       
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-info waves-effect waves-light">Change Password</button>
                            </div>
                        </div>
                    </form>

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->


        <div class="col-lg-3"></div>


        

        
        
        

    </div>
</div>

