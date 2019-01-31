<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use File;
use Carbon\Carbon;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        $filters = array();
        $filters[3] = array('label'=>trans('admin/common.status'),'data'=>array(array('key'=>'0','value'=>trans('admin/common.inactive'),'icon'=>'icon-cross3'), array('key'=>'1','value'=>trans('admin/common.active'),'icon'=>'icon-check2') ));
        return view('admin.attributes.list',compact(['filters']));
    }


    public function data(Request $request){
        return datatables()->of(Attribute::all())
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
                return '<a data-toggle="tooltip" title="'.trans('admin/common.edit').'" class="btn btn-primary btn-sm btn-edit" href="'.url('admin/attributes').'/'.$item->id.'/edit"><i class="icon-pencil2"></i></a> 
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
        $attributes = array("Text","Radio","File","Checkbox","Number","Search","Url","Color","Date","textarea");
        $type = Null;
        return view('admin.attributes.form',compact('attributes','type'));
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
            'name' => 'required|max:191|unique:attributes',
            'attributetype' => 'required|string',
        );
        $response = array();
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['created_by'] = $admin->id;
        $data['attributevalue'] = $request->input('attributevalue');
        Attribute::create($data);
        return redirect()->to('admin/attributes')->with('success_message',trans('admin/attributes.attributes_create_message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $attribute = Attribute::findOrFail($id);
       
       return view('admin.attributes.show',compact(['attribute']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $attribute = Attribute::findOrFail($id);
       $attributes = array("Text","Radio","File","Checkbox","Number","Search","Url","Color","Date","textarea");
       $type = $attribute->attributetype;
        return view('admin.attributes.form',compact(['attribute','attributes','type']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        $rules = array(
            'name' => 'sometimes|required|max:191|unique:attributes,name,'.$id,
            'status' => 'sometimes|required|in:0,1',
            'attributetype' => 'required|string',
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
        $attribute = Attribute::findOrFail($id);
        unset($data['formvalue']);
        $data['attributevalue'] = $request->input('attributevalue');
        $attribute->update($data);
        if($request->ajax()){
            $response['status'] = true;
            $response['message'] = trans('admin/attributes.attributes_update_message');
            return response()->json($response, 200);
        }
        return redirect()->to('admin/attributes')->with('success_message', trans('admin/attributes.attributes_update_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Attribute::destroy($request->id);
        $response = array();
        $response['status'] = true;
        $response['message'] = trans('admin/attributes.attributes_delete_message');
        return response()->json($response, 200);
    }
}
