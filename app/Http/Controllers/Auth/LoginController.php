<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login (Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'password' => 'required',
        ]);

        if ($request->isMethod('post')) {
          $phone = $request->phone;
          $password = $request->password;

          if (Auth::attempt(['phone' => $phone, 'password' => $password, 'status' => 1])) {
            // Authentication passed...            
            return redirect()->intended('/');              
          }
          else{
            $exist = User::where('phone', $phone)->count();
            if($exist == 1){              
              return redirect()->intended('/login')->with('error', 'Wrong Password');
            }else{              
              return redirect()->intended('/login')->with('error', 'Wrong Credential');
            }
          }
        }
        else{
            return view('auth.login');
        }
        
        
    }

    public function logout(Request $request) {
        // Auth::logout();
        // $request->session()->invalidate();    
        // $request->session()->regenerateToken();
        // return redirect('/login');

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?:  Redirect::to('/login', 301); ;
    }

    public function register (Request $request)
    {
      if($request->isMethod('post')){
        dd($request->all());
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|required_with:password_confirmation|confirmed',
            'password_confirmation' => 'required',
            'designation' => 'required|string',
            'phone' => 'required|numeric|max:11',
            'photo' => 'required|image|mimes:jpg,jpeg|size:1024'
        ]);

        if ($validator->fails()){
          return back()->withErrors($validator->errors());
        }


      }
      else{
        return view('auth.register');
      }

        
        
        
    }

    

}
