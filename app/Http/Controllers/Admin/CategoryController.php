<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use File;
use Carbon\Carbon;

class CategoryController extends Controller
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
        $this->image_dir = CATEGORY_IMAGE_DIR;
        $this->image_url = CATEGORY_IMAGE_URL;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = array();

        $categories = Category::select('categories.id','categories.name','c.name as parent_name')
                        ->leftjoin('categories as c',function($join){
                            $join->on('c.id','categories.parent_id');
                        })
                        ->get();
        $filters[2]['label'] = trans('admin/categories.parent');
        foreach($categories as $key=>$val){
            $filters[2]['data'][] = ['key'=>$val->id,'value'=>$val->name,'data-subtext'=>$val->parent_name];
        }
        $filters[4] = array('label'=>trans('admin/common.status'),'data'=>array(array('key'=>'0','value'=>trans('admin/common.inactive'),'icon'=>'icon-cross3'), array('key'=>'1','value'=>trans('admin/common.active'),'icon'=>'icon-check2') ));

        return view('admin.categories.list',compact(['filters']));
    }

    public function data(Request $request){
        return datatables()->of(Category::select('categories.id','categories.name','categories.created_at','categories.status','categories.parent_id','c.name as parent_name')
            ->leftjoin('categories as c',function($join){
                $join->on('c.id','categories.parent_id');
            })
            ->get())
            ->editColumn('name', function ($item) {
                return ucfirst($item->name);
            })
            ->editColumn('parent_name', function ($item) {
                return ucfirst($item->parent_name);
                // return '1';
            })
            ->addColumn('action', function ($item) {
              if($item->status=='1')
                return '<button type="button" data-toggle="tooltip" title="'.trans('admin/common.active').'" class="btn btn-success btn-sm btn-status" data-id="'.$item->id.'" value="0"><i class="icon-check2"></i></button>';
              else
                return '<button type="button" data-toggle="tooltip" title="'.trans('admin/common.inactive').'" class="btn btn-warning btn-sm btn-status" data-id="'.$item->id.'" value="1"><i class="icon-cross3"></i></button>';
            })
            ->addColumn('action1', function ($item) {
                return '<a data-toggle="tooltip" title="'.trans('admin/common.edit').'" class="btn btn-primary btn-sm btn-edit" href="'.url('admin/categories').'/'.$item->id.'/edit"><i class="icon-pencil2"></i></a> 
                    <button type="button" data-toggle="tooltip" title="'.trans('admin/common.delete').'" class="btn btn-danger btn-sm btn-delete" data-id="'.$item->id.'"><i class="icon-trash2"></i></button>
                    ';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('categories.id','categories.name','c.name as parent_name')
                        ->leftjoin('categories as c',function($join){
                            $join->on('c.id','categories.parent_id');
                        })
                        ->get();
        return view('admin.categories.form',compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $rules = array(
            'name' => 'required|max:191|unique:categories',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2024',
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
            $filename = str_limit(str_slug($data['name']),100).'-'.$admin->id.'-'.time(). '.'. $ext;
            $file->move($this->image_dir, $filename);
            $data['image'] = $filename;
        }else{
        }
        $data['created_by'] = $admin->id;
        Category::create($data);
        return redirect()->to('admin/categories')->with('success_message',trans('admin/categories.category_create_message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $category->image = $category->image!=''&&file_exists($this->image_dir.$category->image)?$this->image_url.$category->image:'';
        return view('admin.categories.show',compact(['category']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $category->image = $category->image!=''&&file_exists($this->image_dir.$category->image)?$this->image_url.$category->image:'';

        // $categories = Category::all()->pluck('name','id');

        $categories = Category::select('categories.id','categories.name','c.name as parent_name')
                        ->leftjoin('categories as c',function($join){
                            $join->on('c.id','categories.parent_id');
                        })
                        ->get();

        return view('admin.categories.form',compact(['category','categories']));
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
        $admin = Auth::guard('admin')->user();
        $rules = array(
            'name' => 'sometimes|required|max:191|unique:categories,name,'.$id,
            'image' => 'sometimes|mimes:jpeg,jpg,png,gif|max:1024',
            'status' => 'sometimes|required|in:0,1',
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
        $category = Category::findOrFail($id);
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $oldFile = $this->image_dir.$category->image;
            if(File::exists($oldFile)){
                File::delete($oldFile);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = str_limit(str_slug($data['name']),100).'-'.$admin->id.'-'.time(). '.'. $ext;
            $file->move($this->image_dir, $filename);
            $data['image'] = $filename;
        }else{
            $data['image'] = $category->image;
        }
        $category->update($data);
        if($request->ajax()){
            $response['status'] = true;
            $response['message'] = trans('admin/categories.category_update_message');
            return response()->json($response, 200);
        }
        return redirect()->to('admin/categories')->with('success_message', trans('admin/categories.category_update_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        Category::destroy($request->id);
        $response = array();
        $response['status'] = true;
        $response['message'] = trans('admin/categories.category_delete_message');
        return response()->json($response, 200);
    }
}
