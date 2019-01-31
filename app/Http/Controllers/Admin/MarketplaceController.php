<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Marketplace;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class MarketplaceController extends Controller
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
        $this->image_dir = MARKETPLACES_IMAGE_DIR;
        $this->image_url = MARKETPLACES_IMAGE_URL;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = array();
        $filters[3] = array('label'=>trans('admin/common.status'),'data'=>array(array('key'=>'0','value'=>trans('admin/common.inactive'),'icon'=>'icon-cross3'), array('key'=>'1','value'=>trans('admin/common.active'),'icon'=>'icon-check2') ));
        return view('admin.marketplaces.list',compact(['filters']));
    }

    public function data(Request $request){
        return datatables()->of(Marketplace::all())
            ->editColumn('name', function ($item) {
                return ucfirst($item->name);
            })
            ->addColumn('action', function ($item) {
              if($item->status=='1')
                return '<button type="button" data-toggle="tooltip" title="'.trans('admin/common.active').'" class="btn btn-success btn-sm btn-status" data-id="'.$item->id.'" value="0"><i class="icon-check2"></i></button>';
              else
                return '<button type="button" data-toggle="tooltip" title="'.trans('admin/common.inactive').'" class="btn btn-warning btn-sm btn-status" data-id="'.$item->id.'" value="1"><i class="icon-cross3"></i></button>';
            })
            ->addColumn('action1', function ($item) {
                return '<a data-toggle="tooltip" title="'.trans('admin/common.export_products').'" class="btn btn-primary btn-sm btn-export_products" href="'.url('admin/marketplaces').'/export_products/'.$item->id.'"><i class="icon-export2"></i></a> 
                <a data-toggle="tooltip" title="'.trans('admin/common.edit').'" class="btn btn-primary btn-sm btn-edit" href="'.url('admin/marketplaces').'/'.$item->id.'/edit"><i class="icon-pencil2"></i></a> 
                    <button type="button" data-toggle="tooltip" title="'.trans('admin/common.delete').'" class="btn btn-danger btn-sm btn-delete" data-id="'.$item->id.'"><i class="icon-trash2"></i></button>
                    ';
            })
            ->make(true);
    }

    public function buildTree(array $elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function export_products($id){
        $products = Product::select('products.id','products.name','c.name as category_name','c.id as cid','products.created_at','products.category_id','products.status')
            ->leftjoin('categories as c',function($join){
                $join->on('c.id','products.category_id');
            })
            ->get();
        return view('admin.marketplaces.export_products',compact(['products','id']));
    }

    public function export_marketplace_products(Request $request){
        /*$products = Product::select('products.*','c.name as category_name')
                    ->whereIn('products.id',$_POST['product'])
                    ->leftjoin('categories as c',function($join){
                        $join->on('c.id','products.category_id');
                    })
                    ->get();
        return view('admin.exports.products', compact(['products']));
        exit;*/
        return Excel::download(new ProductsExport, 'products.csv');
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
        // $categories = $this->buildTree($categories);
                        // print_r($categories);exit;
        return view('admin.marketplaces.form',compact(['categories']));
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
            'name' => 'required|max:191|unique:marketplaces',
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
        $data['categories'] = trim($data['categories'],',');
        /*$categories = isset($data['categories'])?explode(',',$data['categories']):array();
        $data['categories'] = json_encode($categories);*/
        $data['created_by'] = $admin->id;
        Marketplace::create($data);
        return redirect()->to('admin/marketplaces')->with('success_message',trans('admin/marketplaces.marketplace_create_message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marketplace = Marketplace::findOrFail($id);
        $marketplace->image = $marketplace->image!=''&&file_exists($this->image_dir.$marketplace->image)?$this->image_url.$marketplace->image:'';
        return view('admin.marketplaces.show',compact(['marketplace']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marketplace = Marketplace::findOrFail($id);
        $marketplace->image = $marketplace->image!=''&&file_exists($this->image_dir.$marketplace->image)?$this->image_url.$marketplace->image:'';

        $marketplace->mcategories = Category::whereIn('id',explode(',',$marketplace->categories))
                        ->get()->pluck('name','id');

        return view('admin.marketplaces.form',compact(['marketplace']));
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
            'name' => 'sometimes|required|max:191|unique:marketplaces,name,'.$id,
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
        $marketplace = Marketplace::findOrFail($id);
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $oldFile = $this->image_dir.$marketplace->image;
            if(File::exists($oldFile)){
                File::delete($oldFile);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = str_limit(str_slug($data['name']),100).'-'.$admin->id.'-'.time(). '.'. $ext;
            $file->move($this->image_dir, $filename);
            $data['image'] = $filename;
        }else{
            $data['image'] = $marketplace->image;
        }

        $marketplace->update($data);
        if($request->ajax()){
            $response['status'] = true;
            $response['message'] = trans('admin/marketplaces.marketplace_update_message');
            return response()->json($response, 200);
        }
        return redirect()->to('admin/marketplaces')->with('success_message', trans('admin/marketplaces.marketplace_update_message'));
    }

    public function searchcategory($search,$id='0'){
        $ids = explode(',',$id);
        $categories = Category::select('categories.id','categories.name','c.name as parent_name')
                        ->leftjoin('categories as c',function($join){
                            $join->on('c.id','categories.parent_id');
                        })
                        ->where('categories.name', 'LIKE', '%'.$search.'%')
                        ->whereNotIn('categories.id',$ids)
                        ->get();
        return response()->json($categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        
        Marketplace::destroy($request->id);
        $response = array();
        $response['status'] = true;
        $response['message'] = trans('admin/marketplaces.marketplace_deleted_message');
        return response()->json($response, 200);
    }
}
