<?php

namespace App\Exports;

use App\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
	public function view(): View
    {
    	$products = Product::select('products.*','c.name as category_name')
    				->whereIn('products.id',$_POST['product'])
        			->leftjoin('categories as c',function($join){
		                $join->on('c.id','products.category_id');
		            })
        			->get();
        return view('admin.exports.products', compact(['products']));
    }

    public function collection()
    {
    	$request = new Request;
        $products = Product::select('products.*','c.name as category_name')
    				->whereIn('products.id',$_POST['product'])
        			->leftjoin('categories as c',function($join){
		                $join->on('c.id','products.category_id');
		            })
        			->get();
        foreach($products as $key=>$val){
        	$data = json_decode($val->data);
        	foreach($data as $k=>$v){
        		$products[$key]->$k = $v;
        		if(is_array($products[$key]->$k)){
        			$products[$key]->$k = implode(',',$products[$key]->$k);
        		}
        	}
        	// echo $key;exit;
        	unset($products[$key]->data);
        }
        return $products;
    }
}