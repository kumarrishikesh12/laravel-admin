<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Auth;

class UserController extends Controller
{
    protected $image_dir;
    protected $image_url;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.list',compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'firstname' => 'required|max:30',
            'lastname' => 'required|max:30',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'email' => 'required_without:mobile|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        );
        $response = array();
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = str_limit(str_slug($data['firstname'].' '.$data['firstname']),100).'-'.time(). '.'. $ext;
            $file->move($this->image_dir, $filename);
            $data['image'] = $filename;
        }else{
        }
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return redirect()->to('admin/users')->with('success_message',trans('admin/users.user_create_message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->image = $user->image!=''&&file_exists(USER_IMAGE_DIR.$user->image)?USER_IMAGE_URL.$user->image:'';
        return view('admin.users.show',compact(['user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user->image = $user->image!=''&&file_exists(USER_IMAGE_DIR.$user->image)?USER_IMAGE_URL.$user->image:'';
        return view('admin.users.form',compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            // 'id' => 'required|numeric|exists:users,id',
            'firstname' => 'sometimes|required|max:30',
            'lastname' => 'sometimes|required|max:30',
            'username' => 'sometimes|string|max:255|unique:users|alpha_dash',
            'status' => 'sometimes|required|in:0,1',
            'password_confirmation' => 'required_with:password|same:password'
        );
        $response = array();
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            if($request->ajax()){
                $response['status'] = false;
                $response['message'] = $validator->messages()->first();
                return response()->json($response, 200);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $request->id = $request->id!=''?$request->id:$id;
        $user = User::findOrFail($request->id);
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $oldFile = USER_IMAGE_DIR.$user->image;
            if(File::exists($oldFile)){
                File::delete($oldFile);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = str_limit(str_slug($data['firstname'].' '.$data['firstname']),100).'-'.time(). '.'. $ext;
            $file->move(USER_IMAGE_DIR, $filename);
            $data['image'] = $filename;
        }else{
            $data['image'] = $user->image;
        }
        if($request->password==''){
            unset($data['password']);
        }
        else{
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);
        if($request->ajax()){
            $response['status'] = true;
            $response['message'] = trans('admin/users.user_update_message');
            return response()->json($response, 200);
        }
        return redirect()->back()->with('success_message', trans('admin/users.user_update_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::destroy($request->id);
        $response = array();
        $response['status'] = true;
        $response['message'] = trans('admin/users.user_delete_message');
        return response()->json($response, 200);
    }


}
