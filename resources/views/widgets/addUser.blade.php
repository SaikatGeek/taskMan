<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Add User</h4>

                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{session('message')}}
                        </div>                    
                    @endif

                    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('users') }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="inputEmail3" class="col-4 col-form-label">Name</label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="inputEmail3" name="name" placeholder="Name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="designation" class="col-4 col-form-label">Designation</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="{{ old('designation') }}" required>
                                @error('designation')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="phone" class="col-4 col-form-label">Phone</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="Email" class="col-4 col-form-label">Email</label>
                            <div class="col-8">
                                <input type="email" class="form-control" id="Email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="inputPassword3" class="col-4 col-form-label">Password</label>
                            <div class="col-8">
                                <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password" value="{{ old('password') }}" required>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="inputState" class="col-4 col-form-label">Type</label>
                            <div class="col-8">
                                <select id="inputState" class="form-control" name="type" value="{{ old('type') }}" required>
                                    <option value="">Choose</option>
                                    <option value="2">Team</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div>        
                        
                        <div class="form-group  mb-3 ">
                            <label for="image">Profile Image</label>
                            <input type="file" id="image" name="image" class="form-control-file is-invalid " required>
                        </div>

                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                       
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-info waves-effect waves-light">Add User</button>
                            </div>
                        </div>
                    </form>

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->





        <div class="col-lg-8">
            

            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Users</h4>
                    <div class="form-group">
                        <input type="text" id="search" class="form-control ">          
                    </div>
                   
                    <div class="table-responsive">
                        <table  class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    
                                </tr>
                            </thead>
                        
                        
                            <tbody id="table">
                                @foreach ($UserList as $index=>$user)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>
                                            @if($user->image)
                                                <img src="{{ asset($user->image) }}" alt="" height="30px" width="30px" class="img-responsive">
                                            @else
                                                <img src="{{ asset('images\profile_image\user.png') }}" alt="" height="30px" width="30px" class="img-responsive">
                                            @endif
                                        </td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->designation}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->type == 1 ? 'Admin': 'Team'}}</td>                                    
                                        
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