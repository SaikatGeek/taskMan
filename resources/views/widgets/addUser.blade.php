<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">   
            <div class="card">
                <div class="card-body">
                @if(session('message'))
                    <div class="alert alert-success mb-3" role="alert" >
                        {{session('message')}}
                    </div>                    
                @endif
                <button  type="button" class="btn btn-secondary" data-toggle="modal" data-target="#scrollable-modal">Add User</button>

                    

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->



        <div class="col-lg-12">
            

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
                                    <th>Edit</th>
                                    
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
                      <td>
                        <button  type="button" class="btn btn-secondary" data-toggle="modal" data-target="#UserEdit{{$index}}">Edit</button>
                      </td>                                    
                      
                  </tr>


                  <!-- Long Content Scroll Modal -->
                <div class="modal fade" id="UserEdit{{$index}}" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable" role="document">
                      <div class="modal-content">
                          <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('users/update') }}">
                          <div class="modal-header">
                              <h5 class="modal-title" id="scrollableModalTitle">Update User</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">

                              @csrf
                              <input type="hidden" name="id" value="{{ $user->id }}" >
                              <div class="form-group row mb-3">
                                  <label  class="col-4 col-form-label">Name</label>
                                  <div class="col-8">
                                      <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $user->name }}" required>
                                      @error('name')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                  </div>
                              </div>

                              <div class="form-group row mb-3">
                                  <label  class="col-4 col-form-label">Designation</label>
                                  <div class="col-8">
                                      <input type="text" class="form-control" name="designation" placeholder="Designation" value="{{ $user->designation }}" required>
                                      @error('designation')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                  </div>
                              </div>

                              <div class="form-group row mb-3">
                                  <label  class="col-4 col-form-label">Phone</label>
                                  <div class="col-8">
                                      <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ $user->phone }}" required>
                                      @error('phone')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                  </div>
                              </div>
                              <div class="form-group row mb-3">
                                  <label  class="col-4 col-form-label">Email</label>
                                  <div class="col-8">
                                      <input type="email" class="form-control"  name="email" placeholder="Email" value="{{ $user->email }}" required>
                                      @error('email')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                  </div>
                              </div>                              

                              <div class="form-group row mb-3">
                                  <label for="inputState" class="col-4 col-form-label">Type</label>
                                  <div class="col-8">
                                      <select id="inputState" class="form-control" name="type"  required>
                                          <option value="">Choose</option>
                                          <option {{ $user->type == 2 ? 'selected':''  }} value="2">Team</option>
                                          <option {{ $user->type == 1 ? 'selected':''  }} value="1">Admin</option>
                                      </select>
                                  </div>
                              </div>        
                              
                              <div class="form-group  mb-3 ">
                                  <label for="image">Profile Image</label>
                                  <input type="file" id="image" name="image" class="form-control-file is-invalid " >
                              </div>

                              @error('image')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-info waves-effect waves-light">Update User</button>
                          </div>
                      </form>
                      </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal --> 
              @endforeach
                                
                                
                            
          </tbody>
                        </table>
                    </div>
                   

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->

        
        
        

    </div>
</div>


<!-- Long Content Scroll Modal -->
<div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('users') }}">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableModalTitle">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

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
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info waves-effect waves-light">Add User</button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 

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