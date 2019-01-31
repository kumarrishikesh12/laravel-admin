<?php

namespace App\Http\Controllers\Admin;

use App\ProductAttribute;
use App\Http\Controllers\Controller;
use App\Attribute;
use App\Marketplace;
use Illuminate\Http\Request;
use Auth;
use Validator;
use File;
use Carbon\Carbon;

class ProductAttributeController extends Controller
{
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
        $filters = array();

        $marketplaces = Marketplace::all()->pluck('name','id');
        $filters[2]['label'] = trans('admin/product_attributes.marketplace');
        foreach($marketplaces as $key=>$val){
            $filters[2]['data'][] = ['key'=>$key,'value'=>$val];
        }
        $attributes = Attribute::all()->pluck('name','id');
        $filters[3]['label'] = trans('admin/product_attributes.attribute');
        foreach($attributes as $key=>$val){
            $filters[3]['data'][] = ['key'=>$key,'value'=>$val];
        }
        $filters[5] = array('label'=>trans('admin/common.status'),'data'=>array(array('key'=>'0','value'=>trans('admin/common.inactive'),'icon'=>'icon-cross3'), array('key'=>'1','value'=>trans('admin/common.active'),'icon'=>'icon-check2') ));
        return view('admin.product_attributes.list',compact(['filters']));
    }

    public function data(Request $request){
        return datatables()->of(ProductAttribute::select('product_attributes.id','product_attributes.name','product_attributes.created_at','product_attributes.status','product_attributes.marketplace_id','product_attributes.attribute_id','a.name as attribute_name','m.name as marketplace_name')
            ->leftjoin('attributes as a',function($join){
                $join->on('a.id','product_attributes.attribute_id');
            })
            ->leftjoin('marketplaces as m',function($join){
                $join->on('m.id','product_attributes.marketplace_id');
            })
            ->get())
            ->editColumn('name', function ($item) {
                return ucfirst($item->name);
            })
            ->editColumn('attribute_name', function ($item) {
                return ucfirst($item->attribute_name);
            })
            ->editColumn('marketplace_name', function ($item) {
                return ucfirst($item->marketplace_name);
            })
            ->addColumn('action', function ($item) {
              if($item->status=='1')
                return '<button type="button" data-toggle="tooltip" title="'.trans('admin/common.active').'" class="btn btn-success btn-sm btn-status" data-id="'.$item->id.'" value="0"><i class="icon-check2"></i></button>';
              else
                return '<button type="button" data-toggle="tooltip" title="'.trans('admin/common.inactive').'" class="btn btn-warning btn-sm btn-status" data-id="'.$item->id.'" value="1"><i class="icon-cross3"></i></button>';
            })
            ->addColumn('action1', function ($item) {
                return '<a data-toggle="tooltip" title="'.trans('admin/common.edit').'" class="btn btn-primary btn-sm btn-edit" href="'.url('admin/productattributes').'/'.$item->id.'/edit"><i class="icon-pencil2"></i></a> 
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
        $attributes = Attribute::all()->pluck('name','id');
        $marketplaces = Marketplace::all()->pluck('name','id');
        return view('admin.product_attributes.form',compact(['marketplaces','attributes']));
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
            'marketplace_id' => 'required|numeric|exists:marketplaces,id',
            'attribute_id' => 'required|numeric|exists:attributes,id|unique:product_attributes,attribute_id,NULL,attribute_id,marketplace_id,'.$request->marketplace_id,
            'name' => 'required|max:191|unique:product_attributes,name,NULL,id,marketplace_id,'.$request->marketplace_id.',attribute_id,'.$request->attribute_id,
        );
        // print_r($rules);exit;
        $response = array();
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['created_by'] = $admin->id;
        ProductAttribute::create($data);
        return redirect()->to('admin/productattributes')->with('success_message',trans('admin/product_attributes.product_attribute_create_message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_attribute = ProductAttribute::findOrFail($id);
        return view('admin.product_attributes.show',compact(['product_attribute']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_attribute = ProductAttribute::findOrFail($id);

        $attributes = Attribute::all()->pluck('name','id');
        $marketplaces = Marketplace::all()->pluck('name','id');

        return view('admin.product_attributes.form',compact(['product_attribute','attributes','marketplaces']));
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
            'marketplace_id' => 'sometimes|required|numeric|exists:marketplaces,id',
            'attribute_id' => 'sometimes|required|numeric|exists:attributes,id|unique:product_attributes,attribute_id,'.$id.',id,marketplace_id,'.$request->marketplace_id,
            'name' => 'sometimes|required|max:191|unique:product_attributes,name,'.$id.',id,marketplace_id,'.$request->marketplace_id.',attribute_id,'.$request->attribute_id,
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
        $product_attribute = ProductAttribute::findOrFail($id);
        $product_attribute->update($data);
        if($request->ajax()){
            $response['status'] = true;
            $response['message'] = trans('admin/product_attributes.product_attribute_update_message');
            return response()->json($response, 200);
        }
        return redirect()->to('admin/productattributes')->with('success_message', trans('admin/product_attributes.product_attribute_update_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        ProductAttribute::destroy($request->id);
        $response = array();
        $response['status'] = true;
        $response['message'] = trans('admin/product_attributes.product_attribute_delete_message');
        return response()->json($response, 200);
    }
}
