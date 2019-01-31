<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User as User;
use Hash;
use Validator;
use File;
use auth;

class ProfileController extends Controller
{
    protected $auth;
    
    public function __construct() {
        $this->auth = auth()->user();
    }

    public function profile() {
        $profile = User::find(Auth::user()->id);
 
        if ($profile) {
            return view('profile', compact('profile'));
        } else {
            return redirect('profile')->with('error_message',  trans('user/profile.invalidDetail'));
        }
        return view('changePassword',compact('profile'));
    }
    
    public function update(Request $request) {
        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email'
        );
        $user = User::findOrFail(Auth::user()->id);

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
       
                    $oldFile = USER_IMAGE_DIR.$user->image;
                    
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = 'user_'.time().'.'. $ext;
                $targetPath = USER_IMAGE_DIR;
                $file->move($targetPath, $filename);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['image'] = $filename;
        }else{
            $data['image'] = $user->image;
        }
        
        $user->update($data);

        return redirect()->back()->with('success_message', trans('user/profile.successfullyChanged'));
    }
    
    public function changePassword() {

        return view('changePassword');
    }
    
    public function updatePassword(Request $request) {

        $data = $request->all();
        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($data['current_password'], $user->password)) {
            return redirect()->back()->with('error_message', trans('user/changePassword.validPassword'));
        } else {
            $rules = array(
                'password' => 'required|confirmed|min:5',
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user->password = Hash::make($data['password']);
            $user->save();
            return redirect()->back()->with('success_message', trans('user/changePassword.successfullyChanged'));
        }
    }
}
