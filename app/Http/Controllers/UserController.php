<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helper;

class UserController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth')->except('logout');
    }
    
    public function addUser(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users'
        ]);

        // dd($request->image);

        $User = new User;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->phone = $request->phone;
        $User->password = Hash::make($request->password);
        $User->type = $request->type;
        $User->designation = $request->designation;
        $User->status = 1;
        $User->save();

        $imageName = "U-{$User->id}.{$request->image->extension()}";  
        $request->image->move(public_path('images/profile'), $imageName);

        $User->image = 'images/profile/'.$imageName;
        $User->save();

        $reference = '/users';
        $Admins = User::where('type', 1)->get();

        foreach ($Admins as $key => $value) {
            $details = '<b>'.Auth::user()->name.'</b> has created a new user named <b>'. $request->name . '</b>.';
            Helper::notify($details, $reference, Auth::id(), $value->id, 'USER_ADD');                
        }

        $details = '<b>'.Auth::user()->name.'</b> has added you as a new user. Welcome to Task Management Software of SoftX Innovation Limited. Change your password now.';
        Helper::notify($details, '/password/change', Auth::id(), $User->id, 'USER_ADD'); 
        
        return redirect()->back()->with('message', 'New User Created Successfully!');
    }

    public function UserPage(){
        $UserList = User::orderBy('id', 'desc')->get();
        return view('user', compact('UserList'));
    }

    public function passwordChange(Request $request){
        if($request->isMethod('get')){
            return view('passwordChange');
        }
        else{
            $request->validate([
                'old_password' => 'required',
                'password' => 'required',                
            ]);
            $User = Auth::user();
            $hashedPassword = $User->password;

            if (Hash::check($request->old_password, $hashedPassword)) {
               $PasswordChange = User::find($User->id);
               $PasswordChange->password = Hash::make($request->password) ;
               $PasswordChange->save();
               $details = 'Your password has been changed by you';
               Helper::notify($details, '/', Auth::id(), Auth::id(), 'PASSWORD_CHANGED'); 
               return redirect()->back()->with('message', 'Password Change Successfully!');
            }
            else{
                return redirect()->back()->with('error', 'Old Password Not Matched!');
            }
        }
    }




}
