<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductsList()
    {
        $products = Product::all();
        return $this->successWithData($products,'获取产品列表成功！');
    }

    /*
     * 添加产品
     * author vito
     *
     * */
    public function storeProduct(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|String'
        ]);
        $check_product = Product::where('name',trim($request->name))->first();
        if($check_product){
            return $this->fail("用产品已存在！");
        }
        $product = Product::create([
            'name' => trim($request->name),
            'image_url' => trim($request->image_url)?trim($request->image_url):null
        ]);
        if($product){
            return $this->success('添加成功！');
        }else{
            return $this->fail('添加失败！');
        }

    }
}
