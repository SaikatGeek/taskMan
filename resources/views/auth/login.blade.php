@extends('layouts.auth')

@section('login')
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
  <h4 class="mt-0">Sign In</h4>
  <p class="text-muted mb-4">Enter your mobile number and password to access account.</p>
  @if(session('error'))
      <div class="alert alert-danger" role="alert">
          {{session('error')}}
      </div>                    
  @endif

  <!-- form -->
  <form action="{{ url('login') }}" method="post" >
    @csrf

    <div class="form-group">
      <label for="phone">Phone Number</label>
      <input class="form-control" type="phone" id="phone" name="phone" placeholder="Enter your phone" value="{{ old('phone') }}" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <div class="input-group input-group-merge">
        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
        <div class="input-group-append" data-password="false">
          <div class="input-group-text">
            <span class="password-eye"></span>
          </div>
        </div>
      </div>
    </div>
    
    
    <div class="form-group mb-0 text-center">
      <button class="btn btn-primary btn-block" type="submit">Log In </button>
    </div>
    <!-- social-->
      
  </form>
    <!-- end form-->


</div> <!-- end .card-body -->
@endsection