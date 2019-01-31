<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Validator;
use Auth;

class AdminController extends Controller
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
        $id = Auth::guard('admin')->user()->id;
        $admin = Admin::where('id', '!=', '1')->where('id','!=',$id)->get();
        return view('admin.admins.list',compact(['admin']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.form');
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
            'username' => 'required|string|max:150|unique:admins|alpha_dash',
            'email' => 'required_without:mobile|email|max:100|unique:admins',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'role' => '2',
        );
       
        $response = array();
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $data['firstname'].' '.$data['lastname'];
        $data['password'] = bcrypt($data['password']);
        $data['role'] = '2';
        /*unset($data['firstname']);
        unset($data['lastname']);*/
        Admin::create($data);
        return redirect()->to('admin/sub_admin')->with('success_message',trans('admin/users.user_create_message'));
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
        $admin = Admin::findOrFail($id);
        return view('admin.admins.form',compact(['admin']));
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
            'username' => 'sometimes|required|string|max:150|alpha_dash',
            'username' => 'sometimes|string|max:150|alpha_dash',
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
        $user = Admin::findOrFail($request->id);

        if($request->password==''){
            unset($data['password']);
        }
        else{
            $data['password'] = bcrypt($data['password']);
        }
        if(isset($data['firstname'])){
            $data['name'] = $data['firstname'].' '.$data['lastname'];
        }
        /*unset($data['firstname']);
        unset($data['lastname']);*/
        $user->update($data);
        if($request->ajax()){
            $response['status'] = true;
            $response['message'] = trans('admin/admin.admin_update_message');
            return response()->json($response, 200);
        }
        return redirect()->back()->with('success_message', trans('admin/admin.admin_update_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Admin::destroy($request->id);
        $response = array();
        $response['status'] = true;
        $response['message'] = trans('admin/admin.admin_delete_message');
        return response()->json($response, 200);
    }


}
