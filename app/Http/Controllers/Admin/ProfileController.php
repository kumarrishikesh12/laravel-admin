<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Admin as Admin;
use Hash;
use Validator;
use File;

class ProfileController extends Controller
{
    protected $auth;
    
    public function __construct() {
        $this->auth = auth()->guard('admin');
    }
    
    public function index() {
        $this->middleware('auth.admin');
        $profile = Admin::find($this->auth->user()->id);
        
        if ($profile) {
            return view('admin/profile', compact('profile'));
        } else {
            return redirect('admin/profile')->with('error_message', "Invalid detail.");
        }
    }
    
    public function update(Request $request) {

        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email'
        );
        $admin = Admin::findOrFail($this->auth->user()->id);

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                
                $oldFile = ADMIN_IMAGE_PATH.$admin->image;
                
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
                
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = 'admin.'. $ext;
                $targetPath = ADMIN_IMAGE_PATH;
                $file->move($targetPath, $filename);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['image'] = $filename;
        }else{
            $data['image'] = $admin->image;
        }
        
        $admin->update($data);

        return redirect()->route('profile.index')->with('success_message', "Your profile is updated successfully.");
    }
    
    public function changePassword() {

        return view('admin/changePassword');
    }
    
    public function updatePassword(Request $request) {
        $data = $request->all();
        $admin = Admin::findOrFail($this->auth->user()->id);

        if (!Hash::check($data['current_password'], $admin->password)) {
            return redirect()->back()->with('error_message', "Please enter valid current password.");
        } else {
            $rules = array(
                'password' => 'required|confirmed|min:5',
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $admin->password = Hash::make($data['password']);
            $admin->save();
            return redirect()->back()->with('success_message', "Password changes successfully.");
        }
    }
}
