@extends('layouts.reg')

@section('register')
<div class="card-body">

  <!-- Logo -->
  <div class="auth-brand text-center text-lg-left">
      <div class="auth-logo">
          <a href="index.html" class="logo logo-dark text-center">
              <span class="logo-lg">
                  <img src="{{ asset('assets/images/softx.png') }}" alt="" height="22">
              </span>
          </a>

          <a href="index.html" class="logo logo-light text-center">
              <span class="logo-lg">
                  <img src="{{ asset('assets/images/softx.png') }}" alt="" height="22">
              </span>
          </a>
      </div>
  </div>

  <!-- title-->
  <h4 class="mt-0">Sign Up</h4>
  @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div>{{$error}}</div>
     @endforeach
 @endif

  <!-- form -->
  <form action="{{ url('/register') }}" method="post" >
    @csrf

    <div class="form-group">
      <label for="name">Name</label>
      <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" placeholder="Enter your Email" value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
      <label for="phone">Phone Number</label>
      <input class="form-control @error('phone') is-invalid @enderror" type="phone" id="phone" name="phone" placeholder="Enter your phone" value="{{ old('phone') }}" required>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <div class="input-group input-group-merge">
        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required>
        <div class="input-group-append" data-password="false">
          <div class="input-group-text">
            <span class="password-eye"></span>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="password_confirmation">Password Confirmation</label>
      <div class="input-group input-group-merge">
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter your confirm password" required>
        <div class="input-group-append" data-password="false">
          <div class="input-group-text">
            <span class="password-eye"></span>
          </div>
        </div>
      </div>
    </div>


    <div class="form-group">
      <label for="designation">Designation</label>
      <input class="form-control @error('designation') is-invalid @enderror" type="text" id="designation" name="designation" placeholder="Enter your Designation" value="{{ old('designation') }}" required>
    </div>

    <div class="form-group  mb-3">
      <label for="image">Project Image</label>
      <input type="file" id="image" name="image" class="form-control-file">
    </div>

    <div class="form-group mb-0 text-center">
      <button class="btn btn-primary btn-block" type="submit">Sign Up</button>
    </div>
    <!-- social-->
      
  </form>
    <!-- end form-->


</div> <!-- end .card-body -->
@endsection